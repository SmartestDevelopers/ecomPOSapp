{{-- Footer --}}


<footer class="footer py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>About ECommerce Store</h5>
                <p>Your one-stop shop for all your shopping needs. Offering a wide range of products including electronics, fashion, home decor, and more at unbeatable prices. Fast shipping and excellent customer service guaranteed!</p>
            </div>
            <div class="col-md-3">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="text-light">Home</a></li>
                    <li><a href="{{ url('/about') }}" class="text-light">About Us</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-light">Contact Us</a></li>
                    <li><a href="{{ url('/categories') }}" class="text-light">Categories</a></li>
                    <li><a href="{{ url('/products') }}" class="text-light">Products</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Follow Us</h5>
                <div class="d-flex">
                    <a href="#" class="text-light me-3"><i class="fab fa-facebook fa-2x"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-twitter fa-2x"></i></a>
                    <a href="#" class="text-light"><i class="fab fa-instagram fa-2x"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>
