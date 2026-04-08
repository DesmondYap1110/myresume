<!--   Core JS Files   -->
<script src="{{asset("assets/admin/js/core/jquery-3.7.1.min.js" )}}"></script>
<script src="{{asset("assets/admin/js/core/popper.min.js")}}"></script>
<script src="{{asset("assets/admin/js/core/bootstrap.min.js")}}"></script>

<!-- jQuery Scrollbar -->
<script src="{{asset("assets/admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js")}}"></script>

<!-- Chart JS -->
<script src="{{asset("assets/admin/js/plugin/chart.js/chart.min.js")}}"></script>

<!-- jQuery Sparkline -->
<script src="{{asset("assets/admin/js/plugin/jquery.sparkline/jquery.sparkline.min.js")}}"></script>

<!-- Chart Circle -->
<script src="{{asset("assets/admin/js/plugin/chart-circle/circles.min.js")}}"></script>

<!-- Datatables -->
<script src="{{asset("assets/admin/js/plugin/datatables/datatables.min.js")}}"></script>

<!-- Bootstrap Notify -->
<script src="{{asset("assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js")}}"></script>

<!-- jQuery Vector Maps -->
<script src="{{asset("assets/admin/js/plugin/jsvectormap/jsvectormap.min.js")}}"></script>
<script src="{{asset("assets/admin/js/plugin/jsvectormap/world.js") }}"></script>

<!-- Sweet Alert -->
<script src="{{asset("assets/admin/js/plugin/sweetalert/sweetalert.min.js") }}"></script>

<!-- Kaiadmin JS -->
<script src="{{asset("assets/admin/js/kaiadmin.min.js") }}"></script>

<!-- Fonts and icons -->
<script src="{{ asset("assets/admin/js/plugin/webfont/webfont.min.js") }}"></script>

<script>
    WebFont.load({
    google: { families: ["Public Sans:300,400,500,600,700"] },
    custom: {
        families: [
        "Font Awesome 5 Solid",
        "Font Awesome 5 Regular",
        "Font Awesome 5 Brands",
        "simple-line-icons",
        ],
        urls: ["{{ asset('assets/admin/css/fonts.min.css') }}"]
    },
    active: function () {
        sessionStorage.fonts = true;
    },
    });
</script>
