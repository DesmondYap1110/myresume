<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SAP PM Adrian</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"/>
    <link rel="icon" href="{{asset("assets/admin/img/kaiadmin/favicon.ico")}}" type="image/x-icon" />

    <x-template1.admin.master.master-style />

  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
        @include('components.template1.admin.sidebar.sidebar-main')
      <!-- End Sidebar -->

        <div class="main-panel">
                <!-- Header -->
                @include('components.template1.admin.header.header-main')
                <!-- End Header -->
                <div class="container">
                    <div class="page-inner">
                        {{$slot}}
                    </div>
                </div>

                <!-- Footer -->
                @include('components.template1.admin.footer.footer-main')
                <!-- End Footer -->
        </div>
      <div>

    @include('components.template1.admin.master.master-script')

  </body>
</html>
