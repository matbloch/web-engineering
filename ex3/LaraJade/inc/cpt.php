<?php

class CPT {

	public function __construct() {
	
		/* register the post types */
		add_action( 'init', array($this, 'register_cpts') );
		
		/* add meta boxes */
		add_action( 'init', array($this, 'post_meta_boxes_setup') );
		
		/* saving hook */
		add_action( 'save_post', array($this, 'save_meta_box_data') );
		
	}

	public function register_cpts(){
	
		/* portfolio */
	
		register_post_type( 'portfolio',
		array(
		'labels' => array(
		'name' => 'Portfolio',
		'singular_name' => 'Portfolio entry',
		'add_new' => 'add',
		'add_new_item' => 'New entry',
		'edit' => 'edit',
		'edit_item' => 'edit entry',
		'new_item' => 'new entry',
		'view' => 'view',
		'view_item' => 'view entry',
		'search_items' => 'search entry',
		'not_found' => 'no entry found',
		'not_found_in_trash' => 'no entry found in trash',
		),
		'public' => true,
        'rewrite' => true,
		'show_ui' => true,
		'supports' => array('title', 'thumbnail', 'editor'),
		'has_archive' => true,
		'rewrite' => array('slug'=>'portfolio_posts')
		)
		);
		
	}
	
	/* Meta box setup function. */
	function post_meta_boxes_setup() {

		add_action( 'add_meta_boxes', array($this, 'add_post_meta_boxes') );
	}

	function add_post_meta_boxes() {

		add_meta_box(
		'lj-portfolio-year', 
		'Publishing year',
		array($this,'render_year_metabox'),   // Callback function
		'portfolio',
		'side', 
		'default'  
		);
	}
	
	function render_year_metabox( $post ) {

		wp_nonce_field( 'portfolio_meta_box', 'portfolio_meta_box_nonce' );

		$value = get_post_meta( $post->ID, 'publishing_year', true );

		echo '<label for="publishing_year">Publishing year</label> ';
		echo '<input type="text" id="publishing_year" name="publishing_year" value="' . esc_attr( $value ) . '" size="25" />';
	}
	
		
	function save_meta_box_data( $post_id ) {

		if ( ! isset( $_POST['portfolio_meta_box_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['portfolio_meta_box_nonce'], 'portfolio_meta_box' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( isset( $_POST['post_type'] ) && 'portfolio' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		if ( ! isset( $_POST['publishing_year'] ) ) {
			return;
		}


		$my_data = sanitize_text_field( $_POST['publishing_year'] );

		update_post_meta( $post_id, 'publishing_year', $my_data );
	}

	
	
}