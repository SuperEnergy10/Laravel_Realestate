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

                        <h6 class="card-title">Edit Agent</h6>

                        <form id="myForm" method="POST" action="{{route('update.agent')}}" class="forms-sample">
                            @csrf
                            <input type="hidden" name="id" value="{{$allagent->id}}">
                            <div class="mb-3 form-group">
                                <label for="agent_name" class="form-label">Agent Name</label>
                                <input name="name" value="{{$allagent->name}}" type="text" class="form-control" id="agent_name">

                            </div>
                            <div class="mb-3 form-group">
                                <label for="agent_email" class="form-label">Agent Email</label>
                                <input name="email" value="{{$allagent->email}}" type="email" class="form-control" id="agent_email">

                            </div>
                            <div class="mb-3 form-group">
                                <label for="phone" class="form-label">Agent Phone</label>
                                <input name="phone" value="{{$allagent->phone}}" type="text" class="form-control" id="phone">

                            </div>
                            <div class="mb-3 form-group">
                                <label for="agent_address" class="form-label">Agent Address</label>
                                <input name="address" value="{{$allagent->address}}" type="text" class="form-control" id="agent_address">

                                <br><br>
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
        $('#myForm').validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                phone: {
                    required: true,
                },
                password: {
                    required: true,
                },


            },
            messages: {
                name: {
                    required: 'Please Enter Name',
                },
                email: {
                    required: 'Please Enter Email',
                },
                phone: {
                    required: 'Please Enter Phone',
                },
                password: {
                    required: 'Please Enter Password',
                },


            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>

@endsection