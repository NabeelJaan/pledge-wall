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

// /**
//  * Enqueue theme assets.
//  */
function tailpress_enqueue_scripts() {
    $theme = wp_get_theme();

    wp_enqueue_style('tailpress', get_template_directory_uri() . '/css/app.css', array(), $theme->get('Version'));

    $ajax_nonce = wp_create_nonce('custom-pw');

    wp_localize_script('custom-pw', 'customPw', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'security' => $ajax_nonce,
        'uploadsUrl' => wp_upload_dir()['baseurl'] . '/'
    ));

    wp_enqueue_script('tailpress', get_template_directory_uri() . '/resources/js/app.js', array(), $theme->get('Version'));
}

add_action('wp_enqueue_scripts', 'tailpress_enqueue_scripts');

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


function enqueue_add_pledge_scripts() {
    if (is_page_template('template_form.php')) { // Replace 'template-name.php' with your template file name
       wp_enqueue_script('jquery');

		wp_enqueue_script(
			'custom-add-pledge',
			get_template_directory_uri() . '/resources/js/custom-add-pledge.js',
			array('jquery'),
			filemtime(get_template_directory() . '/resources/js/custom-add-pledge.js'), 
			true
		);

    // Localize script to pass ajaxurl and security nonce
    wp_localize_script('custom-add-pledge', 'customPw', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('custom_pw_nonce')
    ));
    }
}
add_action('wp_enqueue_scripts', 'enqueue_add_pledge_scripts');

function custom_pw_add_pledge() {
    check_ajax_referer('custom_pw_nonce', 'security');
	 global $wpdb;
     // Prepare data to be inserted
    $data = array(
        'userName' => sanitize_text_field($_POST['userName']),
        'pledgeText' => sanitize_textarea_field($_POST['pledgeText'])
    );

    // Handle file upload for pledge image
    if (!empty($_FILES['pledgeImage']['name'])) {

        $uploadedfile = $_FILES['pledgeImage'];
        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
		$attachment_id = '';
        if ($movefile && !isset($movefile['error'])) {
            $filename = $movefile['file'];

            // The ID of the newly created attachment.
            $attachment_id = wp_insert_attachment(array(
                'guid' => $movefile['url'],
                'post_mime_type' => $movefile['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                'post_content' => '',
                'post_status' => 'inherit'
            ), $filename);

            // Generate the metadata for the attachment, and update the database record.
            $attach_data = wp_generate_attachment_metadata($attachment_id, $filename);
            wp_update_attachment_metadata($attachment_id, $attach_data);

            // Add attachment ID to the data array
            $data['pledgeImage'] = $attachment_id;
        } else {
            echo "<script>alert('Error: " . $movefile['error'] . "');</script>";
        }
    }

    $table_name = $wpdb->prefix . 'pledge_wall';
    $result = $wpdb->insert($table_name, $data);

    if ($result) {
        wp_send_json_success(array('message' => 'Pledge added successfully.'));
    } else {
        wp_send_json_error(array('message' => 'Failed to add pledge.'));
    }
}
add_action('wp_ajax_custom_pw_add_pledge', 'custom_pw_add_pledge');
add_action('wp_ajax_nopriv_custom_pw_add_pledge', 'custom_pw_add_pledge');


add_action('wp_ajax_add_pledge', 'custom_pw_add_pledge');
add_action('wp_ajax_nopriv_add_pledge', 'custom_pw_add_pledge');


function enqueue_custom_scripts() {
	wp_enqueue_script('jquery');
    if (is_page_template('template_pledge-wall.php')) { // Replace 'template-name.php' with your template file name
        wp_enqueue_script('load-more-pledges', get_template_directory_uri() . '/resources/js/custom-pw.js', array('jquery'), null, true);
        $ajax_script = 'var ajaxurl = "' . admin_url('admin-ajax.php') . '";';
        wp_add_inline_script('load-more-pledges', $ajax_script, 'before');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');



function load_more_pledges() {
   global $wpdb;
$table_name = $wpdb->prefix . 'pledge_wall';

// Get the last pledge ID sent in the request
$last_id = intval($_POST['last_id']);
// Fetch the next set of pledges
$results = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM $table_name WHERE id > $last_id ORDER BY id ASC")
);

if (!empty($results)) {
    // Output the pledges as HTML
    foreach ($results as $pledge) {
        $image_url = wp_get_attachment_url($pledge->pledgeImage); // Assuming pledgeImage is an attachment ID
        
        echo '<div class="bg-white min-h-[250px] p-3 border-2 border-red-600 rounded-md shadow-md pledgeItem" data-id="' . esc_attr($pledge->id) . '">';
        echo '<div class="flex justify-between items-center mb-4">';
        echo '<h2 class="text-red-600 font-bold">' . esc_html($pledge->userName) . '</h2>';
        echo '</div>';
        
        if (!empty($image_url)) {
            echo '<img class="w-full h-32 object-cover mb-2" src="' . esc_url($image_url) . '" alt="Pledge Image">';
        } else {
            // echo '<p class="mb-6">No image available for this pledge.</p>';
        }
        
        echo '<p>' . esc_html($pledge->pledgeText) . '</p>';
        echo '</div>';
    } 
}else {
    // No more pledges found
    echo 'no-more-pledges';
}

wp_die();

}
add_action('wp_ajax_load_more_pledges', 'load_more_pledges');
add_action('wp_ajax_nopriv_load_more_pledges', 'load_more_pledges');

