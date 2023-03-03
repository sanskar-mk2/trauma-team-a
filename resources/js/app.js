import "./bootstrap";
import Alpine from "alpinejs";
import growth from "./projects_show";

window.Alpine = Alpine;
window.growth = growth;

document.addEventListener("alpine:init", () => {
    Alpine.data("growth", growth);
});

Alpine.start();
