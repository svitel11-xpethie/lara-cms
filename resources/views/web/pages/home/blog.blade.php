@php
    $blogs = [
        [
            'title' => 'Understanding Car Recovery Services',
            'excerpt' => 'Learn the ins and outs of car recovery services and how they can help in emergencies.',
            'image' => '/assets/images/blogs/thumb/image1.jpg',
            'date' => 'November 1, 2024',
            'link' => '/blogs/understanding-car-recovery-services',
        ],
        [
            'title' => 'Top Tips for Roadside Assistance',
            'excerpt' => 'Discover essential tips to ensure your safety during roadside emergencies.',
            'image' => '/assets/images/blogs/thumb/image2.jpg',
            'date' => 'October 20, 2024',
            'link' => '/blogs/top-tips-roadside-assistance',
        ],
        [
            'title' => 'When to Call for Emergency Towing',
            'excerpt' => 'Know the signs when emergency towing is your best option.',
            'image' => '/assets/images/blogs/thumb/image3.jpg',
            'date' => 'October 15, 2024',
            'link' => '/blogs/when-to-call-emergency-towing',
        ],
    ];
@endphp

<section id="latest-blogs" class="py-16 bg-web-primary bg-opacity-50">
    <div class="container mx-auto text-center">
        <div class="section-title w-full text-center my-8">
            <h2 class="text-2xl md:text-3xl fancy-underline mb-2">Latest <span class="font-light">Blogs</span></h2>
            <p class="font-light">Stay updated with the latest insights and tips.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($blogs as $blog)
                <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center text-left">
                    <img src="{{ $blog['image'] }}" alt="{{ $blog['title'] }}" class="rounded h-40 w-full object-cover mb-4">
                    <h3 class="text-xl font-bold mb-2">{{ $blog['title'] }}</h3>
                    <p class="text-gray-700 text-sm mb-4">{{ $blog['excerpt'] }}</p>
                    <a href="{{ $blog['link'] }}" class="text-web-secondary font-bold hover:underline">Read More</a>
                    <p class="text-xs text-gray-500 mt-2">{{ $blog['date'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
