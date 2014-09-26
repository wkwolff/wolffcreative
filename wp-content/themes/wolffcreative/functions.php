<?php
/**
 * wolffcreative functions and definitions
 *
 * @package wolffcreative
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'wolffcreative_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wolffcreative_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on wolffcreative, use a find and replace
	 * to change 'wolffcreative' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'wolffcreative', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'front-thumb', 600, 300, array( 'left', 'top' ) );
	add_image_size( 'front-square', 300, 300, array( 'center', 'center' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Menu', 'wolffcreative' ),
		'social' => __( 'Social Menu', 'wolffcreative'),

	) );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wolffcreative_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // wolffcreative_setup
add_action( 'after_setup_theme', 'wolffcreative_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function wolffcreative_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'wolffcreative' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Home Callouts', 'wolffcreative' ),
		'id'            => 'callouts',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Banner', 'wolffcreative' ),
		'id'            => 'banners',
		'description'   => '',
		'before_widget' => '<div id="banner" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'wolffcreative_widgets_init' );

add_filter('wolfcre_test', 'overrideTestFilter', 10, 3);
add_filter('wolfcre_test', 'overrideTestFilter2', 9, 3);

function overrideTestFilter($test_content){
	return 'Testing';
}

function overrideTestFilter2($test_content){
	return $test_content.' - Filter 2';
}

/**
 * Enqueue scripts and styles.
 */
function wolffcreative_scripts() {
	wp_enqueue_style( 'wolffcreative', get_template_directory_uri() . '/stylesheets/style.css' );

	wp_enqueue_script( 'wolffcreative-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'wolffcreative-masonry', get_template_directory_uri() . '/js/masonry.min.js', array(), '20140914', true );

	wp_enqueue_style('fontawesome', 'http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');            

	wp_enqueue_script( 'wolffcreative-custom', get_template_directory_uri() . '/js/custom.js', array(), '20140914', true );
	
	wp_enqueue_script( 'wolffcreative-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wolffcreative_scripts' );

// Create Short Code for Slider on Home page Template 
 
add_shortcode('work_slider', 'displayWorkSlider');
function displayWorkSlider(){
	$loop = new WP_Query(array('post_type' => 'wc_gallery', 'posts_per_page' => 1));
	
	ob_start();
	while($loop->have_posts()) : $loop->the_post();
		the_title();
		the_permalink();
		the_post_thumbnail();
		the_content();
		echo get_post_meta(get_the_ID(), 'wpshed_textfield', true);
		echo '<br />';
	endwhile;
	$content = ob_get_clean();
	return $content;
}

// Create Short Code for Portfolio Category

add_shortcode('portfolio', 'displayPortfolio');
function displayPortfolio($atts, $content = NULL){
	$default_atts = array(
		'template'	=> 'portfolio.php',
		'limit'		=> -1
	);
	
	$options = (array)$atts + $default_atts;

	$args = array(
		'cat'				=> 32,
		'posts_per_page'	=> $options['limit']
	);
	
	$loop = new WP_Query($args);
	
	ob_start();
	include('templates/'.$options['template']);
	return ob_get_clean();
}

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

function use_post_format_templates( $template ) {
    if ( is_single() && has_post_format() ) {
        $post_format_template = locate_template( 'single-' . get_post_format() . '.php' );
        if ( $post_format_template ) {
            $template = $post_format_template;
        }
    }
 
    return $template;
}   
add_filter( 'template_include', 'use_post_format_templates' );
