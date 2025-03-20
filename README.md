# WP-Template WordPress Theme

Um tema WordPress moderno, performático e seguro desenvolvido para sites corporativos.

## Características

- Design responsivo baseado em Bootstrap 5
- Otimização de performance com carregamento assíncrono de scripts
- Lazy loading de imagens para melhor experiência do usuário
- Medidas de segurança avançadas contra ataques comuns
- Suporte a menus customizados (cabeçalho e rodapé)
- Arquitetura modular e organizada

## Requisitos

- WordPress 5.6+
- PHP 7.4+
- Node.js 14+ (para desenvolvimento)
- npm ou yarn

## Instalação

### Como tema

1. Baixe o arquivo zip do tema
2. Acesse o painel administrativo do WordPress
3. Navegue até Aparência > Temas
4. Clique em "Adicionar novo"
5. Clique em "Enviar tema"
6. Selecione o arquivo zip baixado
7. Clique em "Instalar agora"
8. Após a instalação, clique em "Ativar"

### Para desenvolvimento

1. Clone o repositório para a pasta `wp-content/themes/` do seu WordPress:
   ```bash
   git clone [URL_DO_REPOSITÓRIO] wp-content/themes/wp-template-theme
   ```

2. Acesse a pasta do tema:
   ```bash
   cd wp-content/themes/wp-template-theme
   ```

3. Instale as dependências:
   ```bash
   npm install
   ```

4. Execute o ambiente de desenvolvimento:
   ```bash
   npm run dev
   ```

5. Para build de produção:
   ```bash
   npm run prod
   ```

## Estrutura do Tema

```
wp-template-theme/
├── assets/               # Arquivos fonte não compilados
│   ├── js/               # Arquivos JavaScript
│   ├── scss/             # Arquivos SCSS
│   │   ├── components/   # Componentes reutilizáveis
│   │   └── pages/        # Estilos específicos de página
├── dist/                 # Arquivos compilados (gerados pelo webpack)
│   └── js/               # JavaScript compilado
├── inc/                  # Funções e configurações PHP
│   ├── inc_config.php    # Configurações básicas
│   ├── inc_login.php     # Personalização do login
│   └── inc_scripts.php   # Registro e carregamento de scripts
├── pages/                # Templates de páginas personalizadas
├── .gitignore            # Arquivos ignorados pelo git
├── 404.php               # Template para página 404
├── category.php          # Template para arquivos de categoria
├── footer.php            # Footer do site
├── functions.php         # Funções principais do tema
├── header.php            # Header do site
├── index.php             # Template principal
├── package.json          # Dependências npm
├── README.md             # Esta documentação
├── search.php            # Template de resultados de busca
├── single.php            # Template para posts individuais
├── style.css             # Arquivo principal de estilo e informações do tema
├── webpack.common.js     # Configuração comum do webpack
├── webpack.dev.js        # Configuração webpack para desenvolvimento
└── webpack.prod.js       # Configuração webpack para produção
```

## Personalização

### Menus

O tema suporta dois locais de menu:
- Menu Header (cabeçalho)
- Menu Footer (rodapé)

Para configurá-los, acesse Aparência > Menus no painel administrativo do WordPress.

### Estilos

Os estilos estão organizados em arquivos SCSS dentro de `assets/scss/`:

- `components/`: Componentes reutilizáveis (tipografia, botões, etc.)
- `pages/`: Estilos específicos para cada tipo de página

Para adicionar novos estilos:

1. Crie seu arquivo SCSS em `assets/scss/components/` ou `assets/scss/pages/`
2. Importe-o em `assets/scss/style.scss`
3. Execute `npm run dev` para compilação

### JavaScript

Os scripts estão em `assets/js/`. O arquivo principal é `index.js`, que importa outros módulos específicos.

Para adicionar novos scripts:

1. Crie seu arquivo JavaScript em `assets/js/`
2. Importe-o em `assets/js/index.js`
3. Execute `npm run dev` para compilação

## Segurança

O tema implementa várias medidas de segurança:

- Proteção contra ataques de força bruta no login
- Sanitização de entradas e saídas
- Proteção CSRF com nonces em formulários
- Headers de segurança (X-Frame-Options, X-XSS-Protection)
- Desativação da API XML-RPC

## Performance

Otimizações de performance incluem:

- Carregamento assíncrono de scripts (async/defer)
- Lazy loading de imagens
- Minificação de assets
- Remoção de scripts e estilos desnecessários do WordPress
- Cache de consultas ao banco de dados

## Contribuição

Contribuições são bem-vindas! Para contribuir:

1. Faça um fork do repositório
2. Crie uma branch para sua feature: `git checkout -b feature/nova-funcionalidade`
3. Faça commit das alterações: `git commit -m 'Adiciona nova funcionalidade'`
4. Envie para o GitHub: `git push origin feature/nova-funcionalidade`
5. Abra um Pull Request

## Licença

Este tema é licenciado sob a licença GPL v2 - veja o arquivo LICENSE para detalhes.

## Créditos

- Bootstrap: https://getbootstrap.com
- jQuery: https://jquery.com
- Slick Carousel: https://kenwheeler.github.io/slick/
- Webpack: https://webpack.js.org

