<?php
// Template Name: form
get_header(); 

// Check if form is submitted
if (isset($_POST['submit'])) {
    global $wpdb;

    // Prepare data to be inserted
    $data = array(
        'userName' => sanitize_text_field($_POST['userName']),
        'pledgeText' => sanitize_textarea_field($_POST['pledgeText'])
    );

    // Handle file upload
    if (!empty($_FILES['pledgeImage']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        $uploadedfile = $_FILES['pledgeImage'];
        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

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

    // Use the correct table name with the proper prefix
    $table_name = $wpdb->prefix . 'pledge_wall';

    // Insert data into the table
    $result = $wpdb->insert($table_name, $data);

    if ($result === false) {
        echo "<script>alert('Error: Pledge not saved.');</script>";
    } else {
        echo "<script>alert('Error: Pledge saved.');</script>";
        // wp_redirect(home_url('/thank-you'));
        // exit();
    }
}
?>

<div class="my-20">
   <div class="bg-white p-8 max-w-[600px] mx-auto border rounded-md">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold">Event Banner</h1>
        </div>
        <form id="pledgeForm" role="form" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="name">Name</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="userName" type="text" placeholder="Your Name" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="pledge">Make Your Pledge!</label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="pledge" name="pledgeText" placeholder="Your Pledge" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="image">Upload your Picture</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" name="pledgeImage" type="file" required>
            </div>
            <div class="flex items-center justify-center">
                <button type="submit" name="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
            </div>
        </form>
    </div>
</div>

<?php get_footer(); ?>