import "./bootstrap";
import Alpine from "alpinejs";
import mask from "@alpinejs/mask";
import growth from "./projects_show";

import.meta.glob(["../images/**"]);

Alpine.plugin(mask);

window.Alpine = Alpine;

document.addEventListener("alpine:init", () => {
    Alpine.data("growth", growth);
});

Alpine.start();
