<?php

// Template Name: form
get_header();

?>

<div class="my-20 px-4 xl:px-0">
   <div class="bg-white p-4 md:p-8 max-w-[600px] mx-auto border rounded-md">
        <div class="event_form mb-4">
            <img src="<?php the_field('pw_event_banner'); ?>" alt="event banner">
        </div>
        <form id="pledgeForm" role="form" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="name">Name</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="userName" type="text" placeholder="Your Name" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="pledge">Make Your message!</label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="pledge" name="pledgeText" placeholder="Your Message" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="image">Upload your Picture (optional)</label>
                <input class="shadow cursor-pointer inline-flex max-w-[230px] appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" name="pledgeImage" type="file" accept=".jpg, .jpeg, .png, .webp">
                <span id="fileMessage" class="text-red-500 mt-2"></span>
            </div>
            <div class="">
                <button type="submit" name="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
            </div>
        </form>
    </div>
</div>


<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const fileMessage = document.getElementById('fileMessage');

        if (file) {
            const fileType = file.type;
            const validTypes = ['image/jpeg', 'image/png', 'image/webp'];

            if (validTypes.includes(fileType)) {
                fileMessage.textContent = 'File accepted: ' + file.name;
                fileMessage.classList.remove('text-red-500');
                fileMessage.classList.add('text-green-500');
            } else {
                fileMessage.textContent = 'Invalid file type. Please upload an image file (jpg, png, webp).';
                fileMessage.classList.remove('text-green-500');
                fileMessage.classList.add('text-red-500');
                event.target.value = '';
            }
        } else {
            fileMessage.textContent = '';
        }
    });
</script>

<?php get_footer(); ?>
