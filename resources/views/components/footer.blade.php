<footer class="bg-navy text-inverse">
    <div class="container ">
        <div class="row">
            <div class="col-12 py-8 text-center">
                <div class="widget lh-1">
                    <h4 class="widget-title text-white mb-3">About</h4>
                    <small class="">info@nujanas.com</small>
                </div>
            </div>
            <div class="col-12 py-2 text-center">
                <div class="widget">
                    <p class="mb-0">© 2022 {{config('app.name')}}. All rights reserved</p>
                    <nav class="nav justify-content-center social social-white" style="">
                        <a href="{{route('terms')}}">Terms of Services</a>
                        <a href="{{route('privacy.policy')}}">Privacy Policy</a>
                        <a href="{{route('contact.us')}}">Contact Us</a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</footer>
