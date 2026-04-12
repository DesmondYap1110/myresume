<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="img/favicon.ico">
    <title>@stack('title')</title>

    <!-- Global stylesheets -->
    @include('components.template1.website.master.master-style')
</head>
<body id="page-top">

    {{$slot}}
    <!--====================================================
                        PORTFOLIO MODALS
    ======================================================-->
    @include('components.template1.website.modal.modal')

    <!-- Global javascript -->
    @include('components.template1.website.master.master-script')

</body>
</html>
