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

                        <h6 class="card-title">Add Permission</h6>

                        <form id="myForm" method="POST" action="{{route('store.permission')}}" class="forms-sample">
                            @csrf

                            <div class="mb-3 form-group">
                                <label class="form-label">Permission Name</label>
                                <input name="name" type="text" class="form-control">

                            </div>

                            <div class="mb-3 form-group">
                                <label class="form-label">Group Name</label>
                                <select name="group_name" class="form-select" id="exampleFormControlSelect2">
                                    <option selected="" disabled="">Select Group</option>
                                    <option value="type">Property Type</option>
                                    <option value="state">State</option>
                                    <option value="amenities">Amenities</option>
                                    <option value="property">Property</option>
                                    <option value="history">Package History</option>
                                    <option value="message">Property Message</option>
                                    <option value="testimonials">Testimonials</option>
                                    <option value="agent">Manage Agent</option>
                                    <option value="category">Blog Category</option>
                                    <option value="post">Blog Post</option>
                                    <option value="comment">Blog Comment</option>
                                    <option value="smtp">SMTP Setting</option>
                                    <option value="site">Site Setting</option>
                                    <option value="role">Role & Permission</option>

                                </select>
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



@endsection