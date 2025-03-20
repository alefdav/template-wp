<!doctype html>
<html lang="pt">

<head>

  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="manifest" href="<?php bloginfo('template_url') ?>/manifest.json">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <header>
    <nav>
      <ul>
        <li><a href="<?php echo home_url(); ?>">Home</a></li>
        <li><a href="<?php echo home_url(); ?>/sobre">Sobre</a></li>
        <li><a href="<?php echo home_url(); ?>/contato">Contato</a></li>
      </ul>
    </nav>
  </header>