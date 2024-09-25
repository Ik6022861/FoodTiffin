@extends('vendor.vendor_dashboard')

@section('vendor')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Add Product</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Product</li>
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
                        <form id="myForm" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Category Name</label>
                                        <select name="category_id" class="form-select">
                                            <option selected="" disabled="">Select</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Menu Name</label>
                                        <select name="menu_id" class="form-select">
                                            <option selected="" disabled="">Select</option>
                                            @foreach ($menu as $men)
                                                <option value="{{ $men->id }}">{{ $men->menu_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">City Name</label>
                                        <select name="city_id" class="form-select">
                                            <option selected="" disabled="">Select</option>
                                            @foreach ($city as $cit)
                                                <option value="{{ $cit->id }}">{{ $cit->city_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Product Name</label>
                                        <input class="form-control" type="text" name="name" id="name">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Price</label>
                                        <input class="form-control" type="text" name="price" id="price">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Discount Price</label>
                                        <input class="form-control" type="text" name="discount_price" id="discount_price">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Quantity</label>
                                        <input class="form-control" type="text" name="qty" id="qty">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Size</label>
                                        <input class="form-control" type="text" name="size" id="size">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Product Image</label>
                                        <input class="form-control" type="file" name="image" id="image">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <img src="{{ url('upload/no_image.jpg') }}" alt="" id="showImage" class="rounded avatar-lg">
                                    </div>
                                </div>

                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="best_seller" value="1" type="checkbox" id="formCheck2" >
                                    <label class="form-check-label" for="formCheck2">
                                        Best Seller
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="most_popular" value="1" type="checkbox" id="formCheck2" >
                                    <label class="form-check-label" for="formCheck2">
                                        Most Popular
                                    </label>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
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
                name: {
                    required : true,
                },
                image: {
                    required : true,
                },
                menu_id: {
                    required : true,
                },
                category_id: {
                    required : true,
                },
                city_id: {
                    required : true,
                },
                price: {
                    required : true,
                },
                qty: {
                    required : true,
                },

            },
            messages :{
                name: {
                    required : 'Please Enter Product Name',
                },
                image: {
                    required : 'Please Select Image',
                },
                menu_id: {
                    required : 'Please Select a menu',
                },
                category_id: {
                    required : 'Please Select a category',
                },
                city_id: {
                    required : 'Please Select a category',
                },
                price: {
                    required : 'Please Select Product Price',
                },
                qty: {
                    required : 'Please Select Product Price',
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
