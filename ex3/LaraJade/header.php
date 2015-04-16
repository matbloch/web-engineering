<!doctype html>
<?php global $img_uri; ?>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">

		<meta http-equiv="x-ua-compatible" content="IE=9, chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<?php wp_head(); ?>
        <style type="text/css">
            body {
    background-color: <?php echo get_theme_mod( 'background-color', '#414141' ); ?>;
}
            article {
   color: <?php echo get_theme_mod( 'article-color', '#414141' ); ?>;
}
            h1,h2,h3,h4 {color:<?php echo get_theme_mod( 'headline-color', '#414141' ); ?>;
            }
            
        </style>
	</head>
	<body <?php body_class(); ?>>
	
	<nav id="hover_nav">
		<a data-fn="open_close" class="button" href="#"></a>
		<a data-fn="pin" class="pin" href="#" ></a>
		<div class="content">
			<ul class="items">
					<li class="index"><a href="<?php echo get_permalink( get_page_by_path( 'home' ) );?>"><img src="<?php echo $img_uri.'mm1.png'; ?>"></a></li>
					<li class="blog"><a href="<?php echo get_permalink( get_page_by_path( 'blog' ) );?>"><img src="<?php echo $img_uri.'mm2.png'; ?>"></a></li>
					<li class="portfolio"><a href="<?php echo get_permalink( get_page_by_path( 'portfolio' ) );?>"><img src="<?php echo $img_uri.'mm3.png'; ?>"></a></li>
					<li class="contactus"><a href="<?php echo get_permalink( get_page_by_path( 'contact-us' ) );?>"><img src="<?php echo $img_uri.'mm4.png'; ?>"></a></li>
			</ul>
		</div>
	</nav>
	
	
	<div class="page-wrapper">
        <img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
		<header class="nav">
			<div class="page-title padding-l-20 bg-clr-white">
				<h1>LARA JADE</h1>
			</div>
			<nav class="items">
				<li><a href="<?php echo get_permalink( get_page_by_path( 'home' ) );?>"><img src="<?php echo $img_uri.'m1.png'; ?>"></a></li>
				<li><a href="<?php echo get_permalink( get_page_by_path( 'blog' ) );?>"><img src="<?php echo $img_uri.'m2.png'; ?>"></a></li>
				<li><a href="<?php echo get_permalink( get_page_by_path( 'portfolio' ) );?>"><img src="<?php echo $img_uri.'m3.png'; ?>"></a></li>
				<li><a href="<?php echo get_permalink( get_page_by_path( 'contact-us' ) );?>"><img src="<?php echo $img_uri.'m4.png'; ?>"></a></li>
			</nav>
		</header>
		<div class="content-wrapper" role="main">