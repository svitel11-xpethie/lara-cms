<section id="services" class="py-16 bg-gray-200">
    <div class="container mx-auto text-center">
        <div class="section-title w-full text-center my-8">
            <h2 class="text-2xl md:text-3xl fancy-underline mb-2">Our <span class="font-light">Services</span></h2>
            <p class="font-light">We offer a wide range of towing and roadside assistance services to help you in any situation.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
                <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center">
                    <img src="{{ $service['image_thumb'] }}" alt="{{ $service['title'] }}" class="h-16 mb-4">
                    <h3 class="text-xl font-bold mb-2">{{ $service['title'] }}</h3>
                    <p class="text-gray-700 text-sm">{{ $service['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
