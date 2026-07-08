<script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/jarallax.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/nice-select2.js') }}"></script>
<script src="{{ asset('assets/frontend/js/venobox.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/nouislider.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/purecounter_vanilla.js') }}"></script>
<script src="{{ asset('assets/frontend/js/gsap.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/SplitText.js') }}"></script>
<script src="{{ asset('assets/frontend/js/ScrollTrigger.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/custom.js') }}"></script>

<script src="{{ asset('assets/common/js/app.js') }}"></script>
<script src="{{ asset('assets/common/js/common.js') }}"></script>

<script src="{{ asset('assets/backend/libs/sweetalert2/sweetalert2.min.js') }}"></script>

@yield('js')

<script>
    function csrf_token(){
        $token = "{{ csrf_token() }}";
        return $token;
    }
</script>

@yield('script')


