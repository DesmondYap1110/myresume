<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Edit Password</div>
            </div>
            <form id="exampleValidation" novalidate="novalidate">
                <div class="form-group form-show-validation row">
                    <label for="email" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">Email Address <span class="required-label">*</span></label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="email" class="form-control" id="email" placeholder="Enter Email" required="" data-sharkid="__3" data-sharklabel="email" disabled value="abc@gmail.com">
                    </div>
                </div>
                <div class="form-group form-show-validation row">
                    <label for="password" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">Password <span class="required-label">*</span></label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required="" data-sharkid="__4">
                    </div>
                </div>
                <div class="form-group form-show-validation row">
                    <label for="confirmpassword" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">Confirm Password <span class="required-label">*</span></label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Enter Password" required="" data-sharkid="__5">
                    </div>
                </div>
                <div class="card-action">
                    <div class="row">
                        <div class="col-md-12">
                            <input class="btn btn-success" type="submit" value="Submit">
                            <button type="reset" class="btn btn-danger">Reset</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-template1.admin.master.master-layout>

