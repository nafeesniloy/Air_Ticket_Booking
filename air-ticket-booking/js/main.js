// js/main.js
document.addEventListener("DOMContentLoaded", function () {
    const dateInput = document.querySelector("input[type='date']");
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute("min", today);
    }
});
