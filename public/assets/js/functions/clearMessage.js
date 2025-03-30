export function clearMessage() {

    if (document.querySelector('.message-banner')) {
        const message = document.querySelector('.message-banner');
        message.remove();
    }

}