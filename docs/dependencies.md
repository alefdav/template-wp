# Dependências do Projeto

Este documento descreve as dependências utilizadas neste tema WordPress, suas versões e como cada uma é utilizada no projeto.

## Dependências de Desenvolvimento

Estas dependências são utilizadas apenas durante o desenvolvimento e não são incluídas no código final do tema.

| Dependência | Versão | Descrição | Uso no Projeto |
|-------------|--------|-----------|----------------|
| @babel/core | 7.24.0 | Núcleo do Babel para transpilação de JavaScript | Converte código ES6+ para versões compatíveis com navegadores mais antigos |
| @babel/preset-env | 7.24.0 | Preset do Babel com configurações modernas | Define quais transformações/plugins usar na transpilação baseado no suporte de navegadores |
| babel-loader | 9.1.3 | Loader do Webpack para Babel | Integra o Babel ao processo de build do Webpack |
| clean-webpack-plugin | 4.0.0 | Plugin para limpar a pasta de build | Remove arquivos antigos da pasta dist antes de cada build |
| css-loader | 6.10.0 | Loader para processar arquivos CSS | Interpreta importações de CSS e resolve URLs |
| eslint | 8.57.0 | Ferramenta de linting para JavaScript | Verifica código em busca de problemas e mantém padrões de qualidade |
| file-loader | 6.2.0 | Loader para arquivos estáticos | Processa fontes, imagens e outros arquivos estáticos |
| node-sass | 9.0.0 | Compilador de SASS para Node.js | Compila arquivos SCSS para CSS |
| sass-loader | 14.1.1 | Loader do Webpack para SASS | Integra o compilador SASS ao processo de build |
| style-loader | 3.3.4 | Loader para injetar CSS no DOM | Adiciona o CSS compilado na página |
| webpack | 5.89.0 | Bundler de módulos | Gerencia todo o processo de build e bundling |
| webpack-cli | 5.1.4 | Interface de linha de comando para Webpack | Permite executar comandos Webpack via terminal |
| webpack-dev-server | 4.15.1 | Servidor de desenvolvimento | Fornece ambiente de desenvolvimento com hot-reload |
| webpack-merge | 5.10.0 | Utilidade para mesclar configurações | Permite separar configurações de dev e prod |

## Dependências de Produção

Estas dependências são incluídas no código final do tema e são necessárias para seu funcionamento.

| Dependência | Versão | Descrição | Uso no Projeto |
|-------------|--------|-----------|----------------|
| bootstrap | 5.3.3 | Framework CSS/JS | Fornece componentes de UI e sistema de grid responsivo |
| jquery | 3.7.1 | Biblioteca JavaScript | Base para manipulação do DOM e interações |
| jquery-mask-plugin | 1.14.16 | Plugin para máscaras de input | Usado para formatar campos como telefone, data, etc. |
| @popperjs/core | 2.11.8 | Biblioteca de posicionamento | Utilizada pelo Bootstrap para posicionar tooltips e popovers |
| slick-carousel | 1.8.1 | Carrossel responsivo | Implementa sliders e carrosséis de conteúdo |
| typed.js | 2.1.0 | Animação de digitação | Cria efeito de texto sendo digitado |

## Atualizações Recentes

Em março de 2024, as seguintes atualizações foram realizadas:

1. Atualização do Bootstrap de 5.3.2 para 5.3.3
2. Substituição de `popper.js` (1.16.1) por `@popperjs/core` (2.11.8)
3. Atualização de todas as dependências de desenvolvimento para suas versões mais recentes

## Como as Dependências são Carregadas

### JavaScript

As dependências JavaScript são importadas nos seguintes arquivos:

```javascript
// Em assets/js/index.js
import jQuery from "jquery";
import { Dropdown, Modal, Collapse, Carousel, Toast, Tooltip, Popover } from "bootstrap";
import "jquery-mask-plugin";
import "slick-carousel/slick/slick";
```

### CSS/SCSS

As dependências CSS são importadas nos seguintes arquivos:

```scss
// Em assets/scss/style.scss
@import "~bootstrap/scss/functions";
@import "~bootstrap/scss/variables";
// ... outros imports do Bootstrap

// Em assets/js/index.js (via importação do Webpack)
import "slick-carousel/slick/slick.scss";
```

## Gerenciamento de Dependências

Para adicionar ou atualizar dependências:

```bash
# Adicionar nova dependência
npm install --save nome-do-pacote

# Atualizar uma dependência existente
npm update nome-do-pacote

# Atualizar todas as dependências
npm update
```

## Análise de Segurança

Recomenda-se executar periodicamente uma verificação de segurança nas dependências:

```bash
npm audit
```

Se vulnerabilidades forem encontradas, execute:

```bash
npm audit fix
``` 