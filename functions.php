<?php

/**
 * Theme setup.
 */
function tailpress_setup() {
	add_theme_support( 'title-tag' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'tailpress' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

    add_theme_support( 'custom-logo' );
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );

	add_theme_support( 'editor-styles' );
	add_editor_style( 'css/editor-style.css' );
}

add_action( 'after_setup_theme', 'tailpress_setup' );

/**
 * Enqueue theme assets.
 */
function tailpress_enqueue_scripts() {
	$theme = wp_get_theme();

	wp_enqueue_style( 'tailpress', tailpress_asset( 'css/app.css' ), array(), $theme->get( 'Version' ) );

	wp_enqueue_script('jquery');
	wp_enqueue_script('custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery'), null, true);
	wp_localize_script('custom-js', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

	wp_enqueue_script( 'tailpress', tailpress_asset( 'js/app.js' ), array(), $theme->get( 'Version' ) );
}

add_action( 'wp_enqueue_scripts', 'tailpress_enqueue_scripts' );

/**
 * Get asset path.
 *
 * @param string  $path Path to asset.
 *
 * @return string
 */
function tailpress_asset( $path ) {
	if ( wp_get_environment_type() === 'production' ) {
		return get_stylesheet_directory_uri() . '/' . $path;
	}

	return add_query_arg( 'time', time(),  get_stylesheet_directory_uri() . '/' . $path );
}

/**
 * Adds option 'li_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The current item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function tailpress_nav_menu_add_li_class( $classes, $item, $args, $depth ) {
	if ( isset( $args->li_class ) ) {
		$classes[] = $args->li_class;
	}

	if ( isset( $args->{"li_class_$depth"} ) ) {
		$classes[] = $args->{"li_class_$depth"};
	}

	return $classes;
}

add_filter( 'nav_menu_css_class', 'tailpress_nav_menu_add_li_class', 10, 4 );

/**
 * Adds option 'submenu_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The current item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function tailpress_nav_menu_add_submenu_class( $classes, $args, $depth ) {
	if ( isset( $args->submenu_class ) ) {
		$classes[] = $args->submenu_class;
	}

	if ( isset( $args->{"submenu_class_$depth"} ) ) {
		$classes[] = $args->{"submenu_class_$depth"};
	}

	return $classes;
}

add_filter( 'nav_menu_submenu_css_class', 'tailpress_nav_menu_add_submenu_class', 10, 3 );



function handle_pledge_form_submission() {
	// Check nonce for security
	check_ajax_referer('pledge_form_nonce', 'security');

	// Get form data
	$name = sanitize_text_field($_POST['name']);
	$pledge = sanitize_textarea_field($_POST['pledge']);
	$picture = $_FILES['picture'];

	// Handle file upload
	if (!function_exists('wp_handle_upload')) {
		 require_once(ABSPATH . 'wp-admin/includes/file.php');
	}

	$upload_overrides = array('test_form' => false);
	$movefile = wp_handle_upload($picture, $upload_overrides);

	if ($movefile && !isset($movefile['error'])) {
		 $picture_url = $movefile['url'];
	} else {
		 wp_send_json_error(array('message' => $movefile['error']));
		 return;
	}

	// Insert data into the database
	global $wpdb;
	$table_name = $wpdb->prefix . 'pledges';
	$wpdb->insert(
		 $table_name,
		 array(
			  'name' => $name,
			  'pledge' => $pledge,
			  'picture_url' => $picture_url
		 )
	);

	// Redirect URL
	$redirect_url = home_url('/thank-you/');
	wp_send_json_success(array('redirect_url' => $redirect_url));
}
add_action('wp_ajax_nopriv_handle_pledge_form_submission', 'handle_pledge_form_submission');
add_action('wp_ajax_handle_pledge_form_submission', 'handle_pledge_form_submission');


function create_pledges_table() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'pledges';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		 id mediumint(9) NOT NULL AUTO_INCREMENT,
		 name tinytext NOT NULL,
		 pledge text NOT NULL,
		 picture_url text NOT NULL,
		 PRIMARY KEY  (id)
	) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}
add_action('after_switch_theme', 'create_pledges_table');

