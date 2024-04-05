
export function showMessage (successStatus, messageString) {
    if (document.querySelector(".message")){
        const message = document.querySelector(".message"),
            messageText = message.querySelector(".message-text");
        if (successStatus) {
            if (message.classList.contains("failure")){
                message.classList.remove("failure")
            }
            message.classList.add("success");
        } else {
            if (message.classList.contains("success")){
                message.classList.remove("success")
            }
            message.classList.add("failure");
        }
        message.classList.add("show");
        messageText.textContent = messageString;
    }
}

export function setSessionMessage (successStatus, messageString) {
    sessionStorage.setItem("status", successStatus);
    sessionStorage.setItem("message", messageString);
}

export function showSessionMessage () {
    const status = sessionStorage.getItem("status"),
        message = sessionStorage.getItem("message");

    if (status === "true") {
        showMessage(true, message);
    } else if (status === "false") {
        showMessage(false, message);
    } else {
        showMessage(false, "Something went wrong. Please try again later.");
    }
}

export function showError (field, errorString, validationClass = null) {
    const error = field.children[1],
        errorText = error.children[1];

    if (validationClass) {
        field.classList.add(validationClass);
    }
    error.classList.add("show");
    errorText.textContent = errorString;
}

export function clearMessage () {
    if (document.querySelector(".message")) {
        const message = document.querySelector(".message");
        message.classList.remove("show");
    }
    if (sessionStorage["status"] && sessionStorage["message"]){
        delete sessionStorage["status"];
        delete sessionStorage["message"];
    }
}

export function clearErrors () {
    if (document.querySelector(".form__field")){
        const fields = document.querySelectorAll(".form__field");
        fields.forEach(function (field) {
            const error = field.children[1];
            error.classList.remove("show");
            field.classList.remove("invalid");
        });
    }
}

export function clearAllMessages () {
    clearMessage();
    clearErrors();
}

export function sessionMessageHandler () {
    window.onload = function (e) {
        if (sessionStorage["status"] && sessionStorage["message"]) {
            showSessionMessage();
            window.onunload = function (e) {
                clearAllMessages();
            }
        }
    }
}
