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

                        <h6 class="card-title">Update SMTP Setting</h6>

                        <form id="myForm" method="POST" action="{{route('update.smtp.setting')}}" class="forms-sample">
                            @csrf

                            <input type="hidden" name="id" value="{{$setting->id}}">

                            <div class="mb-3 form-group">
                                <label for="mailer" class="form-label">Mailer</label>
                                <input name="mailer" type="text" class="form-control" id="mailer" value="{{$setting->mailer}}">

                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label">host</label>
                                <input name="host" type="text" class="form-control" value="{{$setting->host}}">

                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label">port</label>
                                <input name="port" type="text" class="form-control" value="{{$setting->port}}">

                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label">username</label>
                                <input name="username" type="text" class="form-control" value="{{$setting->username}}">

                            </div>
                            <div class="mb-3 form-group">
                                <label for="password" class="form-label">password</label>
                                <input name="password" type="text" class="form-control" id="password" value="{{$setting->password}}">

                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label">encryption</label>
                                <input name="encryption" type="text" class="form-control" value="{{$setting->encryption}}">

                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label">from_address</label>
                                <input name="from_address" type="text" class="form-control" value="{{$setting->from_address}}">

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
        $('#myForm').validate({
            rules: {
                amenitie_name: {
                    required: true,
                },

            },
            messages: {
                amenitie_name: {
                    required: 'Please Enter Amenitie Name',
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