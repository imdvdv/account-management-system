import {validationParams} from "./params.js";
import {clearAllMessages, sessionMessageHandler} from "./messages-funcs.js";
import {serverRequest} from "./server-request.js";
import {showHidePassword} from "./show-hide-password.js";
import {validateFields} from "./validation.js";


export async function formHandler(form, endpoint, params = validationParams.fields){
    sessionMessageHandler();
    showHidePassword();
    if (form.querySelector(".form__field")){
        const fields = form.querySelectorAll(".form__field");
        form.addEventListener("submit", async (e) => {
            e.preventDefault(); // block page reload when form is submitted
            clearAllMessages();
            if (validateFields(fields, params)) {
                const bodyData = new FormData(form);
                const options = {
                    method: "POST",
                    body: bodyData,
                };
                return await serverRequest(`/src/actions/${endpoint}.php`, options);
            }
            return false;
        });
    }
}