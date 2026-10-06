{{-- Rendered outside .main-panel by the layout, so this stays pinned to the
     bottom of the window even while the mobile sidebar is open - that state
     transforms .main-panel, which would otherwise capture it. --}}
<footer class="footer fixed-bottom position-fixed bg-light">
    <div class="container d-flex flex-row-reverse">
        <div class="copyright">
            © Copyright {{ date("Y") }}. All Rights Reserved.
        </div>
        <div>
            Powered by Desmond Yap
        </div>
    </div>
</footer>
