import {validationParams} from "./params.js";
import {showError} from "./messages-funcs.js";

export function validateFile(fileField, params = validationParams.files) {
    let isValid = true;
    let input = fileField.children[0].children[1];
    let inputKey = input.id;

    if (input.files[0] !== undefined){
        const file = input.files[0];

        if (!params[`${inputKey}`]["requirements"]["types"].includes(file.type)){
            showError(fileField, params[`${inputKey}`]["errors"]["types"], "invalid");
            isValid = false;
        } else if (params[`${inputKey}`]["requirements"]["size"] < file.size/1000000){
            showError(fileField, params[`${inputKey}`]["errors"]["size"], "invalid");
            isValid = false;
        }
    } else {
        showError(fileField, `${inputKey} is required`, "invalid");
        isValid = false;
    }
    return isValid;
}

export function validateFields(fields, params= validationParams.fields) {
    let isValid = true;

    fields.forEach((field) => {
        let input = field.children[0].children[1];
        let inputKey = input.id;
        let inputValue = input.value.trim();

        // File field validation
        if (field.classList.contains("file")){
            if (!validateFile(field)){
                isValid = false;
            }

        // Text field validation
        } else {
            if (inputValue === "") {
                showError(field, `${inputKey} is required`, "invalid");
                isValid = false;
            } else if (!(inputValue.match(params[`${inputKey}`]["pattern"]))) {
                showError(field, params[`${inputKey}`]["error"], "invalid");
                isValid = false;
            }
        }
    });
    return isValid;
}

