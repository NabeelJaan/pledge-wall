<?php
    // Template Name: Thank you
?>

<?php get_header(); ?>

<div class="px-4 xl:px-0">
    <div class="bg-white p-8 rounded-md border my-10 w-full max-w-md mx-auto text-center">
        <div class="mb-6">
            <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4"></path>
            </svg>
        </div>
        <h1 class="text-2xl font-bold mb-4">THANK YOU!</h1>
        <p class="mb-6">Your message has been submitted successfully.</p>
        <p class="mb-6">You will be redirected to our Message Wall!</p>
        <!-- <a href="/pledge-wall/" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Go to the Message wall</a> -->
   </div>
</div>

<script>	
	jQuery(document).ready(function($) {
		if (localStorage.getItem('redirectToPledgeWall') === 'true') {
			// Clear the flag
			localStorage.removeItem('redirectToPledgeWall');
			// Redirect to /pledge-wall/ after 2 seconds
			setTimeout(function() {
				window.location.href = '/pledge-wall/';
			}, 4000);
		}
	});
</script>

<?php get_footer(); ?>