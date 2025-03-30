import {clearMessage} from './clearMessage.js';

export function listenToCloseMessage() {

    if (document.querySelector('.message-banner__close')) {
        const messageButton = document.querySelector('.message-banner__close');
        messageButton.addEventListener('click', function() {
            clearMessage();
        });
    }

}