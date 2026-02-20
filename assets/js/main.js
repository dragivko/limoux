"use strict";

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("[data-limoux-animate]").forEach(function (element, index) {
        element.style.opacity = "0";
        setTimeout(function () {
            element.style.transition = "opacity 450ms ease";
            element.style.opacity = "1";
        }, index * 60);
    });
});
