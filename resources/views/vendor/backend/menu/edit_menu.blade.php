@extends('vendor.vendor_dashboard')

@section('vendor')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Edit Menu</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Menu</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-4">
                        <form id="myForm" action="{{ route('menu.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" value="{{ $menu->id }}" name="id">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div>
                                        <div class="form-group mb-3">
                                            <label for="menu_name" class="form-label">Menu Name</label>
                                            <input class="form-control" type="text" value="{{ $menu->menu_name }}" name="menu_name" id="menu_name">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mt-3 mt-lg-0">
                                        <div class="form-group mb-3">
                                            <label for="image" class="form-label">Menu Image</label>
                                            <input class="form-control" type="file" name="image" id="image">
                                        </div>
                                        <div class="mb-3">
                                            <img id='showImage' src="{{ asset($menu->image) }}" alt="" class="rounded avatar-lg" width="110">
                                        </div>

                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result); // Changed 'r' to 'e'
            }
            reader.readAsDataURL(e.target.files[0]); // 'files[0]' is correct
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                menu_name: {
                    required : true,
                },

            },
            messages :{
                menu_name: {
                    required : 'Please Enter Menu Name',
                },

            },
            errorElement : 'span',
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });

</script>
@endsection
