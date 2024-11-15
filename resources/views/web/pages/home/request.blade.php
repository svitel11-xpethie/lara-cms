<section id="quote-form" class="py-12 bg-gray-200">
    <div class="container mx-auto flex flex-col md:flex-row items-start gap-8">
        <!-- Form Section -->
        <div class="w-full">
            <div class="section-title w-full text-center my-8">
                <h2 class="text-2xl md:text-3xl fancy-underline mb-2">Request <span class="font-light">a Quote</span></h2>
                <p class="font-light">Fill out the form below to request a quote for our services. We will get back to you as soon as possible.</p>
            </div>

            <div class="flex sm:space-x-16 xs:space-y-16 xs:flex-wrap w-full">
                <form action="/submit-quote" method="POST" enctype="multipart/form-data" class="w-full md:w-1/2 bg-white shadow-lg rounded-lg p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-gray-700 font-bold text-sm">Name</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full p-2 border border-gray-300 rounded">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-gray-700 font-bold text-sm">Phone</label>
                            <input type="tel" id="phone" name="phone" required
                                   class="w-full p-2 border border-gray-300 rounded">
                        </div>

                        <div class="flex md:col-span-2 gap-4 xs:gap-1">
                            <div class="w-1/2">
                                <label for="car-brand" class="block text-gray-700 font-bold text-sm">Car Brand</label>
                                <input type="text" id="car-brand" name="car_brand" required
                                       class="w-full p-2 border border-gray-300 rounded">
                            </div>

                            <div class="w-1/2">
                                <label for="car-type" class="block text-gray-700 font-bold text-sm">Car Type</label>
                                <input type="text" id="car-type" name="car_type" required
                                       class="w-full p-2 border border-gray-300 rounded">
                            </div>
                        </div>

                        <!-- Recovery From Address -->
                        <div>
                            <label for="recovery-from" class="block text-gray-700 font-bold text-sm">Recovery From Address</label>
                            <input type="text" id="recovery-from" name="recovery_from" required
                                   class="w-full p-2 border border-gray-300 rounded">
                        </div>

                        <!-- Recovery To Address -->
                        <div>
                            <label for="recovery-to" class="block text-gray-700 font-bold text-sm">Recovery To Address</label>
                            <input type="text" id="recovery-to" name="recovery_to" required
                                   class="w-full p-2 border border-gray-300 rounded">
                        </div>

                        <!-- Upload Images -->
                        <div class="md:col-span-2">
                            <label for="images" class="block text-gray-700 font-bold text-sm">Upload Images</label>
                            <input type="file" id="images" name="images[]" multiple
                                   class="w-full p-2 border border-gray-300 rounded">
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-gray-700 font-bold text-sm">Description</label>
                            <textarea id="description" name="description" rows="3" required
                                      class="w-full p-2 border border-gray-300 rounded"></textarea>
                        </div>

                        <!-- Preferred Date -->
                        <div class="flex w-full">
                            <div class="w-full">
                                <label for="preferred-date" class="block text-gray-700 font-bold text-sm">Preferred Date</label>
                                <input type="date" id="preferred-date" name="preferred_date" required
                                       class="w-full p-2 border border-gray-300 rounded">
                            </div>
                            <div class="ml-0.5">
                                <label for="preferred-hour" class="block text-gray-700 font-bold text-sm">Hour</label>
                                <input type="time" id="preferred-hour" name="preferred_hour" required
                                       class="w-full p-2 border border-gray-300 rounded">
                            </div>

                        </div>

                        <!-- Car Problems -->
                        <div>
                            <label for="car-problems" class="block text-gray-700 font-bold text-sm">Car Problems</label>
                            <select id="car-problems" name="car_problems" required
                                    class="w-full p-2 border border-gray-300 rounded">
                                <option value="flat-tire">Flat Tire</option>
                                <option value="engine-trouble">Engine Trouble</option>
                                <option value="battery-dead">Battery Dead</option>
                                <option value="accident">Accident</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- KM Calculate -->
                        {{--<div>
                            <label for="km-calculate" class="block text-gray-700 font-bold text-sm">Estimated Distance (KM)</label>
                            <input type="number" id="km-calculate" name="km_calculate" min="0" step="0.1" required
                                   class="w-full p-2 border border-gray-300 rounded">
                        </div>--}}
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6 xs:w-full">
                        <button type="submit" class="bg-web-secondary text-white font-bold py-2 px-6 rounded shadow-lg hover:bg-web-primary transition duration-300">
                            Submit Request
                        </button>
                    </div>
                </form>
                <!-- Advertising Banner Section -->
                <div class="w-full md:w-1/2 bg-web-primary text-white shadow-lg rounded-lg p-6 flex flex-col items-center justify-center text-center">
                    <img src="/assets/icons/10-percent.svg" alt="10% Discount" class="mb-4 rounded h-[140px]">
                    <img src="/assets/images/1st-car-recovery-road.png" alt="10% Discount" class="mb-4 -mt-[80px] rounded">
                    <h3 class="text-2xl font-bold mb-2 fancy-underline">Online Order Discount</h3>
                    <p class="text-lg text-web-secondary">Place your order online and get a <span class="font-bold">10% discount</span> on our services.</p>
                </div>
            </div>
        </div>

    </div>
</section>
