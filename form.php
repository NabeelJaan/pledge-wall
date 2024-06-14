<?php
    // Template Name: form
?>

<?php get_header(); ?>

<div class="my-20">
   <div class="bg-white p-8 max-w-[600px] mx-auto border rounded-md">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold">Event Banner</h1>
        </div>
        <form id="pledgeForm">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="picture">Upload your Picture</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="picture" type="file" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="name">Name</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Your Name" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="pledge">Make Your Pledge!</label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="pledge" placeholder="Your Pledge" required></textarea>
            </div>
            <div class="flex items-center justify-center">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>

<??>



<script>
   jQuery(document).ready(function($) {
      $('#pledgeForm').on('submit', function(e) {
         e.preventDefault();

         var formData = new FormData(this);
         
         $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                  if (response.success) {
                     window.location.href = response.data.redirect_url;
                  } else {
                     alert('There was an error. Please try again.');
                  }
            }
         });
      });
   });
</script>

<?php get_footer(); ?>