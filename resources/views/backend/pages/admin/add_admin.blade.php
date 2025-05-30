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

                        <h6 class="card-title">Add Admin</h6>

                        <form id="myForm" method="POST" action="{{route('store.admin')}}" class="forms-sample">
                            @csrf

                            <div class="mb-3 form-group">
                                <label for="admin_username" class="form-label">Admin User Name</label>
                                <input name="username" type="text" class="form-control" id="admin_username">
                               
                            </div>

                            <div class="mb-3 form-group">
                                <label for="admin_name" class="form-label">Admin Name</label>
                                <input name="name" type="text" class="form-control" id="admin_name">
                               
                            </div>
                            <div class="mb-3 form-group">
                                <label for="admin_email" class="form-label">Admin Email</label>
                                <input name="email" type="email" class="form-control" id="admin_email">
                               
                            </div>
                            <div class="mb-3 form-group">
                                <label for="phone" class="form-label">Admin Phone</label>
                                <input name="phone" type="text" class="form-control" id="phone">
                               
                            </div>
                            <div class="mb-3 form-group">
                                <label for="admin_address" class="form-label">Admin Address</label>
                                <input name="address" type="text" class="form-control" id="admin_address">
                               
                            <div class="mb-3 form-group">
                                <label for="admin_password" class="form-label">Admin Password</label>
                                <input name="password" type="password" class="form-control" id="admin_password">
                               
                            </div>
                            
                            <div class="mb-3 form-group">
                            <label for="role" class="form-label">Roles Name</label>
                                <select name="roles" class="form-select" id="role">
                                    <option selected="" disabled="">Select Role</option>

                                    @foreach($roles as $role)
                                    <option value="{{$role->name}}">{{$role->name}}</option>
                                    @endforeach

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