<?php
    // Template Name: Pledge Wall
    get_header();
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'pledge_wall';
    $results = $wpdb->get_results("SELECT * FROM $table_name");
?>

<main>
    <!-- pledge Head -->
    <div class="text-white pt-[300px] pb-28 bg-cover bg-no-repeat" style="background-image: url('/wp-content/uploads/2024/06/banner-e1718627400722.webp');">
        <div class="max-w-[1200px] mx-auto">
            <div class="max-w-[700px] ml-auto mb-[-66px]">
                <h1 class="text-3xl font-bold">Apex Pledge Wall</h1>
                <p class="mt-2 text-xl">What's your pledge to live a healthier, longer, better life?</p>
            </div>
        </div>
    </div>
    <!-- Pledge -->
    <div class="max-w-[1280px] mx-auto mt-4 pb-10">
        <div class="grid grid-cols-5 gap-3">
            <?php 
                if ($results) {
                    $first = true;
                    foreach( $results as $pledge) {
                        $image_url = wp_get_attachment_url($pledge->pledgeImage); // Get the image URL
                        if ($first) {
                            $first = false;
            ?>
            <div class="w-full -mt-44 col-span-2">
                <div class="bg-white h-[498px] p-3 border-2 border-red-600 rounded-md shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-red-600 font-bold"><?php echo esc_html($pledge->userName); ?></h2>
                        <img class="w-8 h-auto" src="<?php echo esc_url($image_url); ?>" alt="Profile Picture">
                    </div>
                    <img class="w-full h-auto object-cover rounded-md" src="<?php echo esc_url($image_url); ?>" alt="Profile Picture">
                    <div class="mt-4">
                        <p class="mt-2 text-gray-600"><?php echo esc_html($pledge->pledgeText); ?></p>
                    </div>
                </div>
            </div>
            <?php
                        } else {
                            // Subsequent iterations with regular structure
            ?>
            <div class="w-full">
                <div class="bg-white p-3 border-2 border-red-600 rounded-md shadow-md h-[320px]">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-red-600 font-bold"><?php echo esc_html($pledge->userName); ?></h2>
                        <img class="w-8 h-auto" src="<?php echo esc_url($image_url); ?>" alt="Profile Picture">
                    </div>
                    <img class="w-full h-auto object-cover rounded-md" src="<?php echo esc_url($image_url); ?>" alt="Profile Picture">
                    <div class="mt-4">
                        <p class="mt-2 text-gray-600"><?php echo esc_html($pledge->pledgeText); ?></p>
                    </div>
                </div>
            </div>
            <?php 
                        }
                    }
                } else {
                    echo '<p class="col-span-5 text-center text-gray-600">No pledges found.</p>';
                }
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
