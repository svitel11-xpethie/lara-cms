<section id="latest-blogs" class="py-16 bg-web-primary bg-opacity-50">
    <div class="container mx-auto text-center">
        <div class="section-title w-full text-center my-8">
            <h2 class="text-2xl md:text-3xl fancy-underline mb-2">Latest <span class="font-light">Blogs</span></h2>
            <p class="font-light">Stay updated with the latest insights and tips.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($blog_posts as $blog)
                <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center text-left">
                    <img src="{{ $blog['image_thumb'] }}" alt="{{ $blog['title'] }}" class="rounded h-40 w-full object-cover mb-4">
                    <h3 class="text-xl font-bold mb-2">{{ $blog['title'] }}</h3>
                    <p class="text-gray-700 text-sm mb-4">{{ $blog['description'] }}</p>
                    <a href="{{ route('blogs.blog', [$blog['id'], $blog['slug']]) }}" class="text-web-secondary font-bold hover:underline">Read More</a>
                    <p class="text-xs text-gray-500 mt-2">{{ $blog['created_at'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
