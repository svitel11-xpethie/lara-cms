<footer class="bg-web-primary text-white py-16">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Logo and Company Info -->
            <div>
                <img src="/assets/images/1stcarrecovery-logo.png" alt="Company Logo" class="h-16 mb-4">
                <p class="text-sm">
                    <strong>1st Car Recovery</strong><br>
                    123 Recovery Street, Suite 100<br>
                    Vienna, Austria<br>
                    Phone: +43 123 456 789<br>
                    Email: info@1stcarrecovery.com
                </p>
            </div>

            <!-- Menu Links -->
            <div>
                <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="/" class="hover:underline">Home</a></li>
                    <li><a href="#services" class="hover:underline">Services</a></li>
                    <li><a href="#about" class="hover:underline">About Us</a></li>
                    <li><a href="#contact" class="hover:underline">Contact</a></li>
                </ul>
            </div>

            <!-- Privacy and Legal Links -->
            <div>
                <h3 class="text-lg font-bold mb-4">Legal</h3>
                <ul class="space-y-2">
                    <li><a href="/privacy-policy" class="hover:underline">Privacy Policy</a></li>
                    <li><a href="/cookie-policy" class="hover:underline">Cookie Policy</a></li>
                    <li><a href="/terms-and-conditions" class="hover:underline">Terms & Conditions</a></li>
                </ul>
            </div>
        </div>

        <hr class="my-8 border-gray-700">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
            <!-- Social Media Links -->
            <div>
                <h3 class="text-lg font-bold mb-4">Follow Us</h3>
                <div class="flex space-x-4">
                    <a href="https://facebook.com" target="_blank" class="hover:opacity-75">
                        <img src="/assets/icons/icons8-facebook.svg" alt="Facebook" class="h-16">
                    </a>
                    <a href="https://youtube.com" target="_blank" class="hover:opacity-75">
                        <img src="/assets/icons/icons8-youtube.svg" alt="Twitter" class="h-16">
                    </a>
                    <a href="https://instagram.com" target="_blank" class="hover:opacity-75">
                        <img src="/assets/icons/icons8-instagram.svg" alt="Instagram" class="h-16">
                    </a>
                    <a href="https://linkedin.com" target="_blank" class="hover:opacity-75">
                        <img src="/assets/icons/icons8-linkedin.svg" alt="LinkedIn" class="h-16">
                    </a>
                </div>
            </div>

            <!-- Instagram Feed -->
            <div>
                <h3 class="text-lg font-bold mb-4">Instagram Feed</h3>
                <div class="container mx-auto text-center">
                    <h3 class="text-lg font-bold mb-4">Instagram Feed</h3>
                    <iframe
                        src="https://lightwidget.com/widgets/YOUR_WIDGET_ID.html"
                        style="width:100%; border:0; overflow:hidden;"
                        scrolling="no"
                        allowtransparency="true"
                        class="h-96">
                    </iframe>
                </div>
            </div>

            <!-- Newsletter Signup -->
            <div>
                <h3 class="text-lg font-bold mb-4">Subscribe to Our Newsletter</h3>
                <form action="#" method="POST" class="flex flex-col space-y-4">
                    <input type="email" name="email" placeholder="Your email" class="p-2 rounded text-black">
                    <button type="submit" class="bg-web-secondary text-web-primary font-bold py-2 rounded hover:bg-web-fifth">Subscribe</button>
                </form>
            </div>
        </div>

        <div class="text-center text-sm mt-8">
            <p>&copy; {{ date('Y') }} 1st Car Recovery. All rights reserved.</p>
        </div>
    </div>
</footer>
