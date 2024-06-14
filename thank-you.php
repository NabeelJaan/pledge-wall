<?php
    // Template Name: Thank you
?>

<?php get_header(); ?>

   <div class="bg-white p-8 rounded-md border my-10 w-full max-w-md mx-auto text-center">
        <div class="mb-6">
            <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4"></path>
            </svg>
        </div>
        <h1 class="text-2xl font-bold mb-4">THANK YOU!</h1>
        <p class="mb-6">Your pledge has been submitted successfully.</p>
        <button onclick="location.href='pledgewall.html'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Go to the pledge wall</button>
   </div>

<?php get_footer(); ?>