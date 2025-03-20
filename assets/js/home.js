import $ from "jquery";
import Typed from "typed.js";

export function home() {
  // Inicializar o carrossel principal
  $('.hero-slider').slick({
    dots: true,
    arrows: false,
    infinite: true,
    speed: 500,
    fade: true,
    cssEase: 'linear',
    autoplay: true,
    autoplaySpeed: 5000,
    pauseOnHover: false
  });
  
  // Inicializar carrossel de depoimentos
  $('.testimonials-slider').slick({
    dots: true,
    arrows: true,
    infinite: true,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 2
        }
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1,
          arrows: false
        }
      }
    ]
  });
  
  // Efeito de digitação para títulos
  if (document.querySelector('.typed-element')) {
    const options = {
      strings: ['Criamos sites incríveis', 'Desenvolvemos soluções digitais', 'Impulsionamos seu negócio'],
      typeSpeed: 70,
      backSpeed: 50,
      backDelay: 2000,
      loop: true
    };
    
    new Typed('.typed-element', options);
  }
  
  // Lazy loading de imagens
  const lazyLoadImages = () => {
    const lazyImages = document.querySelectorAll('img.lazy-load');
    
    if ('IntersectionObserver' in window) {
      const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const image = entry.target;
            image.src = image.dataset.src;
            image.classList.add('loaded');
            imageObserver.unobserve(image);
          }
        });
      });
      
      lazyImages.forEach(image => imageObserver.observe(image));
    } else {
      // Fallback para navegadores que não suportam IntersectionObserver
      lazyImages.forEach(image => {
        image.src = image.dataset.src;
        image.classList.add('loaded');
      });
    }
  };
  
  lazyLoadImages();
  
  // Botão 'Voltar ao topo'
  const backToTopButton = document.querySelector('.back-to-top');
  
  if (backToTopButton) {
    window.addEventListener('scroll', () => {
      if (window.pageYOffset > 300) {
        backToTopButton.classList.add('visible');
      } else {
        backToTopButton.classList.remove('visible');
      }
    });
    
    backToTopButton.addEventListener('click', (e) => {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
}
