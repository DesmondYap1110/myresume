@push('script')
    <script>
    // This will create a single gallery from all elements that have class "gallery-item"
    $(document).ready(function () {
        $('#mytable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
        });
    });
    </script>
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>

         <div class="col-md-12">
        <div class="card">
        <div class="card-header">
            <div class="card-head-row card-tools-still-right">
            <div class="card-title">Inbox</div>
        </div>
        </div>
        <div class="card-body">
            <table class="table table-hover" id="mytable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>
                            <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm d-flex justify-content-center align-items-center">
                                <li><a class="nav-link btn btn-primary text-white"  href="{{route('inbox.view.message',"7897")}}">View</a></li>
                                <li><a class="nav-link btn btn-danger text-white"  href="{{route('inbox.delete')}}">Delete</a></li>
                            </ul>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



</x-template1.admin.master.master-layout>
