// Importing jQuery
import jQuery from "jquery";

// Importar apenas os componentes Bootstrap JS necessários para reduzir tamanho
import { Dropdown, Modal, Collapse, Carousel, Toast, Tooltip, Popover } from "bootstrap";
import "jquery-mask-plugin";

import { home } from "./home";

// Import scripts to apply on project
import "./../scss/style.scss";

// Importing Slick Carousel
import "slick-carousel/slick/slick";
import "slick-carousel/slick/slick.scss";

const $ = jQuery;

// Inicializar componentes do Bootstrap que precisam de inicialização via JS
document.addEventListener('DOMContentLoaded', () => {
  // Inicializar tooltips
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new Tooltip(tooltipTriggerEl);
  });
  
  // Inicializar popovers
  const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
  popoverTriggerList.map(function (popoverTriggerEl) {
    return new Popover(popoverTriggerEl);
  });
});

home();
