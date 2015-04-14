<?php /* Template Name: Portfolio Template */ get_header(); ?>

	<?php
	// get posts
	$args = array(
		'numberposts' => 8,
		'post_type' => 'portfolio',
		'post_status' => 'publish');
	
		$portfolio_posts = wp_get_recent_posts( $args , OBJECT);
		$portfolio_posts = array_chunk($portfolio_posts,4);
	?>

	<!-- <section> -->
	<section class="portfolio padding-10">
		
		<?php if(count(portfolio_posts)>4):foreach($portfolio_posts as $block): ?>
		<ul class="row">
			<?php foreach($block as $post): ?>
			<li class="col-3 padding-10">
				<div class="bg-clr-white"><img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>" alt="">
					<div class="padding-10">
						<strong><?php echo $post->post_title; ?></strong>
						<br>
						 <?php echo get_post_meta( $post->ID, 'publishing_year', true ); ?>
					</div>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endforeach;else: ?>
		<ul class="row">
			<?php foreach($portfolio_posts as $post): ?>
			<li class="col-3 padding-10">
				<div class="bg-clr-white"><img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>" alt="">
					<div class="padding-10">
						<strong><?php echo $post->post_title; ?></strong>
						<br>
						 <?php echo get_post_meta( $post->ID, 'publishing_year', true ); ?>
					</div>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		
	</section>
	<!-- </section> -->
	
<?php get_footer(); ?>
