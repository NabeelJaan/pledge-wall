<?php

// Template Name: form
get_header();

?>

<div class="my-20">
   <div class="bg-white p-8 max-w-[600px] mx-auto border rounded-md">
        <div class="event_form bg-no-repeat bg-cover min-h-[120px] mb-4" style="background-image: url('<?php the_field('pw_event_banner'); ?>');">

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
                <label class="block text-gray-700 font-bold mb-2" for="image">Upload your Picture (optional)</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" name="pledgeImage" type="file">
            </div>
            <div class="flex items-center justify-center">
                <button type="submit" name="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
            </div>
        </form>
    </div>
</div>

<?php get_footer(); ?>
