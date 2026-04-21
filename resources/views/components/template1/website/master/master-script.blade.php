
<script src="{{asset('assets/website/js/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/website/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/website/js/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/website/js/counter/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('assets/website/js/counter/jquery.counterup.min.js')}}"></script>
<script src="{{asset('assets/website/js/custom.js')}}"></script>
<!-- Bootstrap Notify -->
<script src="{{asset("assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js")}}"></script>
<script>
    $(document).ready(function(){

        $(".filter-b").click(function(){
            var value = $(this).attr('data-filter');
            if(value == "all")
            {
                $('.filter').show('1000');
            }
            else
            {
                $(".filter").not('.'+value).hide('3000');
                $('.filter').filter('.'+value).show('3000');
            }
        });

        if ($(".filter-b").removeClass("active"))
        {
            $(this).removeClass("active");
        }

        $(this).addClass("active");
    });

    // SKILLS
    $(function () {
        $('.counter').counterUp({
            delay: 10,
            time: 2000
        });

    });
</script>

<script>
    $(document).ready(function () {

        @if(session('success'))
            $.notify("{{ session('success') }}", "success");
        @endif

        @if(session('error'))
            $.notify("{{ session('error') }}", "error");
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                $.notify("{{ $error }}", "error");
            @endforeach
        @endif
    });
</script>
