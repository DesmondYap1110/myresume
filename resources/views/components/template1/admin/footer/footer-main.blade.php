@php
    $companyname = "Adrian";
    $powerby = "Desmond";
@endphp

<footer class="footer fixed-bottom position-fixed bg-light">
    <div class="container d-flex flex-row-reverse">
        <div class="copyright">
            © Copyright {{ date("Y")." ".$companyname }}. All Rights Reserved.
        </div>
        <div>
            Powered by {{$powerby}}
        </div>
    </div>
</footer>
