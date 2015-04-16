<?php global $img_uri; ?>			
					
					<!-- <footer> -->
					<footer class="footer padding-20 clr-white bg-clr-dark-green">
					<div class="row">
						<div class="col-3 padding-lr-10">
							<strong>ADDRESS</strong>
							<br>
							<br><?php echo get_theme_mod( 'contact_address', 'No contact information has been set yet.' ); ?>
							<br><br><?php echo get_theme_mod( 'contact_phone', '' ); ?>
							<br>
							<br>
							<img width="80px" src="<?php echo $img_uri.'qcode.png'; ?>" >
						</div>
						<div class="col-3 padding-lr-10">
							<strong>About Me</strong>
							<br>
							<br>
							<?php
							$post = get_page_by_path( 'home' );
							echo lj_excerpt($post);
							?>
							<br>
							<br>
							<strong>Follow me:</strong>
							<br>
							<br>
							<div class="social-media">
								<img src="<?php echo $img_uri.'twitter.png'; ?>" >
								<img src="<?php echo $img_uri.'linkedin.png'; ?>" >
								<img src="<?php echo $img_uri.'pinterest.png'; ?>" >
								<img src="<?php echo $img_uri.'facebook.png'; ?>" >
								<img src="<?php echo $img_uri.'google_plus.png'; ?>" >
							</div>
						</div>
						<div class="col-3 padding-lr-10">
							<strong>My last post</strong>
							<br>
							<br>
							<?php
							$args = array(
								'numberposts' => 1,
								'post_type' => 'post',
								'post_status' => 'publish');
							
							$latest_post = wp_get_recent_posts( $args , OBJECT);
							if(!empty($latest_post)): ?>
                                 <strong><?php echo $latest_post[0]->post_title; ?></strong></br>
								<?php echo lj_excerpt($latest_post[0]); ?>
							
							<?php  endif; ?>
						</div>
						<div class="col-3 padding-lr-10">
							<strong>Last Project</strong>
							<br>
							</br>
							Freelance WebSite 
							<br>
							<br>
							<img  src="<?php echo $img_uri.'portfolio/p1.jpg'; ?>" >
						</div>
					</div>
					</footer>
					<!-- </footer> -->
				</div>
			</div>
			
			<?php wp_footer(); ?>
	</body>
</html>
