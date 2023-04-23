import "./bootstrap";
import Alpine from "alpinejs";
import mask from "@alpinejs/mask";

import.meta.glob(["../images/**"]);

Alpine.plugin(mask);

window.Alpine = Alpine;

Alpine.start();
