
export function showHideDropdown (element) {
    element.addEventListener("mouseover", async () => {
        if (element.querySelector(".dropdown")) {
            const dropdown = element.querySelector(".dropdown");
            dropdown.style.display = "initial";

            element.addEventListener("mouseout", async () => {
                dropdown.style.display = "none";
            });
        }
    });
}
