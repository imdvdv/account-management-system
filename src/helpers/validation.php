<?php

function validateFields (array|object $inputData, array $params = VALIDATION_PARAMS["fields"]): array {
    $result = [
        "errors" => [],
    ];

    foreach ($inputData as $key => $value) {

        if (array_key_exists($key, $params)){

            $result[$key] = removeExtraSpaces($value);

            if (empty($result[$key])) {

                $result["errors"][$key] = "$key is required";

            } elseif (!preg_match($params[$key]["pattern"], $result[$key])){

                $result["errors"][$key] = $params[$key]["error"];

            }
        }

    }
    return $result;
}

function validateFiles (array $files, array $params = VALIDATION_PARAMS["files"]): array {
    $result = [
        "errors" => [],
    ];

    foreach ($files as $key => $value) {

        if (array_key_exists($key, $params)){

            $result[$key] = $value;
            
            if (isset($value["size"]) && $value["size"] > 0) {
                
                if (!in_array($value["type"], $params[$key]["requirements"]["types"])) {

                    $result[$key] = $params[$key]["errors"]["types"];
            
                } elseif ($params[$key]["requirements"]["size"] < $value["size"] / 1000000){
            
                    $result[$key] = $params[$key]["errors"]["size"];
            
                }
            
            } else {
                $result["errors"][$key] = "$key file not found";
            }

        
        }
    }
    return $result;
}

function validateCode (string $code): bool{

    preg_match(VALIDATION_PARAMS["code"]["pattern"], $code) ? $result = true : $result = false;

    return $result;
}