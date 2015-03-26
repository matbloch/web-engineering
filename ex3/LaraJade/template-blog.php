<?php /* Template Name: Blog Template */ get_header(); ?>

	<!-- <section> -->
	<section class="blog padding-10">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php
				// get posts
				$args = array(
					'numberposts' => 4,
					'post_type' => 'post',
					'post_status' => 'publish');
				
				$recent_posts = wp_get_recent_posts( $args , OBJECT);

				$i = 1;
				?>
				
					<?php foreach($recent_posts as $post): ?>
						<?php if($i%3==0 || $i==1){echo '<ul class="row">';} ?>
						
						<li class="col-6 padding-10">
							<div class="padding-20 bg-clr-white-transp">
								<div>
									<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>" alt="">
									<strong><?php echo $post->post_title; ?></strong>.
									<?php echo $post->post_content; ?>
								</div>
							</div>
						</li>
						
						<?php if($i%2==0){echo '<ul>';} ?>

					<?php $i++;endforeach; ?>

			</article>
		<?php endwhile;endif; ?>
	</section>
	<!-- </section> -->
	
	
<?php get_footer(); ?>
