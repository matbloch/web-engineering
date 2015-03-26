<!doctype html>
<?php     global $img_uri; ?>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">

		<meta http-equiv="x-ua-compatible" content="IE=9, chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<?php wp_head(); ?>

	</head>
	<body <?php body_class(); ?>>
	
	<nav id="hover_nav">
		<a data-fn="open_close" class="button" href="#"></a>
		<a data-fn="pin" class="pin" href="#" ></a>
		<div class="content">
			<ul class="items">
					<li class="index"><a href="index.html"><img src="<?php echo $img_uri.'mm1.png'; ?>"></a></li>
					<li class="blog"><a href="blog.html"><img src="<?php echo $img_uri.'mm2.png'; ?>"></a></li>
					<li class="portfolio"><a href="portfolio.html"><img src="<?php echo $img_uri.'mm3.png'; ?>"></a></li>
					<li class="contactus"><a href="contactus.html"><img src="<?php echo $img_uri.'mm4.png'; ?>"></a></li>
			</ul>
		</div>
	</nav>
	
	
	
