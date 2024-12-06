
<!-- FOOTER COMPONENT -->
<footer class="bg-dark text-light py-4">
    <div class="container">
        <div class="row text-start">
            <!-- Newsletter Form -->
            <div class="col-md-3 me-4" id="newsletter">
                <h4>Subscribe to Our Newsletter</h4>
                <form action="#" method="post" name="submit-to-google-sheet">
                    <div class="input-group">
                        <input type="email" name="Emails" class="form-control form-control-sm" placeholder="Your Email" aria-label="Your Email" aria-describedby="subscribeBtn">
                        <button class="btn btn-primary btn-sm" type="submit" id="subscribeBtn">Subscribe</button>
                    </div>
                </form>
                <span class="bg-dark" id="msg2"></span>
            </div>

            <!-- About Information -->
            <div class="col-6 col-md-3 ms-4">
                <h4>About</h4>
                <ul class="list-unstyled" id="list-items">
                    <li><a href="#" class="text-light">About Us</a></li>
                    <li><a href="#" class="text-light">Delivery Information</a></li>
                    <li><a href="#" class="text-light">Privacy Policy</a></li>
                    <li><a href="#" class="text-light">Terms & Condition</a></li>
                    <li><a href="#" class="text-light">Contact Us</a></li>
                </ul>
            </div>

            <!-- Contact Information -->
            <div class="col-6 col-md-3 mb-4">
                <h4>My Account</h4>
                <ul class="list-unstyled" id="list-items">
                    <li><a href="#" class="text-light">Sign In</a></li>
                    <li><a href="#" class="text-light">View Cart</a></li>
                    <li><a href="#" class="text-light">My Wishlist</a></li>
                    <li><a href="#" class="text-light">Track My Order</a></li>
                    <li><a href="#" class="text-light">Help</a></li>
                </ul>
            </div>

            <!-- Follow Us -->
            <div class="col-6 col-md-2">
                <h4>Follow Us</h4>
                <ul class="list-unstyled" id="list-items">
                    <li><a href="#" class="text-light"><i class="bi bi-facebook"></i> Facebook</a></li>
                    <li><a href="#" class="text-light"><i class="bi bi-instagram"></i> Instagram</a></li>
                    <li><a href="#" class="text-light"><i class="bi bi-linkedin"></i> LinkedIn</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="text-center mt-3">
        <!-- JavaScript to update the year -->
        <script>
            document.write("&copy; " + new Date().getFullYear() + " Sneakers. All rights reserved.");
        </script>
    </div>
</footer>
