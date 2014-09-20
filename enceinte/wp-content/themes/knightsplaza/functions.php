<?php
/**
 * kp functions and definitions
 *
 * @package kp
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'kp_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function kp_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on kp, use a find and replace
	 * to change 'kp' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'kp', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'nav-upper' => __( 'Utility Menu', 'kp' ),
		'nav-mid' => __( 'Primary Menu', 'kp' ),
		'footer-upper' => __( 'Footer Upper', 'kp' ),
		'footer-lower-smedia' => __( 'Footer Social Media', 'kp' ),
		'footer-lower-ucf' => __( 'Footer UCF Links', 'kp' ),
		'footer-lower-contact' => __( 'Footer Contact', 'kp' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
/* 	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) ); */
	
}
endif; // kp_setup
add_action( 'after_setup_theme', 'kp_setup' );

/**
 * Creating custom post types for Knights Plaza Pages
 */
 
add_action( 'init', 'create_post_type_location' );
function create_post_type_location() { 
 
 register_post_type( 'locations',
		array(
			'labels' => array(
				'name' => __( 'Locations', 'kp' ),
				'singular_name' => __( 'Location', 'kp' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'locations'),
			'menu_position' => 5,
			'taxonomies' => array('category'),
	//		'capability_type' => 'locations',
		)
	);
}

 
add_action( 'init', 'create_post_type' );
function create_post_type() {
	/*
register_post_type( 'deals',
		array(
			'labels' => array(
				'name' => __( 'Deals', 'kp' ),
				'singular_name' => __( 'Deals', 'kp' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'deals'),
		)
	);
*/

	register_post_type( 'home',
		array(
			'labels' => array(
				'name' => __( 'Home Page', 'kp' ),
				'singular_name' => __( 'Home Page', 'kp' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'home'),
		)
	);

	
	/*
register_post_type( 'locations',
		array(
			'labels' => array(
				'name' => __( 'Locations', 'kp' ),
				'singular_name' => __( 'Location', 'kp' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'locations'),
		)
	);
*/
	
/*
	register_post_type( 'eat',
		array(
			'labels' => array(
				'name' => __( 'Eat', 'kp' ),
				'singular_name' => __( 'Eat', 'kp' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'eat'),
		)
	);
	register_post_type( 'see',
		array(
			'labels' => array(
				'name' => __( 'See', 'kp' ),
				'singular_name' => __( 'See', 'kp' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'see'),
		)
	);
	register_post_type( 'mix',
		array(
			'labels' => array(
				'name' => __( 'Mix', 'kp' ),
				'singular_name' => __( 'Mix', 'kp' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'mix'),
		)
	);
	register_post_type( 'do',
		array(
			'labels' => array(
				'name' => __( 'Do', 'kp' ),
				'singular_name' => __( 'Do', 'kp' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'do'),
		)
	);
	register_post_type( 'shop',
		array(
			'labels' => array(
				'name' => __( 'Shop', 'kp' ),
				'singular_name' => __( 'Shop', 'kp' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'shop'),
//			'menu_icon' => "",
		)
	);
*/
	
/*
	register_post_type( 'park',
		array(
			'labels' => array(
				'name' => __( 'Park', 'kp' ),
				'singular_name' => __( 'Park', 'kp' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'park'),
		)
	);
*/
	
		register_post_type( 'faqs',
		array(
			'labels' => array(
				'name' => __( 'FAQs', 'kp' ),
				'singular_name' => __( 'FAQ', 'kp' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'faqs'),
		)
	);
	
/*
	register_post_type( 'towers',
		array(
			'labels' => array(
				'name' => __( 'Towers Offers', 'kp' ),
				'singular_name' => __( 'Towers Offers', 'kp' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'towers'),
		)
	);
*/
	
/*
	register_post_type( 'tenants',
		array(
			'labels' => array(
				'name' => __( 'Tenants', 'kp' ),
				'singular_name' => __( 'Tenants', 'kp' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'tenants'),
		)
	);
*/
	
/*
	register_post_type( 'proclamation',
		array(
			'labels' => array(
				'name' => __( 'Proclamation', 'kp' ),
				'singular_name' => __( 'Proclamation', 'kp' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'proclamation'),
		)
	);
*/
	
	register_post_type( 'footer_upper',
		array(
			'labels' => array(
				'name' => __( 'Footer - Upper', 'kp' ),
				'singular_name' => __( 'Footer - Upper', 'kp' )
			),
			'supports' => array( 'editor', 'comments', 'thumbnail', 'custom-fields'),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'footer-upper'),
		)
	);
	
	
}

//add_action( 'admin_head', 'admin_icons');



/* Remove submenu items from admin menu */
function adjust_the_wp_menu() {
	$page = remove_submenu_page( 'themes.php', 'customize.php' );
// print_r($GLOBALS['menu']);
}
add_action( 'admin_menu', 'adjust_the_wp_menu');


/* Reorder the admin menu */
add_filter("custom_menu_order", "allowMenuStructure");
add_filter("menu_order", "loadMenuStructure");
 
function allowMenuStructure() {
    return true;
}
 
function loadMenuStructure() {
    return array("index.php", "edit.php", "edit-comments.php", "edit.php?post_type=ai1ec_event", "edit.php?post_type=locations", "edit.php?post_type=towers", "edit.php?post_type=faqs");
}

/**
 * Register widgetized area and update sidebar with default widgets
 */
function kp_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'kp' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'kp_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function kp_scripts() {
	wp_enqueue_style( 'kp-style', get_stylesheet_uri() );

	wp_enqueue_script( 'kp-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'kp-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'kp-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'kp_scripts' );

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

// remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

/**
 * Enable jQuery and Bootstrap
 */

function iamb_inc_bootstrap() {

	wp_register_script(
		'js_bootstrap',
		get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js',
		array('jquery'),
		true
	);
	
	wp_register_script(
		'js_iamb',
		get_template_directory_uri() . '/js/site.js',
		array('jquery')
	/* $_SERVER['REQUEST_TIME'] */ // TAKE OUT FOR PROD!!!!
	);
	
	wp_register_script(
		'js_iamb_home',
		get_template_directory_uri() . '/js/home.js',
		array('jquery')
	/* $_SERVER['REQUEST_TIME'] */ // TAKE OUT FOR PROD!!!!
	);
	
	wp_register_script(
	'js_cycle',
	get_template_directory_uri() . '/js/jquery.cycle.all.js',
	array('jquery'),
	true
	);
	
	wp_register_script(
	'js_skrollr',
	get_template_directory_uri() . '/js/skrollr.min.js',
	array('jquery'),
	true
	);

	/*
wp_register_script(
	'js_tooltip',
	get_template_directory_uri() . '/bootstrap/js/tooltip.js',
	array('jquery'),
	true
	);
*/

	/* wp_enqueue_script('js_tooltip'); */
	wp_enqueue_script('js_bootstrap');
	wp_enqueue_script('js_iamb');	
	wp_enqueue_script('js_iamb_home');	
	wp_enqueue_script('js_cycle');
//	wp_enqueue_script('js_skrollr');
}
add_action('wp_enqueue_scripts', 'iamb_inc_bootstrap');


/* Add TypeKit Fonts */

function iamb_add_typekit() {
        
  echo '<script type="text/javascript" src="//use.typekit.net/ejt5frx.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>';

}

add_filter( 'wp_head', 'iamb_add_typekit' ); 

/** 
* Get the CSS
*/

function iamb_inc_admin_styles() {
	
	wp_register_style('css_iamb_admin',
	get_template_directory_uri() . '/css/admin.css',
	array(),
	'all'
	);
	wp_enqueue_style('css_iamb_admin');
	
}
add_action( 'admin_enqueue_scripts', 'iamb_inc_admin_styles' );

function iamb_inc_styles() {
	
	wp_register_style('css_bootstrap',
	get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css',
	array(),
	'all'
	);
	wp_enqueue_style('css_bootstrap');
	
	wp_register_style('css_iamb',
	get_template_directory_uri() . '/css/site.css',
	array()
	/* $_SERVER['REQUEST_TIME'] */ // TAKE OUT FOR PROD!!!!
	);
	wp_enqueue_style('css_iamb');
	
	wp_register_style('css_iamb_boxes',
	get_template_directory_uri() . '/css/boxes.css',
	array(),
	'all'
	);
	wp_enqueue_style('css_iamb_boxes');
	
	
	if ( is_page( 'see' ) ) {
	
	wp_register_style('css_iamb_event_views',
	get_template_directory_uri() . '/css/events-alt-views.css',
	array(),
	'all'
	);
	wp_enqueue_style('css_iamb_event_views');
	
	}
	
}
add_action( 'wp_enqueue_scripts', 'iamb_inc_styles', 99);	


function iam_inc_fonts(){

wp_enqueue_style('css_glyphicons');
	
	/*
wp_register_style('css_ss_symbolicons',
	get_template_directory_uri() . '/fonts/ss-symbolicons-block/webfonts/ss-symbolicons-block.css',
	array(),
	'all'
	);	
	wp_enqueue_style('css_ss_symbolicons');
*/
	
	wp_register_style('css_kp_font',
	get_template_directory_uri() . '/fonts/kp-font/style.css',
	array(),
	'all'
	);
	wp_enqueue_style('css_kp_font');

}
add_action( 'wp_enqueue_scripts', 'iam_inc_fonts');

/* Disable wpautop */
/*
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );
*/

/* Change Admin Footer */
add_filter('admin_footer_text', 'remove_footer_admin'); 
function remove_footer_admin () {
echo "&copy; " .  date('Y') . " " . get_bloginfo('name') . ". Need assistance? Contact Brian Compton at <a href='mailto:brian.compton@ucf.edu'>brian.compton@ucf.edu</a> or (407) 823-4506.";
}


/* Add description to mid-nav menu */

class Menu_With_Description extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="col-md-2 col-sm-2 col-xs-2 ' . esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->title ) .'"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes . 'data-subtitle="' . $item->description . '"><span class="kp-font kp-' . esc_attr( $item->attr_title ) . '" aria-hidden="true"></span>';
			/* $item_output .= '<a'. $attributes . '><i class="ss-symbolicons-block ss-' . esc_attr( $item->attr_title ) . '"></i>' ; */
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
//		$item_output .= ' data-subtitle="' . $item->description . '" ';
		/* $item_output .= '<div class="sub-title">' . $item->description . '</div></a>'; */
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

// Remove images from the_content() if the page is 'see'

		/*
add_filter( 'the_content', 'strip_images', 2);
		
		function strip_images( $content ) {
			if ( is_page( 'see' ) ) {
			return preg_replace( '/<img[^>]+./','',$content );
			} else {
			return $content;
			}
		}
		
*/

/* Customize the login page */

		// Inject stylesheet to customize the login page
		function custom_login_logo() {
				echo '<link rel="stylesheet" href="' . get_template_directory_uri() . '/css/admin.css">';
		}
		add_action('login_head', 'custom_login_logo');


		// changing the login page URL
    function put_my_url(){
    return ( get_bloginfo( 'url' ) ); // putting my URL in place of the WordPress one
    }
    add_filter('login_headerurl', 'put_my_url');

		// changing the login page URL hover text
    function put_my_title(){
    return ( get_bloginfo( 'title' ) ); // changing the title from "Powered by WordPress" to whatever you wish
    }
    add_filter('login_headertitle', 'put_my_title');


/* Add favicon and apple touch icons */

		// Set the favicon
		function blog_favicon() {
			echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_template_directory_uri().'/img/favicon.ico" />';
		}
		add_action('wp_head', 'blog_favicon');
		add_action('admin_head', 'blog_favicon');
		
		// Set the Apple Touch icons
		function iamb_touch_icons() {
			echo '<link rel="apple-touch-icon" href="' . get_template_directory_uri() . '/img/touch-icon-iphone.png" />';
			echo '<link rel="apple-touch-icon" sizes="72x72" href="' . get_template_directory_uri() . '/img/touch-icon-ipad.png" />';
			echo '<link rel="apple-touch-icon" sizes="114x114" href="' . get_template_directory_uri() . '/img/touch-icon-iphone-retina.png" />';
			echo '<link rel="apple-touch-icon" sizes="144x144" href="' . get_template_directory_uri() . '/img/touch-icon-ipad-retina.png" />';
		}
		add_action('wp_head', 'iamb_touch_icons');
		add_action('admin_head', 'iamb_touch_icons');
		
/* Enable shortcode for search */
add_shortcode('wpbsearch', 'get_search_form');

/* Add User Role for Locations */
/*
add_role( 'location_manager',
					'Location Manager',
					array(
									'publish_locations' => true,
							    'edit_locations' => true,
							    'edit_others_locations' => true,
							    'delete_locations' => true,
							    'delete_others_locations' => true,
							    'read_private_locations' => true,
							    'edit_locations' => true,
							    'delete_locations' => true,
							    'read_locations' => true,
								)
								);
*/

// remove_role('location_manager');

