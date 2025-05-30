@extends('admin.admin_dashboard')

@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">


    <div class="row profile-body">

        <!-- middle wrapper start -->
        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Update Site Setting</h6>

                        <form id="myForm" method="POST" action="{{route('update.site.setting')}}" class="forms-sample" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{$setting->id}}">

                            <div class="mb-3 form-group">
                                <label class="form-label">Support Phone</label>
                                <input name="support_phone" type="text" class="form-control" value="{{$setting->support_phone}}">

                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label">Company Address</label>
                                <input name="company_address" type="text" class="form-control" value="{{$setting->company_address}}">

                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label">Email</label>
                                <input name="email" type="text" class="form-control" value="{{$setting->email}}">

                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label">Facebook</label>
                                <input name="facebook" type="text" class="form-control" value="{{$setting->facebook}}">

                            </div>
                            <div class="mb-3 form-group">
                                <label for="password" class="form-label">Twitter</label>
                                <input name="twitter" type="text" class="form-control" id="password" value="{{$setting->twitter}}">

                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label">Copyright</label>
                                <input name="copyright" type="text" class="form-control" value="{{$setting->copyright}}">

                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label">Logo</label>
                                <input type="file" name="logo" class="form-control" id="image">
                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label"></label>
                                <img id="showImage" class="wd-80 rounded-circle" src="{{ asset($setting->logo)}}" alt="profile">
                            </div>





                            <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
        <!-- middle wrapper end -->
        <!-- right wrapper start -->

        <!-- right wrapper end -->
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    });

</script>

@endsection