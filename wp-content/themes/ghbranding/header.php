 <!DOCTYPE html>
 <html <?php language_attributes(); ?>>

 <head>
     <meta charset="<?php bloginfo('charset'); ?>">
     <meta name="viewport" content="width=device-width">
     <?php wp_head(); ?>
     <title itemprop="name">Teste GH Branding </title>
    <link rel="canonical" href="https://meusite.com.br">
 </head>

 <body <?php body_class(); ?>>
     <?php wp_body_open(); ?>
     <div id="wrapper" class="hfeed">
         <header class="header" role="banner">
            <div class="header--top">
                <div class="container">
                    <a href="/" class="breadcrumbs">Home</a>
                </div>
            </div>
            <div class="container">
                <?php if(is_front_page() || is_search()): ?>
                    <h1 class="title">Take a Look at Some of Our Pets</h1>   
                <?php else: ?>
                    <h2 class="title">You liked these:</h2>
                <?php endif; ?>
            </div>
         </header>
         <div class="container">
            <main id="content" role="main">