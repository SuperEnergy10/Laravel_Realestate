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

                        <h6 class="card-title">Add Testimonials</h6>

                        <form method="POST" action="{{route('update.testimonials')}}" class="forms-sample" enctype="multipart/form-data">
                            @csrf
                            
                            <input type="hidden" name="id" value="{{$testimonial->id}}">

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input name="name" value="{{$testimonial->name}}" type="text" class="form-control" id="name">

                            </div>
                            <div class="mb-3">
                                <label for="position" class="form-label">Position</label>
                                <input name="position" value="{{$testimonial->position}}" type="text" class="form-control" id="position">

                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea type="text" name="message" class="form-control" row="3">
                                {{$testimonial->message}}
                                </textarea>

                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" class="form-control" id="image">
                            </div>

                            <div class="mb-3">
                                <label class="form-label"></label>
                                <img id="showImage" class="wd-80 rounded-circle"
                                    src="{{asset($testimonial->image)}}" alt="profile">
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
    $(document).ready(function() {
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    });
</script>


@endsection