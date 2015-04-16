<?php /* Single post template*/ get_header(); 

	// check if post needs to be edited
	if (isset($_POST['post_id']) && current_user_can( 'edit_post', $_POST['post_id'] )) {
		$post_id=$_POST['post_id'];
		$post = array(	'ID' => $post_id,
						'post_title' => $_POST['post_title'],
						'post_content' => $_POST['post_content']);
		// check if thumbnail needs to be edited
		if (is_uploaded_file($_FILES['post_thumb']['tmp_name'])) {
			require_once('wp-admin/includes/admin.php');
			$thumb_id = media_handle_upload('post_thumb', $post_id);
			set_post_thumbnail( $post_id, $thumb_id );
		}
		wp_update_post($post);
	}
?>

	<!-- <form> -->
	<form id="editpostform" method="post">
		<input type="hidden" name="post_id" id="formeditpostid"/>
		<input type="hidden" name="post_title" id="formtitle"/>
		<input type="hidden" name="post_content" id="formcontent"/>
		<input type="file" name="post_thumb" id="formthumbfile" style="display:none"/>
		<input type="submit" value="Submit" id="submitbutton" style="display:none"/>
	</form>

	<!-- <section> -->
	<section class="single-post row">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(array("padding-20", "row")); ?>>
						<div class="col-3 padding-20">
							<img id="postthumb<?php echo $post->ID; ?>" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" alt="">
							<?php if ( current_user_can( 'edit_post', $post->ID ) ) { ?>
								<br/><br/><a href="javascript:editPost(<?php echo $post->ID; ?>);" id="editlink<?php echo $post->ID; ?>">Edit In-line</a> &nbsp;
							<?php } ?>	
						</div>
						<div class="col-9 padding-20">
							<h2 class="posttitle" id="posttitle<?php echo $post->ID; ?>"><?php echo $post->post_title; ?></h2>

							<div class="posttext" id="post<?php echo $post->ID; ?>"><?php echo the_content(); ?></div>
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
							
						</div>
				<br class="clear">
			</article>
		<?php endwhile;endif; ?>
	</section>
	<!-- </section> -->

<?php get_footer(); ?>
