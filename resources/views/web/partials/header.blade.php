<header class="border-b bg-web-primary text-white sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex md:hidden items-center justify-between py-4">
            <img src="/assets/images/1stcarrecovery-logo.png" alt="Logo" class="h-[40px] w-auto mr-3">

            <!-- Phone Icon and Number -->
            {{--<div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                </svg>

                <a href="tel:+1234567890" class="text-white text-xl font-bold hover:text-web-secondary">
                    +1 234 567 890
                </a>
            </div>--}}

            <!-- Mobile Menu Toggle -->
            <button class="block md:hidden focus:outline-none" id="menu-toggle">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="size-10 text-web-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>


        <!-- Navigation with Centered Logo -->
        <nav class="hidden md:flex items-center justify-center relative h-[120px]">
            <!-- Left Menu -->
            <ul class="flex space-x-6">
                <li class="relative group">
                    <div class="flex items-center cursor-pointer hover:text-web-secondary transition-colors">
                        <a href="index.html" class="hover:text-web-secondary font-bold">HOME</a>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor"
                             class="size-4 ml-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </div>

                    <ul class="absolute hidden min-w-[150px] group-hover:flex flex-col pt-[60px] text-web-primary font-bold z-10 space-y-2 p-2 rounded shadow-lg left-0 transition-all duration-300 opacity-0 transform scale-y-95 group-hover:opacity-100 group-hover:scale-y-100">
                        <li><a href="index.html" class="block px-4 py-1 w-full hover:text-web-secondary">MultiPage</a>
                        </li>
                        <li><a href="index_singlepage.html" class="block px-4 py-1 w-full hover:text-web-secondary">Single
                                Page</a></li>
                    </ul>
                </li>
                <li class="relative group">
                    <div class="flex items-center cursor-pointer hover:text-web-secondary transition-colors">
                        <a href="index.html" class="hover:text-web-secondary font-bold">PAGES</a>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor"
                             class="size-4 ml-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </div>
                    <ul class="absolute hidden min-w-[150px] group-hover:flex flex-col pt-[60px] text-web-primary font-bold z-10 space-y-2 p-2 rounded shadow-lg left-0 transition-all duration-300 opacity-0 transform scale-y-95 group-hover:opacity-100 group-hover:scale-y-100">
                        <li><a href="about.html" class="block px-4 py-2 hover:text-web-secondary">About</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Centered Logo -->
            <a href="./" class="flex items-center mx-8">
                <img src="/assets/images/1stcarrecovery-logo.png" alt="Logo" class="h-[60px] w-auto mr-3">
            </a>

            <!-- Right Menu -->
            <ul class="flex space-x-6">
                <li class="relative group">
                    <div class="flex items-center cursor-pointer hover:text-web-secondary transition-colors">
                        <a href="index.html" class="hover:text-web-secondary font-bold">SERVICES</a>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor"
                             class="size-4 ml-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </div>
                    <ul class="absolute hidden min-w-[150px] group-hover:flex flex-col pt-[60px] text-web-primary font-bold z-10 space-y-2 p-2 rounded shadow-lg left-0 transition-all duration-300 opacity-0 transform scale-y-95 group-hover:opacity-100 group-hover:scale-y-100">
                        <li><a href="services.html" class="block px-4 py-2 hover:text-web-secondary">All Services</a>
                        </li>
                        <li><a href="service-single.html" class="block px-4 py-2 hover:text-web-secondary">Single
                                Service</a></li>
                    </ul>
                </li>
                <li><a href="contact.html" class="hover:text-web-secondary font-bold">CONTACT</a></li>
            </ul>
        </nav>
    </div>

    <!-- Mobile Menu -->
    <div class="hidden md:hidden bg-web-primary text-white" id="mobile-menu">
        <nav class="flex flex-col space-y-2 p-4">
            <a href="index.html" class="block px-4 py-2 hover:text-web-secondary">Home</a>
            <a href="about.html" class="block px-4 py-2 hover:text-web-secondary">Pages</a>
            <a href="services.html" class="block px-4 py-2 hover:text-web-secondary">Services</a>
            <a href="contact.html" class="block px-4 py-2 hover:text-web-secondary">Contact</a>
        </nav>
    </div>
</header>

<script>
    document.getElementById('menu-toggle').addEventListener('click', function () {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    /*window.addEventListener('scroll', function () {
        const header = document.querySelector('header');
        const initialOpacity = 0.5; // Starting opacity when the page loads
        const maxOpacity = 1; // Maximum opacity when scrolling
        const scrollFactor = 200; // Controls how quickly the opacity reaches max

        const opacity = Math.min(maxOpacity, initialOpacity + window.scrollY / scrollFactor);
        header.style.backgroundColor = `rgba(35, 33, 31, ${opacity})`; // RGB equivalent of web-primary
    });*/

    // Set initial opacity when page loads
    /*document.addEventListener('DOMContentLoaded', function () {
        const header = document.querySelector('header');
        header.style.backgroundColor = `rgba(35, 33, 31, 0.5)`; // Initial opacity set to 0.5
    });*/
</script>
