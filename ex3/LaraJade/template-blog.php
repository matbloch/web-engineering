<?php /* Template Name: Blog Template */ get_header(); ?>

	<!-- <section> -->
	<section class="blog padding-10">
        <?php
	// get posts
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
        'posts_per_page' => 4,
        'paged' => $paged
      );
	
        $post_query = query_posts( $args , OBJECT );
        $max_num_pages = ceil((wp_count_posts('post')->publish)/4);
	?>
        <?php
				$i = 1;
                
				?>
      <?php foreach($post_query as $post): ?>

<?php // if ($post_query->have_posts()): while ($post_query->have_posts()) : $post_query->the_post(); ?>	
						
						<?php if($i%3==0 || $i==1){echo '<ul class="row">';} ?>
						<li class="col-6 padding-10">
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="padding-20 bg-clr-white-transp post_art">
								<div>
									<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" alt="">
									<a href="<?php the_permalink(); ?>" target="_blank"><strong><?php echo $post->post_title; ?></strong></a>.
									<?php if(has_excerpt()):the_excerpt(); ?><a href="<?php echo the_permalink(); ?>" target="_blank" > Read More...</a><?php endif ?>
								</div>
							</div>
                                </article>
						</li>
						
						<?php if($i%2==0){echo '</ul>';} ?>

					<?php $i++; ?>

			
		<?php endforeach; // Reset Query
wp_reset_query();?>
        <br class="clear">
        <?php my_pagination($max_num_pages); ?> <?php //endif; ?>
	</section>
	<!-- </section> -->
	
	
<?php get_footer(); ?>
