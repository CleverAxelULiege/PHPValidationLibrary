<?php

namespace App\FactorySearch;

use App\FactorySearch\Parent\AbstractSearcher;
use App\Helper\NumberHelper;
use Exception;

//https://stackoverflow.com/questions/5674117/how-do-i-parse-a-csv-file-to-grab-the-column-names-first-then-the-rows-that-rela
class SearchCSV extends AbstractSearcher
{

    public function isSearchSuccessfull(): bool
    {
        if($this->getOptions("path") == null){
            throw new Exception("The key \"path\" must be precised.");
        }
        
        $path = $this->getBasePath() . $this->getOptions("path");
        if (file_exists($path) == false) {
            throw new Exception("File does not exist with the path " . $path);
        }

        $specificColumn = $this->getOptions("column");
        $valueToSearch = mb_strtolower($this->getValueToSearch() ?? "", "UTF-8");

        try {
            $handle = fopen($path, "r");
            $columnNames = [];

            if(is_null($specificColumn) == false){
                $columnNames = fgetcsv($handle);
            }

            $index = null;

            if ($specificColumn != null) {
                $index = $this->getIndexSpecificColumn($columnNames, $specificColumn);
            }

            while (($data = fgetcsv($handle)) !== false) {
                if (is_null($specificColumn) && $this->doesAnyfieldContainValue($valueToSearch, $data)) {
                    return true;
                } else if (is_null($specificColumn) == false && $this->doesSpecificColumnContainValue($valueToSearch, $data[$index])) {
                    return true;
                }
            }
            return false;
        } finally {
            fclose($handle);
        }
    }

    private function doesAnyfieldContainValue(string $valueToSearch, array &$data)
    {
        foreach ($data as $d) {
            if (mb_strtolower($d, "UTF-8") == $valueToSearch) {
                return true;
            }
        }

        return false;
    }

    private function doesSpecificColumnContainValue(string $valueToSearch, mixed $valueFromData)
    {
        return $valueToSearch == mb_strtolower($valueFromData, "UTF-8");
    }

    private function getIndexSpecificColumn(array $columnNames, int|string $column): int
    {
        if(NumberHelper::isInteger($column) && (int)$column < count($columnNames)){
            return $column;
        }

        $index = array_search((string)$column, $columnNames);
        if ($index === false) {
            throw new Exception("The index of the column name was not found or doesn't exist.");
        }

        return $index;
    }
}
