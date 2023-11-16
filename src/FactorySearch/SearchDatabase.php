<?php

namespace App\FactorySearch;

use App\Database\Parent\Database;
use App\Database\Parent\PostgresDatabase;
use App\FactorySearch\Parent\AbstractSearcher;
use App\Helper\NumberHelper;
use App\Helper\ValueHelper;
use BadMethodCallException;

class SearchDatabase extends AbstractSearcher{
    
    public function isSearchSuccessfull(): bool
    {
        /**
         * @var \App\Database\Parent\Database
         */
        $database = $this->getOptions("database");
        $column = $this->getOptions("column");
        $table = $this->getOptions("table");

        $this->tryThrowExceptions($database, $column, $table);

        $operatorComparaison = $this->getOperatorForComparaison($database);

        $result = $database->run("SELECT $column FROM $table WHERE $column $operatorComparaison :value LIMIT 1;", ["value" => $this->getValueToSearch()])->fetchColumn();

        if($result == false){
            return false;
        }

        return true;
    }

    private function getOperatorForComparaison(Database $database){
        $operatorComparaison = "=";

        if($database instanceof PostgresDatabase && NumberHelper::isFloat($this->getValueToSearch()) == false){
            $operatorComparaison = "ILIKE";
        }
        else if(NumberHelper::isFloat($this->getValueToSearch()) == false){
            $operatorComparaison = "LIKE";
        }

        return $operatorComparaison;
    }


    private function tryThrowExceptions(mixed $database, $column, $table){
        if(is_null($database) || is_null($column) || is_null($table)){
            throw new BadMethodCallException(
                "You must specify some keys to use this searcher and they can not be NULL :
                A database to use with a key \"database\", 
                a table to use with a key \"table\" 
                and a column to use with a key \"column\""
            );
        }

        if(($database instanceof Database) == false){
            throw new BadMethodCallException("The database must be an instance of the object App\\Database\\Parent\\Database");
        }

        if(!is_string($column) || !is_string($table)){
            throw new BadMethodCallException("The column and the table must be a STRING");
        }

        if(ValueHelper::isEmpty($this->getValueToSearch())){
            throw new BadMethodCallException("No value passed to search for.");
        }
        
        if(!in_array($table, $database->getTables())){
            throw new BadMethodCallException("The table given ($table) doesn't exist in the database " . $database::class);
        }

        if(!in_array($column, $database->getColumnsFromTable($table))){
            throw new BadMethodCallException("The column given ($column) doesn't exist in the database " . $database::class . " or in the table $table");
        }
    }
}