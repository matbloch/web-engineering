<?php /* Template Name: Contact us Template */ get_header(); ?>

	<!-- <section> -->
	<section class="contactus row">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<h2 class="clr-white">Contact Me</h2>

						<div class="row">

							<div class="col-6 padding-r-20">
								<form class="row clr-white">
								
									
									<div class="padding-b-10"><label>First name:</label><input type="text" name="firstname" ></div>
									<div class="padding-b-10"><label>Lirst name:</label><input type="text" name="lastname" ></div>
									<textarea type="text" name="message" rows="7"></textarea>
									<br>
									<button type="button" >Submit</button>
								</form>
							</div>
							<div class="col-6 padding-20 bg-clr-white-transp">
								<div >
									<strong >Email</strong><strong class="float-right">larajade@larajade.co.uk</strong>
									<br>
									<strong >Fax</strong><strong class="float-right"> +44 (0) 1234 567891</strong>
									<br>
									<strong >Address: </strong><strong> New Chrichton Cottage, Arradoul, Buckie, AB43 AP
									Scotland UK</strong>
								</div>
							</div>
						</div>

			</article>
		<?php endwhile;endif; ?>
	</section>
	<!-- </section> -->
	
	
<?php get_footer(); ?>
