<?php

namespace App\Validation;

class ValidatorHelper{
    public static function rawDisplay(AbstractValidator $validator)
    {
        if ($validator->validate()) {
            echo "VALIDE <br>";
            echo "<pre>";
            var_dump($validator->getValidatedData());
            echo "</pre>";
        } else {
            echo "NON VALIDE <br>";
            echo "<pre>";
            var_dump($validator->getErrorMessages());
            echo "</pre>";
        }
    }

    public static function getOldData()
    {
        if (!isset($_COOKIE["old_data"])) {
            return new OldData(null);
        }

        $oldDatawithUri = json_decode($_COOKIE["old_data"], true);

        $uri = $oldDatawithUri["uri"] ?? null;
        $oldData = $oldDatawithUri["old_data"] ?? null;

        if ($uri != str_replace("index.php", "", $_SERVER['REQUEST_URI']) || empty($oldData)) {
            return new OldData(null);
        }

        return new OldData($oldData);
    }

    public static function displayErrorMessages(string $key = null)
    {
        if (!isset($_COOKIE["error_messages"])) {
            return;
        }

        $errorMessagesWithUri = json_decode($_COOKIE["error_messages"], true);

        $uri = $errorMessagesWithUri["uri"] ?? null;
        $errorMessages = $errorMessagesWithUri["messages"] ?? null;
        
        if ($uri != str_replace("index.php", "", $_SERVER['REQUEST_URI']) || empty($errorMessages)) {
            return;
        }

        //montre toutes les erreurs dans une liste
        if ($key == null) {
            echo "<ul>";
            foreach ($errorMessages as $messages) {
                foreach ($messages as $message) {
                    echo "<li>" . $message . "</li>";
                }
            }
            echo "</ul>";
            return;
        }

        if (isset($errorMessages[$key])) {
            echo "<ul>";
            foreach ($errorMessages[$key] as $message) {
                echo "<li>" . $message . "</li>";
            }
            echo "</ul>";
        }
    }
}