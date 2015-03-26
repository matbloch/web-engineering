<?php /* Template Name: Home Template */ get_header(); ?>

	<!-- <section> -->
	<section class="intro row">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(array("description", "col-5", "padding-20", "clr-white")); ?>>

				<?php the_content(); ?>

				<br class="clear">

				<?php edit_post_link(); ?>

			</article>
		<?php endwhile;endif; ?>
	</section>
	<!-- </section> -->

<?php get_footer(); ?>
