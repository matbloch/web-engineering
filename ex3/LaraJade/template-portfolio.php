<?php /* Template Name: Portfolio Template */ get_header(); ?>

	<?php
	// get posts
	$args = array(
		'numberposts' => 8,
		'post_type' => 'portfolio',
		'post_status' => 'publish');
	
		$portfolio_posts = wp_get_recent_posts( $args , OBJECT);
		if(count($portfolio_posts)>4):$portfolio_posts = array_chunk($portfolio_posts,4);endif;
	?>

	<!-- <section> -->
	<section class="portfolio padding-10">
		
		<?php if(count($portfolio_posts)>4):foreach($portfolio_posts as $block): ?>
		<ul class="row">
			<?php foreach($block as $post): ?>
			<li class="col-3 padding-10">
                <article id="portfo-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="bg-clr-white post_art"></div><img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>" alt="">
					<div class="padding-10">
						<strong><?php echo $post->post_title; ?></strong>
						<br>
						 <?php echo get_post_meta( $post->ID, 'publishing_year', true ); ?>
					</div>
				</div>
                    </article>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endforeach;else: ?>
		<ul class="row">
			<?php if($portfolio_posts):foreach($portfolio_posts as $post): ?>

			<li class="col-3 padding-10">
                <article id="portfo-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <a href="<?php the_permalink(); ?>" target="_blank">
				<div class="bg-clr-white post_art"><img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>"  alt="">
					<div class="padding-10">
						<strong><?php echo $post->post_title; ?></strong>
						<br>
						 <?php echo get_post_meta( $post->ID, 'publishing_year', true ); ?>
					</div>
				</div>
                        </a>
                    </article>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; endif; ?>
		
	</section>
	<!-- </section> -->
	
<?php get_footer(); ?>
