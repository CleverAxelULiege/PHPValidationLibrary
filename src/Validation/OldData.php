<?php

namespace App\Validation;

class OldData{
    private ?array $oldData;

    public function __construct(array $oldData = null)
    {
        $this->oldData =$oldData;
    }

    public function __invoke(string $key, string $defaultValue = null, $rawValue = false)
    {
        $data = $this->oldData[$key] ?? "";

        if($defaultValue != null && $data == ""){
            $data = $defaultValue;
        }
        
        if($rawValue){
            return $data;
        }

        echo htmlspecialchars($data);
    }
}