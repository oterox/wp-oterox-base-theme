<?php 
/**
 * functions.php
 *
 * Theme's functions and definitions
 */


/**
 * ----------------------------------------------------
 * Define constants
 * ----------------------------------------------------
 */

define('THEMEROOT', get_stylesheet_directory_uri() );
define('IMAGES', THEMEROOT . '/images');
define('SCRIPTS', THEMEROOT . '/js');
define('FRAMEWORK', get_template_directory() . '/framework');

/**
 * ----------------------------------------------------
 * Load framework
 * ----------------------------------------------------
 */
require_once(FRAMEWORK . '/init.php');

/**
 * ----------------------------------------------------
 * Set up the content width
 * ----------------------------------------------------
 */
if(!isset($content_width)){
	$content_width = 800;
}

/**
 * ----------------------------------------------------
 * Set up theme default
 * ----------------------------------------------------
 */
if( !function_exists('ox_setup')){
	function ox_setup(){
		/**
		 * Make theme available for translation
		 */
		$lang_dir = THEMEROOT . '/languages';
		load_theme_textdomain('ox', $lang_dir);

		/**
		 * Add support for post formats
		 */
		add_theme_support('post-formats',
			array(
				'gallery',
				'link',
				'image',
				'video',
				'audio'
			)
		);

		/**
		 * Add support for automitic feed links
		 */
		add_theme_support( 'automatic-feed-links');
		
		/**
		 * Add support for post thumbnails
		 */	
		add_theme_support( 'post-thumbnails');

		/**
		 * Register nav menus
		 */
		register_nav_menus(
			array(
				'main-menu' => __('Main Menu','ox')
			)
		);

	}

	add_action('after_setup_theme','ox_setup');
}


/**
 * ----------------------------------------------------
 * Meta information
 * ----------------------------------------------------
 */
if( !function_exists('ox_post_meta')){
	function ox_post_meta(){
		echo '<ul class="list-inline entry-meta">';

		if(get_post_type() === 'post'){
			// If the post is sticky mark it
			if(is_sticky()){
				echo '<li class="meta-featured-post"><i class="fa fa-thumb-tack"></i> ' . __('Sticky','ox') . '</li>';
			}

			// Get the post author
			printf(
				'<li class="meta-author"><a href="%1$s" rel="author">%2$s</a></li>',
				esc_url( get_author_posts_url( get_the_author_meta('ID'))),
				get_the_author()
			);

			// Get the date
			echo '<li class="meta-date">' . get_the_date() . '</li>';

			// Categories
			$category_list = get_the_category_list(', ');
			if($category_list){
				echo '<li class="meta-categories">' . $category_list . '</li>';
			}

			// Tags
			$tag_list = get_the_tag_list('', ', ');
			if($tag_list){
				echo '<li class="meta-tags">' . $tag_list . '</li>';
			}

			// Comments
			if( comments_open() ):
				echo '<li>';
				echo '<span class="meta-reply">';
				comments_popup_link( __('Leave a comment', 'ox'), __('One comment','ox'), __('View all % comments','ox'));
				echo '</span>';
				echo '</li>';
			endif;

			// Edit link
			if( is_user_logged_in()){
				echo '<li>';
				edit_post_link( __('Edit','ox'), '<span class="meta-edit">', '</span>');
				echo '</li>';
			}
		}	
	}
}

/**
 * ----------------------------------------------------
 * Display navigation to the next/prev set of posts
 * ----------------------------------------------------
 */
if( !function_exists('ox_paging_nav')){
	function ox_paging_nav(){
		echo '<ul>';
		if(get_previous_posts_link()):
			echo '<li class="next">';
			previous_posts_link( __('Newer posts &rarr;','ox'));
			echo '</li>';
		endif;
		if(get_next_posts_link()):
			echo '<li class="previous">';
			next_posts_link( __('&larr; Older posts','ox'));
			echo '</li>';
		endif;
		echo '</ul>';
	}
}

/**
 * ----------------------------------------------------
 * Register widget areas
 * ----------------------------------------------------
 */
if(!function_exists('ox_widget_init')){
	function ox_widget_init(){
		if(function_exists('register_sidebar')){
			register_sidebar(
				array(
					'name' => __( 'Main Widget Area', 'ox' ),
					'id' => 'sidebar-1',
					'description' => __( 'Appears on posts and pages.', 'ox' ),
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget' => '</div> <!-- end widget -->',
					'before_title' => '<h5 class="widget-title">',
					'after_title' => '</h5>',					
				)
			);

			register_sidebar(
				array(
					'name' => __( 'Footer Widget Area', 'ox' ),
					'id' => 'sidebar-2',
					'description' => __( 'Appears on the footer.', 'ox' ),
					'before_widget' => '<div id="%1$s" class="widget col-sm-3 %2$s">',
					'after_widget' => '</div> <!-- end widget -->',
					'before_title' => '<h5 class="widget-title">',
					'after_title' => '</h5>',
				)
			);
		}
	}

	add_action( 'widgets_init', 'ox_widget_init' );
}

/**
 * ----------------------------------------------------------------------------------------
 * Function that validates a field's length.
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'ox_validate_length' ) ) {
	function ox_validate_length( $fieldValue, $minLength ) {
		// First, remove trailing and leading whitespace
		return ( strlen( trim( $fieldValue ) ) > $minLength );
	}
}

/**
 * ----------------------------------------------------------------------------------------
 * 9.0 - Include the generated CSS in the page header.
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'ox_load_wp_head' ) ) {
	function ox_load_wp_head() {
		// Get the logos
		$logo = IMAGES . '/logo.png';
		$logo_retina = IMAGES . '/logo@2x.png';

		$logo_size = getimagesize( $logo );
		?>
		
		<!-- Logo CSS -->
		<style type="text/css">
			.site-logo a {
				background: transparent url( <?php echo $logo; ?> ) 0 0 no-repeat;
				width: <?php echo $logo_size[0] ?>px;
				height: <?php echo $logo_size[1] ?>px;
				display: inline-block;
			}

			@media only screen and (-webkit-min-device-pixel-ratio: 1.5),
			only screen and (-moz-min-device-pixel-ratio: 1.5),
			only screen and (-o-min-device-pixel-ratio: 3/2),
			only screen and (min-device-pixel-ratio: 1.5) {
				.site-logo a {
					background: transparent url( <?php echo $logo_retina; ?> ) 0 0 no-repeat;
					background-size: <?php echo $logo_size[0]; ?>px <?php echo $logo_size[1]; ?>px;
				}
			}
		</style>

		<?php
	}

	add_action( 'wp_head', 'ox_load_wp_head' );
}

/**
 * ----------------------------------------------------------------------------------------
 * 10.0 - Load the custom scripts for the theme.
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'ox_scripts' ) ) {
	function ox_scripts() {
		// Adds support for pages with threaded comments
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Register scripts
		wp_register_script( 'bootstrap-js', 'http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js', array( 'jquery' ), false, true );
		wp_register_script( 'ox-custom', SCRIPTS . '/scripts.js', array( 'jquery' ), false, true );

		// Load the custom scripts
		wp_enqueue_script( 'bootstrap-js' );
		wp_enqueue_script( 'ox-custom' );

		// Load the stylesheets
		wp_enqueue_style( 'font-awesome', THEMEROOT . '/css/font-awesome.min.css' );
		wp_enqueue_style( 'ox-master', THEMEROOT . '/css/master.css' );
	}

	add_action( 'wp_enqueue_scripts', 'ox_scripts' );
}

?>