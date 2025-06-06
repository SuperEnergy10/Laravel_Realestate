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

                        <h6 class="card-title">Edit Property Amenitie</h6>

                        <form id="myForm" method="POST" action="{{route('update.amenitie')}}" class="forms-sample">
                            @csrf
                            <input type="hidden" name="id" value="{{$amenitie->id}}">

                            <div class="mb-3 form-group">
                                <label for="amenitie_name" class="form-label">Amenities Name</label>
                                <input value="{{$amenitie->amenitie_name}}" name="amenitie_name" type="text" class="form-control" id="amenitie_name">
                               
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
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                amenitie_name: {
                    required : true,
                }, 
                
            },
            messages :{
                amenitie_name: {
                    required : 'Please Enter Amenitie Name',
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