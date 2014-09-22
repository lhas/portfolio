<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->

<head>
    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1"/>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>"/>
    <!-- Title -->
    <title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>

    <!-- 1140px Grid styles for IE -->
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/grid/ie.css" type="text/css"
          media="screen"/>
    <![endif]-->

    <!-- The 1140px Grid - http://cssgrid.net/ -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/grid/1140.css" type="text/css"
          media="screen"/>


    <!-- Stylesheets -->
    <?php global $data; ?>

    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen"/>
    <link rel="stylesheet"
          href="<?php echo get_template_directory_uri(); ?>/css/skins/<?php echo $data['coll_alt_stylesheet']?>"
          type="text/css" media="screen" id="site_skin">

    <?php wp_head(); ?>

</head>

<body  <?php body_class(); ?>>
<?php insert_page_bg();?>
<?php $fp_menu = $data['coll_no_fp_menu'];?>
<header class="header <?php if (is_home() && $fp_menu) echo 'no-front-page'; ?>">
    <div class="container">
        <div class="row">
            <div class="logo twocol">
                <a href="<?php echo home_url(); ?>"> <img src="<?php echo $data['coll_site_logo']; ?>"></a>
            </div>
            <div class="tencol last">
                <nav id="mainmenu" class="mainmenu">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary-menu',
                        'container' => '',
                        'menu_class' => 'sf-menu', //Adding the class for dropdowns
                        'before' => '',
                        'fallback_cb' => ''

                    ));
                    ?>
                </nav>
            </div>
        </div>
    </div>

<!--        <div class="shadow"></div>-->

</header>


