<header class="header header-4">
    <div class="top-bar bg-success py-1 header-text-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <div class="top-meta gap-5 d-flex align-items-center justify-content-between">
                            <div>
                                <a href="mailto:info@oncas.lk"> <i class="feather-icon icon-send me-2"></i>
                                    info@oncas.lk</a>
                            </div>
                            <div>
                                <a href="tel:+94713114480"><i class="feather-icon icon-phone me-2"></i> 071 311 4480</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Navigation Menu Start -->
    <div class="offcanvas offcanvas-top" id="offcanvas-search" data-bs-scroll="true">
        <div class="container d-flex flex-row py-5 align-items-center">
            <form class="search-form w-100">
                <input id="search-form" type="text" class="form-control" placeholder="Type keyword and hit enter">
            </form>
            <button type="button" class="btn-close icon-xs" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container px-lg-0">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div>
                    <a class='navbar-brand' href='{{ url('/') }}'><img src="{{ asset('assets/common/images/logo.png') }}" alt="Oncas"></a>
                </div>
                <div>
                    <button class="navbar-toggler offcanvas-nav-btn" type="button">
                        <span class="feather-icon icon-menu"></span>
                    </button>
                </div>
            </div>
            <div class="nav-cta order-lg-3">
                <div class="d-flex align-items-center justify-content-between">
                    <a class='btn btn-gr ms-4 d-sm-block d-none' href='{{ url('/join-academy') }}'>Join Academy</a>
                </div>
            </div>
            <div class="offcanvas bg-dark offcanvas-start offcanvas-nav">
                <div class="offcanvas-header">
                    <a class='text-inverse' href='{{ url('/') }}'><img src="{{ asset('assets/common/images/logo.png') }}" alt="Oncas"></a>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body pt-0 align-items-center">
                    <ul class="navbar-nav mx-auto align-items-lg-center">
                        <li class="nav-item">
                            <a class='nav-link' href='{{ url('/') }}'>Home</a>
                        </li>
                        <li class="nav-item">
                            <a class='nav-link' href='{{ url('/contact') }}'>Contact</a>
                        </li>
                        @auth()
                            <li class="nav-item">
                                <a class='nav-link' href='{{ url('/admin') }}'>Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class='nav-link' href='{{ url('/login') }}'>Login</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
