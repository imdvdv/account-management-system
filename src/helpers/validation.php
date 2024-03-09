<?php

function validateFields (array $inputs, array $response, array $params = VALIDATION_PARAMS["fields"]): array {
    foreach ($inputs as $key => $value) {
        if (empty($value)) {
            $response["errors"][$key] = $key ." is required";
        } else if (!preg_match($params[$key]["pattern"], $value)){
            $response["errors"][$key] = $params[$key]["error"];
        }
    }
    return $response;
}

function validateFile (string $key, array $file, array $response, array $params = VALIDATION_PARAMS["files"]): array {
    if (!in_array($file["type"], $params[$key]["requirements"]["types"])) {
        $response["errors"][$key] = $params[$key]["errors"]["types"];
    } else if ($params[$key]["requirements"]["size"] < $file["size"] / 1000000){
        $response["errors"][$key] = $params[$key]["errors"]["size"];
    }
    return $response;
}

function validateCode (string $code): bool{
    preg_match(VALIDATION_PARAMS["code"]["pattern"], $code) ? $result = true : $result = false;
    return $result;
}