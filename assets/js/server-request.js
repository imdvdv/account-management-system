import {setSessionMessage, showMessage, showError} from "./messages-funcs.js";

export async function serverRequest(url, options = {}){
    try{
        let response = await fetch (url, options);
        let data = await response.json();
        if (options.method === "POST" || options.method === "DELETE") {

            // Processing the response from the server in JSON format
            if (typeof data.status !== undefined) {
                if (data.url !== undefined && data.url !== "") {
                    if (data.message !== undefined && data.message !== "") {
                        setSessionMessage(data.status, data.message);
                    }
                    document.location.href = data.url; // redirect to the URL specified by the server response
                } else if (data.message !== undefined && data.message !== "") {
                    showMessage(data.status, data.message);
                }
                if (data.errors) {
                    let inputKeys = Object.keys(data.errors);
                    inputKeys.forEach(function (inputKey) {
                        let field = document.querySelector(`.form__field_${inputKey}`)
                        showError(field, data.errors[`${inputKey}`], "invalid");
                    });
                }
                return data.status;
            }
        } else if (options.method === "GET") {
            return data;
        } else {
            showMessage(false, "Method not supported");
            return false;
        }
    } catch{
        showMessage(false, "Something went wrong. Please try again later.");
        return false;
    }
}


