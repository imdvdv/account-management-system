import {showMessage} from "./messages-funcs.js";

export function openPopup(popup = document.querySelector(".popup")){
    if (popup.classList.contains("hide")){
        popup.classList.remove("hide");
    }
}

export function closePopup(popup = document.querySelector(".popup")){
    if (!popup.classList.contains("hide")){
        const popupContent = popup.children[0].children[0];
        popup.classList.add("hide");
        popupContent.innerHTML = "";
    }
}

export async function renderPopup (params, element = null) {
    if (document.querySelector(".popup")){
    
        const popup = document.querySelector(".popup");
        const popupContent = popup.children[0].children[0];
        const closeButtonHTML = `<button class="popup__close close-popup"><i class="popup__close-icon fa-solid fa-xmark"></i></button>`;
        const response = await fetch(params.contentPath);
        popupContent.innerHTML = closeButtonHTML;
        popupContent.innerHTML += await response.text();

        openPopup(popup);

        // Close the popup window when a key Escape is pressed
        document.addEventListener("keydown", function(event) {
            if (event.key === "Escape") {
                closePopup(popup);
            }
        });

        // Close the popup window when button with "close-popup" class is clicked
        if (popupContent.querySelector(".close-popup")){
            const closeButtons = popupContent.querySelectorAll(".close-popup");
            closeButtons.forEach((closeButton) => {
                closeButton.addEventListener("click", () => {
                    closePopup(popup);
                });
            });
        }

        // Close the popup window when clicking on an area outside the window
        popup.addEventListener("click", (e) => {
            if (!e.target.closest(".popup__content")){
                closePopup(popup, popupContent);
            }
        });

        // Calling a callback after opening a popup
        if (typeof params.contentAction === "function"){
            try {
                await params.contentAction(element);
            } catch {
                closePopup(popup);
                showMessage(false, "Something went wrong. Please try again later.");
            }
        }
    } else {
        showMessage(false, "Something went wrong. Please try again later.");
    }
}

