<!-- Hero Section -->
<section class="bg-cover bg-center hero-height relative" style="background-image: url('/assets/images/your-hero-bg.webp');">
    <div class="container mx-auto hero-height flex items-center text-white xs:pb-40">
        <div class="hero-content opacity-0 translate-y-10 transition-all duration-1000 ease-out">
            <h1 class="text-4xl md:text-6xl p-2 font-bold bg-web-secondary text-web-primary inline-block">
                Always Ready When You Need Us
            </h1>
            <p class="text-lg md:text-4xl xs:text-2xl p-2 mt-4 text-web-secondary font-bold">Fast and Reliable Towing & Roadside Assistance</p>
            <p class="mt-4 text-xl xs:text-sm text-web-secondary bg-web-primary p-2 bg-opacity-50 xs:mb-20">
                Whether it’s an accident or a breakdown, we’re here for you 24/7.
                With modern equipment and an experienced team, we’ll get you back on track.
                <br>
                <span class="font-bold text-white fancy-underline">Call now for immediate assistance!</span>
            </p>

            <!-- Buttons Section -->
            <div class="mt-8 flex space-x-4 xs:hidden">
                <!-- Call Now Button -->
                <a href="tel:+123456789"
                   class="bg-web-secondary flex items-center hover:bg-web-primary text-web-primary hover:text-web-secondary font-bold py-3 px-8 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
                    Call Now
                </a>

                <!-- Ask for a Quote Button -->
                <a href="#quote-form"
                   class="bg-web-primary flex items-center border-2 border-web-secondary text-web-secondary hover:bg-web-secondary hover:text-web-primary font-bold py-3 px-8 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
                    Ask for a Quote
                </a>
            </div>
        </div>
        <!-- Mobile Buttons Section -->
        <div class="mt-8 flex flex-col sm:hidden -mx-2 absolute bottom-0 right-0 left-0">
            <!-- Call Now Button -->
            <div
                class="bg-web-secondary flex flex-col h-24 flex items-center justify-center text-web-primary font-bold py-3 px-8 transition-all duration-300 transform">

                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                    </svg>

                    <a href="tel:+1234567890" class="text-2xl font-bold">+1 234 567 890</a>
                </div>
                <span class="text-xs">Tap to Call</span>
            </div>

            <!-- Ask for a Quote Button -->
            <a href="#quote-form"
               class="bg-web-primary h-24 flex items-center text-2xl justify-center text-web-secondary font-bold py-3 px-8 transition-all duration-300 transform">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                </svg>

                Ask for a Quote
            </a>
        </div>
    </div>
</section>

<script>
    // Wait for the DOM to load
    document.addEventListener("DOMContentLoaded", function () {
        const heroContent = document.querySelector('.hero-content');
        if (heroContent) {
            heroContent.classList.add('opacity-100', 'translate-y-0');
        }
    });
</script>
