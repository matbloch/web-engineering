<?php /* Single post template*/ get_header(); ?>

	<!-- <section> -->
	<section class="single-post row">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(array("padding-20", "row")); ?>>
						<div class="col-3 padding-20">
							<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" alt="">
						</div>
						<div class="col-9 padding-20">
                            <strong><?php echo $post->post_title; ?></strong></br>
							<?php the_content(); ?>
						</div>
                <?php
// Find connected pages
$connected = new WP_Query( array(
  'connected_type' => 'posts_to_portfolios',
  'connected_items' => get_queried_object(),
  'nopaging' => true,
) );

// Display connected pages
if ( $connected->have_posts() ) :
?>
<h3>Related portfolios:</h3>
<ul>
<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile; ?>
</ul>

<?php 
// Prevent weirdness
wp_reset_postdata();

endif;
?>
				<br class="clear">
				<?php edit_post_link(); ?>

			</article>
		<?php endwhile;endif; ?>
	</section>
	<!-- </section> -->

<?php get_footer(); ?>
