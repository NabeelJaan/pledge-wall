<?php
    // Template Name: Pledge Wall
?>

<?php get_header(); ?>



<main>
    <!-- pledge Head -->
    <div class="bg-red-600 text-white py-48">
        <div class="">
            <h1 class="text-3xl font-bold">Apex Pledge Wall</h1>
            <p class="mt-2 text-xl">What's your pledge to live a healthier, longer, better life?</p>
        </div>
    </div>
    <!-- Pledge -->
    <div class="container mx-auto mt-8">
        <div class="flex flex-wrap">
            <div class="w-full lg:w-1/3 p-4">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="mt-4 flex justify-between items-center mb-4">
                        <h2 class="text-red-600 font-bold">Full Name</h2>
                        <img class="w-8 h-auto" src="/wp-content/uploads/2024/06/womenjpg.jpg" alt="Country Flag">
                    </div>

                    <img class="w-full h-48 object-cover rounded-t-lg" src="/wp-content/uploads/2024/06/womenjpg.jpg" alt="Profile Picture">
                    
                    <div class="mt-4">
                        <p class="mt-2 text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed volutpat, erat et pulvinar interdum, lacus enim vehicula erat, in rutrum turpis justo non ex. Etiam vehicula est ante id bibendum.</p>
                    </div>
                </div>
            </div>
            <!-- Repeat the above block for each pledge card -->
        </div>
    </div>
</main>


<?php get_footer(); ?>