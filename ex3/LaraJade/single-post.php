<?php /* Single post template*/ get_header(); ?>

	<!-- <section> -->
	<section class="single-post row">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(array("padding-20", "row")); ?>>
						<div class="col-3 padding-20">
							<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" alt="">
						</div>
						<div class="col-9 padding-20">
							<?php the_content(); ?>
						</div>
				<br class="clear">

				<?php edit_post_link(); ?>

			</article>
		<?php endwhile;endif; ?>
	</section>
	<!-- </section> -->

<?php get_footer(); ?>
