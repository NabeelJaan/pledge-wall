<?php
    // Template Name: Pledge Wall
    get_header();

    global $wpdb;
    $table_name = $wpdb->prefix . 'pledge_wall';
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");
?>

    <!-- Pledge Head -->
    <div class="pledge_wall px-4 text-white pb-3 pt-[200px] lg:pt-[250px] lg:pb-3 xl:px-0 bg-cover bg-no-repeat object"
        style="background-image: url('<?php the_field('pw_bpckground_image'); ?>');">
        <div class="max-w-[1280px] mx-auto">
            <div class="flex flex-col-reverse gap-6 md:flex-row md:items-center">
                <div class="relative w-ful md:w-[40%] z-30" id="featuredPledge">
                    <?php if (!empty($results)): ?>
                        <?php $latestPledge = $results[0]; ?>
                        <?php $image_url = wp_get_attachment_url($latestPledge->pledgeImage); ?>
                            <div class="bg-white relative overflow-hidden min-h-[150px] md:min-h-[350px] lg:min-h-[425px] p-3 border-2 border-red-600 rounded-md shadow-md">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-red-600 font-bold" id="featuredUserName"><?php echo esc_html($latestPledge->userName); ?></h2>
                                </div>
                                <?php if (!empty($image_url)): ?>
                                    <img class="w-full mb-4" id="featuredPledgeImage" src="<?php echo esc_url($image_url); ?>" alt="Pledge Image">
                                    <p id="featurenoimg"></p>
                                <?php else: ?>
                                        <img class="w-full mb-4" id="featuredPledgeImage" src="" alt="Pledge Image">
                                        <p id="featurenoimg"></p>
                                <?php endif; ?>
                                <p id="featuredPledgeText" class="text-black"><?php echo esc_html($latestPledge->pledgeText); ?></p>
                            </div>
                    <?php endif; ?>
                </div>
                <!-- PLedge text -->
                <div class="w-full md:w-[60%] relative z-40 md:mb-[-66px]">
                    <h1 class="text-3xl font-bold">
                        <?php the_field('pw_heading'); ?>
                    </h1>
                    <p class="mt-2 text-xl">
                        <?php the_field('pw_description'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Pledge -->
    <div class="max-w-[1280px] mx-auto mt-4 pb-10 px-4 xl:px-0">
        <div class="relative">
            <div class="grid col-span-1 md:grid-cols-3 lg:grid-cols-5 lg:px-0 gap-3 pledgeWall">
                <?php foreach ($results as  $pledge): ?>
                        <?php $image_url = wp_get_attachment_url($pledge->pledgeImage); ?>
                        <div class="bg-white min-h-[250px] p-3 border-2 border-red-600 rounded-md shadow-md pledgeItem" data-id="<?php echo $pledge->id; ?>">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-red-600 font-bold"><?php echo esc_html($pledge->userName); ?></h2>
                            </div>
                            <?php if (!empty($image_url)): ?>
                                <img class="w-full object-cover mb-2" src="<?php echo esc_url($image_url); ?>" alt="Pledge Image">
                            <?php endif; ?>
                            <p class="pledge-text"><?php echo esc_html($pledge->pledgeText); ?></p>
                        </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="more__btn mt-12 text-center">
            <a href="/pledge-wall/" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Go to Submission Form
            </a>
        </div>
    </div>



<script>
function updateFeaturedPledge() {
        const pledgeItems = document.querySelectorAll('.pledgeItem');
        const randomIndex = Math.floor(Math.random() * pledgeItems.length);
        const randomPledge = pledgeItems[randomIndex];

        const userName = randomPledge.querySelector('h2').innerText;
        const pledgeText = randomPledge.querySelector('.pledge-text').innerText;
        const pledgeImage = randomPledge.querySelector('img');

        document.getElementById('featuredUserName').innerText = userName;
        document.getElementById('featuredPledgeText').innerText = pledgeText;

        if (pledgeImage) {
            document.getElementById('featuredPledgeImage').src = pledgeImage.src;
            document.getElementById('featuredPledgeImage').alt = pledgeImage.alt;
            document.getElementById('featuredPledgeImage').style.display = 'block';
			document.getElementById('featurenoimg').style.display = 'none';
        } else {
			document.getElementById('featuredPledgeImage').style.display = 'none';
        }
    }

    // Initial update of the featured pledge
    updateFeaturedPledge();

    // Update the featured pledge every 7 seconds
    setInterval(updateFeaturedPledge, 7000);


</script>

<?php get_footer(); ?>