# Guia de Contribuição

Obrigado pelo interesse em contribuir com o tema wp-template WordPress! Este documento fornece diretrizes para contribuir com o projeto.

## Como Contribuir

1. **Configuração do Ambiente**
   - Certifique-se de ter instalado:
     - WordPress (versão 5.6+)
     - PHP 7.4+
     - Node.js 14+
     - npm ou yarn

2. **Criando um Fork**
   - Faça um fork do repositório
   - Clone o seu fork localmente:
     ```bash
     git clone [URL_DO_SEU_FORK] wp-content/themes/wp-template-theme
     ```

3. **Configurando o Projeto**
   - Entre na pasta do tema:
     ```bash
     cd wp-content/themes/wp-template-theme
     ```
   - Instale as dependências:
     ```bash
     npm install
     ```
   - Execute o ambiente de desenvolvimento:
     ```bash
     npm run dev
     ```

4. **Criando uma Branch**
   - Crie uma branch para suas alterações:
     ```bash
     git checkout -b feature/nome-da-feature
     ```
   - Use prefixos para nomear suas branches:
     - `feature/` para novas funcionalidades
     - `fix/` para correções de bugs
     - `refactor/` para refatorações
     - `docs/` para melhorias na documentação

5. **Trabalhando nas Mudanças**
   - Siga as convenções de código do projeto
   - Mantenha o código limpo e bem documentado
   - Escreva mensagens de commit claras e descritivas

## Diretrizes de Codificação

### PHP

- Siga os [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)
- Use indentação com 2 espaços
- Use nomes de funções e variáveis descritivos
- Adicione documentação PHPDoc para todas as funções

```php
/**
 * Descrição breve da função
 *
 * Descrição mais detalhada, se necessário
 *
 * @param string $parametro Descrição do parâmetro
 * @return void Descrição do retorno
 */
function nome_da_funcao($parametro) {
    // Código aqui
}
```

### JavaScript

- Use JavaScript moderno (ES6+)
- Organize o código em módulos
- Siga o padrão de desenvolvimento modular
- Documente as funções com JSDoc

```javascript
/**
 * Descrição da função
 *
 * @param {string} parametro - Descrição do parâmetro
 * @returns {void} Descrição do retorno
 */
function nomeDaFuncao(parametro) {
    // Código aqui
}
```

### SCSS

- Organize os estilos em componentes e páginas
- Use variáveis para cores, tamanhos e outros valores recorrentes
- Siga uma metodologia de nomenclatura como BEM
- Priorize a modularização e reutilização de código

```scss
// Componente
.componente {
    &__elemento {
        // Estilos aqui
    }
    
    &--modificador {
        // Estilos aqui
    }
}
```

## Processo de Pull Request

1. **Antes de Enviar**
   - Certifique-se de que seu código segue as diretrizes
   - Verifique se todas as mudanças foram testadas
   - Execute `npm run prod` para garantir que os assets sejam compilados corretamente

2. **Enviando o PR**
   - Faça push das suas alterações para o seu fork:
     ```bash
     git push origin feature/nome-da-feature
     ```
   - Vá para o repositório original e crie um novo Pull Request
   - Forneça uma descrição clara do que foi feito e por quê

3. **Após o Envio**
   - Responda a quaisquer pedidos de alteração
   - Mantenha a conversa civil e construtiva

## Dúvidas?

Se você tiver dúvidas sobre como contribuir, entre em contato conosco através das issues ou pelo e-mail de suporte.

Agradecemos sua contribuição para tornar o tema wp-template WordPress ainda melhor! 