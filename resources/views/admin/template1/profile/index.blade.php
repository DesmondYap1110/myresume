<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <div class="card-title">Form Elements</div>
                </div>
                <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="email2">Email Address</label>
                        <input type="email" class="form-control" id="email2" placeholder="Enter Email" data-sharkid="__1" data-sharklabel="email">
                        <small id="emailHelp2" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    <shark-icon-container data-sharkidcontainer="__1" style="position: absolute;"><template shadowrootmode="open"><surfhark-icon data-sharkidicon="__1" style="background-image: url(&quot;chrome-extension://ailoabdmgclmfmhdagmlohpjlbpffblp/autofill-action-light.svg&quot;); background-repeat: no-repeat; background-position: left center; background-size: cover; position: absolute; right: 0px; visibility: visible; display: block; z-index: 1; border: none; cursor: pointer; padding: 0px; transition: none; pointer-events: all; opacity: 1; left: 272.766px; top: -29.8906px; width: 18px; height: 18px; min-width: 18px; min-height: 18px;"></surfhark-icon></template></shark-icon-container></div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" data-sharkid="__2">
                    </div>
                    <div class="form-group form-inline">
                        <label for="inlineinput" class="col-md-3 col-form-label">Inline Input</label>
                        <div class="col-md-9 p-0">
                        <input type="text" class="form-control input-full" id="inlineinput" placeholder="Enter Input" data-sharkid="__3">
                        </div>
                    </div>
                    <div class="form-group has-success">
                        <label for="successInput">Success Input</label>
                        <input type="text" id="successInput" value="Success" class="form-control" data-sharkid="__4">
                    </div>
                    <div class="form-group has-error has-feedback">
                        <label for="errorInput">Error Input</label>
                        <input type="text" id="errorInput" value="Error" class="form-control" data-sharkid="__5">
                        <small id="emailHelp" class="form-text text-muted">Please provide a valid informations.</small>
                    </div>
                    <div class="form-group">
                        <label for="disableinput">Disable Input</label>
                        <input type="text" class="form-control" id="disableinput" placeholder="Enter Input" disabled="" data-sharkid="__6">
                    </div>
                    <div class="form-group">
                        <label>Gender</label><br>
                        <div class="d-flex">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" data-sharkid="__7">
                            <label class="form-check-label" for="flexRadioDefault1"> Male </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked="" data-sharkid="__8">
                            <label class="form-check-label" for="flexRadioDefault2">
                            Female
                            </label>
                        </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"> Static </label>
                        <p class="form-control-static">hello@example.com</p>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Example select</label>
                        <select class="form-select" id="exampleFormControlSelect1" data-sharkid="__9">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect2">Example multiple select</label>
                        <select multiple="" class="form-control" id="exampleFormControlSelect2" data-sharkid="__10">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Example file input</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea class="form-control" id="comment" rows="5" data-sharkid="__11"> </textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" data-sharkid="__12">
                        <label class="form-check-label" for="flexCheckDefault">
                            Agree with terms and conditions
                        </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">@</span>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" data-sharkid="__13">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2" data-sharkid="__14">
                        <span class="input-group-text" id="basic-addon2">@example.com</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="basic-url">Your vanity URL</label>
                        <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon3">https://example.com/users/</span>
                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" data-sharkid="__15">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" data-sharkid="__16">
                        <span class="input-group-text">.00</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                        <span class="input-group-text">With textarea</span>
                        <textarea class="form-control" aria-label="With textarea" data-sharkid="__17"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                        <button class="btn btn-black btn-border" type="button">Button</button>
                        <input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" data-sharkid="__18">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                        <input type="text" class="form-control" aria-label="Text input with dropdown button" data-sharkid="__19">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown
                            </button>
                            <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                            <div role="separator" class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Separated link</a>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon">
                        <input type="text" class="form-control" placeholder="Search for..." data-sharkid="__20">
                        <span class="input-icon-addon">
                            <i class="fa fa-search"></i>
                        </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon">
                        <span class="input-icon-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Username" data-sharkid="__21">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Image Check</label>
                        <div class="row">
                        <div class="col-6 col-sm-4">
                            <label class="imagecheck mb-4">
                            <input name="imagecheck" type="checkbox" value="1" class="imagecheck-input" data-sharkid="__22">
                            <figure class="imagecheck-figure">
                                <img src="../assets/img/examples/product1.jpg" alt="title" class="imagecheck-image">
                            </figure>
                            </label>
                        </div>
                        <div class="col-6 col-sm-4">
                            <label class="imagecheck mb-4">
                            <input name="imagecheck" type="checkbox" value="2" class="imagecheck-input" checked="" data-sharkid="__23">
                            <figure class="imagecheck-figure">
                                <img src="../assets/img/examples/product4.jpg" alt="title" class="imagecheck-image">
                            </figure>
                            </label>
                        </div>
                        <div class="col-6 col-sm-4">
                            <label class="imagecheck mb-4">
                            <input name="imagecheck" type="checkbox" value="3" class="imagecheck-input" data-sharkid="__24">
                            <figure class="imagecheck-figure">
                                <img src="../assets/img/examples/product3.jpg" alt="title" class="imagecheck-image">
                            </figure>
                            </label>
                        </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Color Input</label>
                        <div class="row gutters-xs">
                        <div class="col-auto">
                            <label class="colorinput">
                            <input name="color" type="checkbox" value="dark" class="colorinput-input" data-sharkid="__25">
                            <span class="colorinput-color bg-black"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="colorinput">
                            <input name="color" type="checkbox" value="primary" class="colorinput-input" data-sharkid="__26">
                            <span class="colorinput-color bg-primary"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="colorinput">
                            <input name="color" type="checkbox" value="secondary" class="colorinput-input" data-sharkid="__27">
                            <span class="colorinput-color bg-secondary"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="colorinput">
                            <input name="color" type="checkbox" value="info" class="colorinput-input" data-sharkid="__28">
                            <span class="colorinput-color bg-info"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="colorinput">
                            <input name="color" type="checkbox" value="success" class="colorinput-input" data-sharkid="__29">
                            <span class="colorinput-color bg-success"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="colorinput">
                            <input name="color" type="checkbox" value="danger" class="colorinput-input" data-sharkid="__30">
                            <span class="colorinput-color bg-danger"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="colorinput">
                            <input name="color" type="checkbox" value="warning" class="colorinput-input" data-sharkid="__31">
                            <span class="colorinput-color bg-warning"></span>
                            </label>
                        </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Size</label>
                        <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="value" value="50" class="selectgroup-input" checked="" data-sharkid="__32">
                            <span class="selectgroup-button">S</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="value" value="100" class="selectgroup-input" data-sharkid="__33">
                            <span class="selectgroup-button">M</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="value" value="150" class="selectgroup-input" data-sharkid="__34">
                            <span class="selectgroup-button">L</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="value" value="200" class="selectgroup-input" data-sharkid="__35">
                            <span class="selectgroup-button">XL</span>
                        </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Icons input</label>
                        <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="transportation" value="2" class="selectgroup-input" data-sharkid="__36">
                            <span class="selectgroup-button selectgroup-button-icon"><i class="icon-screen-smartphone"></i></span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="transportation" value="1" class="selectgroup-input" checked="" data-sharkid="__37">
                            <span class="selectgroup-button selectgroup-button-icon"><i class="icon-screen-tablet"></i></span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="transportation" value="6" class="selectgroup-input" data-sharkid="__38">
                            <span class="selectgroup-button selectgroup-button-icon"><i class="icon-screen-desktop"></i></span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="transportation" value="6" class="selectgroup-input" data-sharkid="__39">
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fa fa-times"></i></span>
                        </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label d-block">Icon input</label>
                        <div class="selectgroup selectgroup-secondary selectgroup-pills">
                        <label class="selectgroup-item">
                            <input type="radio" name="icon-input" value="1" class="selectgroup-input" checked="" data-sharkid="__40">
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fa fa-sun"></i></span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="icon-input" value="2" class="selectgroup-input" data-sharkid="__41">
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fa fa-moon"></i></span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="icon-input" value="3" class="selectgroup-input" data-sharkid="__42">
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fa fa-tint"></i></span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="icon-input" value="4" class="selectgroup-input" data-sharkid="__43">
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fa fa-cloud"></i></span>
                        </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Your skills</label>
                        <div class="selectgroup selectgroup-pills">
                        <label class="selectgroup-item">
                            <input type="checkbox" name="value" value="HTML" class="selectgroup-input" checked="" data-sharkid="__44">
                            <span class="selectgroup-button">HTML</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="value" value="CSS" class="selectgroup-input" data-sharkid="__45">
                            <span class="selectgroup-button">CSS</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="value" value="PHP" class="selectgroup-input" data-sharkid="__46">
                            <span class="selectgroup-button">PHP</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="value" value="JavaScript" class="selectgroup-input" data-sharkid="__47">
                            <span class="selectgroup-button">JavaScript</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="value" value="Ruby" class="selectgroup-input" data-sharkid="__48">
                            <span class="selectgroup-button">Ruby</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="value" value="Ruby" class="selectgroup-input" data-sharkid="__49">
                            <span class="selectgroup-button">Ruby</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="value" value="C++" class="selectgroup-input" data-sharkid="__50">
                            <span class="selectgroup-button">C++</span>
                        </label>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                    <label class="mb-3"><b>Form Group Default</b></label>
                    <div class="form-group form-group-default">
                        <label>Input</label>
                        <input id="Name" type="text" class="form-control" placeholder="Fill Name" data-sharkid="__51">
                    </div>
                    <div class="form-group form-group-default">
                        <label>Select</label>
                        <select class="form-select" id="formGroupDefaultSelect" data-sharkid="__52">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        </select>
                    </div>
                    <label class="mt-3 mb-3"><b>Form Floating Label</b></label>
                    <div class="form-floating form-floating-custom mb-3">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" data-sharkid="__53" data-sharklabel="email">
                        <label for="floatingInput">Email address</label>
                    <shark-icon-container data-sharkidcontainer="__53" style="position: absolute;"><template shadowrootmode="open"><surfhark-icon data-sharkidicon="__53" style="background-image: url(&quot;chrome-extension://ailoabdmgclmfmhdagmlohpjlbpffblp/autofill-action-light.svg&quot;); background-repeat: no-repeat; background-position: left center; background-size: cover; position: absolute; right: 0px; visibility: visible; display: block; z-index: 1; border: none; cursor: pointer; padding: 0px; transition: none; pointer-events: all; opacity: 1; left: 548.828px; top: -34.5px; width: 18px; height: 18px; min-width: 18px; min-height: 18px;"></surfhark-icon></template></shark-icon-container></div>
                    <div class="form-floating form-floating-custom mb-3">
                        <select class="form-select" id="selectFloatingLabel" required="" data-sharkid="__54">
                        <option selected="">1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        </select>
                        <label for="selectFloatingLabel">Select</label>
                    </div>

                    <div class="form-group">
                        <label for="largeInput">Large Input</label>
                        <input type="text" class="form-control form-control-lg" id="largeInput" placeholder="Large Input" data-sharkid="__55">
                    </div>
                    <div class="form-group">
                        <label for="largeInput">Default Input</label>
                        <input type="text" class="form-control form-control" id="defaultInput" placeholder="Default Input" data-sharkid="__56">
                    </div>
                    <div class="form-group">
                        <label for="smallInput">Small Input</label>
                        <input type="text" class="form-control form-control-sm" id="smallInput" placeholder="Small Input" data-sharkid="__57">
                    </div>
                    <div class="form-group">
                        <label for="largeSelect">Large Select</label>
                        <select class="form-select form-control-lg" id="largeSelect" data-sharkid="__58">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="defaultSelect">Default Select</label>
                        <select class="form-select form-control" id="defaultSelect" data-sharkid="__59">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="smallSelect">Small Select</label>
                        <select class="form-select form-control-sm" id="smallSelect" data-sharkid="__60">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        </select>
                    </div>
                    </div>
                </div>
                </div>
                <div class="card-action">
                <button class="btn btn-success">Submit</button>
                <button class="btn btn-danger">Cancel</button>
                </div>
            </div>
        </div>
</x-template1.admin.master.master-layout>

