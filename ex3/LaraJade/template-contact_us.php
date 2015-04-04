<?php /* Template Name: Contact us Template */ get_header(); ?>

	<!-- <section> -->
	<section class="contactus row">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<h2 class="clr-white">Contact Me</h2>
				<?php 
				$form = new ContactForm(); 
				$form->handle_contact_request();
				$form->display_contact_form();
				?>
			</article>
		<?php endwhile;endif; ?>
	</section>
	<!-- </section> -->
	
	
<?php get_footer(); ?>
