# Personalização do Bootstrap

Este documento explica como o Bootstrap é implementado neste tema e como personalizá-lo para atender às suas necessidades.

## Implementação

O Bootstrap é importado de duas formas em nosso tema:

1. **CSS/SCSS**: Importado através de módulos SCSS separados em `assets/scss/style.scss`
2. **JavaScript**: Importado de forma seletiva em `assets/js/index.js`

## Personalização do Estilo (SCSS)

### Variáveis Personalizadas

As variáveis de personalização do Bootstrap estão definidas no início do arquivo `assets/scss/style.scss`. Você pode modificar estas variáveis para adaptar o Bootstrap à sua identidade visual.

```scss
// Variáveis de personalização do Bootstrap
$primary: #0d6efd;    // Cor primária
$secondary: #6c757d;  // Cor secundária
$font-family-base: 'Helvetica Neue', Arial, sans-serif;

// Mais variáveis podem ser adicionadas aqui
```

### Lista Completa de Variáveis Personalizáveis

Confira a lista completa de variáveis que podem ser sobrescritas:
https://github.com/twbs/bootstrap/blob/main/scss/_variables.scss

### Importação Seletiva

Para reduzir o tamanho do CSS final, importamos apenas os componentes do Bootstrap que realmente utilizamos. Se você precisar de componentes adicionais, adicione a importação correspondente em `assets/scss/style.scss`:

```scss
// Exemplo: Adicionar o componente Spinners
@import "~bootstrap/scss/spinners";
```

### Extensão dos Componentes

Para estender ou modificar componentes específicos do Bootstrap, crie um arquivo SCSS dedicado em `assets/scss/components/`:

```scss
// Em assets/scss/components/_buttons.scss
.btn-brand {
  @extend .btn-primary;
  border-radius: 0;
  text-transform: uppercase;
}
```

E importe-o em `assets/scss/style.scss`:

```scss
@import "components/buttons";
```

## Personalização do JavaScript

### Componentes Importados

Importamos apenas os componentes JavaScript necessários para reduzir o tamanho do bundle final. Os componentes atualmente importados estão em `assets/js/index.js`:

```javascript
import { Dropdown, Modal, Collapse, Carousel, Toast, Tooltip, Popover } from "bootstrap";
```

### Adicionar Novos Componentes

Se você precisar de componentes adicionais, adicione-os à lista de importação:

```javascript
// Exemplo: Adicionar o componente Offcanvas
import { Dropdown, Modal, Collapse, Carousel, Toast, Tooltip, Popover, Offcanvas } from "bootstrap";
```

### Inicialização de Componentes

Alguns componentes do Bootstrap requerem inicialização via JavaScript. Isto é feito no arquivo `assets/js/index.js`:

```javascript
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
```

Se você adicionar novos componentes que necessitam de inicialização, adicione o código correspondente neste bloco.

## Exemplo de Uso no HTML

Exemplo de como usar componentes do Bootstrap em templates:

```php
<div class="container mt-4">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <?php the_title(); ?>
        </div>
        <div class="card-body">
          <?php the_content(); ?>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <?php get_sidebar(); ?>
    </div>
  </div>
</div>
```

## Recursos Adicionais

- [Documentação oficial do Bootstrap](https://getbootstrap.com/docs/5.3/getting-started/introduction/)
- [Customização do Bootstrap com Sass](https://getbootstrap.com/docs/5.3/customize/sass/)
- [Componentes do Bootstrap](https://getbootstrap.com/docs/5.3/components/) 