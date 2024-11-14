@php
    $faqs = [
        [
            'question' => 'What is the response time for your roadside assistance?',
            'answer' => 'Our average response time is 30 minutes, depending on your location and traffic conditions.'
        ],
        [
            'question' => 'Do you offer long-distance towing?',
            'answer' => 'Yes, we provide long-distance towing services across the country to ensure your vehicle reaches its destination safely.'
        ],
        [
            'question' => 'Are your services available 24/7?',
            'answer' => 'Yes, we operate 24/7 to assist you anytime, anywhere.'
        ],
        [
            'question' => 'What types of vehicles do you tow?',
            'answer' => 'We tow all types of vehicles, including cars, motorcycles, vans, and light trucks.'
        ],
        [
            'question' => 'How can I pay for the services?',
            'answer' => 'We accept cash, credit cards, and other digital payment methods for your convenience.'
        ],
    ];
@endphp

<section id="faq" class="py-16 bg-gray-200">
    <div class="container mx-auto">
        <div class="section-title w-full text-center my-8">
            <h2 class="text-2xl md:text-3xl fancy-underline mb-2">Frequently Asked <span class="font-light">Questions</span></h2>
            <p class="font-light">Find answers to the most commonly asked questions about our services.</p>
        </div>

        <div class="flex flex-col gap-4">
            @foreach($faqs as $faq)
                @if ($loop->last)
                    <div class="py-2">
                        <h3 class="text-lg font-bold mb-2">{{ $faq['question'] }}</h3>
                        <p class="text-gray-700 text-sm">{{ $faq['answer'] }}</p>
                    </div>
                @else
                    <div class="py-2 border-white border-b-2">
                        <h3 class="text-lg font-bold mb-2">{{ $faq['question'] }}</h3>
                        <p class="text-gray-700 text-sm">{{ $faq['answer'] }}</p>
                    </div>
                @endif

            @endforeach
        </div>
    </div>
</section>
