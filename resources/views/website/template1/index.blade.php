@push('title')
{{$user->name}}
@endpush
<x-template1.website.master.master-layout>
    <x-template1.website.navbar.navbar :user="$user"/>
    <div class="container-fluid p-0">

        <!--====================================================
                            ABOUT
        ======================================================-->
        <x-template1.website.body.about :user="$user"/>

        <!--====================================================
                            Education
        ======================================================-->
        @if(count($education)!=0)
        <x-template1.website.body.education :education="$education"/>
        @endif


        <!--====================================================
                            Experience
        ======================================================-->
        @if(count($experience)!=0)
        <x-template1.website.body.experience :experience="$experience"/>
        @endif


        <!--====================================================
                            Project
        ======================================================-->
        @if(count($project)!=0)
        <x-template1.website.body.project :project="$project"/>
        @endif

        <!--====================================================
                            Blog
        ======================================================-->
        @if(count($blog)!=0)
        <x-template1.website.body.blog :blog="$blog"/>
        @endif

        <!--====================================================
                            CONTACT
        ======================================================-->
        <x-template1.website.body.contact :user="$user"/>
    </div>

</x-template1.website.master.master-layout>


