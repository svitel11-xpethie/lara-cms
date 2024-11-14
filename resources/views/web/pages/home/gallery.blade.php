<section id="gallery" class="py-16 bg-gray-100">
    <div class="section-title w-full text-center my-8">
        <h2 class="text-2xl md:text-3xl fancy-underline mb-2">Our <span class="font-light">Gallery</span></h2>
        <p class="font-light">We are proud of our achievements and the services we provide to our customers.</p>
    </div>

    <div class="container mx-auto text-center">
        <div id="vue-app">
            <gallery-component :images="@json($gallery_images)"></gallery-component>
        </div>
    </div>

</section>
