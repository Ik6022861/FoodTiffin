@extends('vendor.vendor_dashboard')

@section('vendor')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Gallery</h4>

                    <div class="page-title-right">
                        {{-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">All Category</li>
                        </ol> --}}
                        <a href="{{ route('add.gallery') }}" class="btn btn-primary waves-effect waves-light">Add Gallery</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                {{-- <th>Vendor Name</th> --}}
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach ($gallery as $key=> $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><img src="{{ asset($item->gallery_img) }}" class="avatar-sm" alt=""></td>
                                    <td>
                                        <a href="{{ route('edit.gallery', $item->id) }}" class="btn btn-info waves-effect waves-light"><i class="fas fa-edit"></i></a>
                                        <a href="{{ route('delete.gallery', $item->id) }}" class="btn btn-danger waves-effect waves-light" id="delete"><i class="fas fa-trash"></i></a>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>


<script type="text/javascript">
    $(function() {
      $('.toggle-class').change(function() {
          var status = $(this).prop('checked') == true ? 1 : 0;
          var product_id = $(this).data('id');

          $.ajax({
              type: "GET",
              dataType: "json",
              url: '/changeStatus',
              data: {'status': status, 'product_id': product_id},
              success: function(data){
                // console.log(data.success)

                  // Start Message

              const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
              })
              if ($.isEmptyObject(data.error)) {

                      Toast.fire({
                      type: 'success',
                      title: data.success,
                      })

              }else{

             Toast.fire({
                      type: 'error',
                      title: data.error,
                      })
                  }

                // End Message


              }
          });
      })
    })
  </script>

@endsection
