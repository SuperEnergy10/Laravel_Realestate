@extends('admin.admin_dashboard')

@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">


    <div class="row profile-body">

        <!-- middle wrapper start -->
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Add Property</h6>

                        <form method="post" action="{{route('update.property')}}" id="myForm" enctype="multipart/form-data">
                            @csrf


                            <input type="hidden" name="id" value="{{$property->id}}">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Property Name</label>
                                        <input name="property_name" type="text"
                                            class="form-control"
                                            placeholder="Enter first name"
                                            value="{{$property->property_name}}">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Property Status</label>
                                        <select name="property_status" class="form-select" id="exampleFormControlSelect2">
                                            <option selected="" disabled="">Select Status</option>
                                            <option value="rent"
                                                {{ $property->property_status == 'rent' ? 'selected' :'' }}>For Rent</option>
                                            <option value="buy"
                                                {{ $property->property_status == 'buy' ? 'selected' :'' }}>For Buy</option>

                                        </select>
                                    </div>
                                </div><!-- Col -->

                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Lowest Price</label>
                                        <input value="{{$property->lowest_price}}" name="lowest_price" type="text" class="form-control" placeholder="Enter lowest price">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Max Price</label>
                                        <input value="{{$property->max_price}}" name="max_price" type="text" class="form-control" placeholder="Enter max price">
                                    </div>
                                </div>



                            </div><!-- Row -->
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Bedrooms</label>
                                        <input value="{{$property->bedrooms}}" name="bedrooms" type="text" class="form-control">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Bathrooms</label>
                                        <input value="{{$property->bathrooms}}" name="bathrooms" type="text" class="form-control">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Garage</label>
                                        <input value="{{$property->garage}}" name="garage" type="text" class="form-control">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Garage Size</label>
                                        <input value="{{$property->garage_size}}" name="garage_size" type="text" class="form-control">
                                    </div>
                                </div>
                            </div><!-- Row -->

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Address</label>
                                        <input value="{{$property->address}}" name="address" type="text" class="form-control">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">City</label>
                                        <input value="{{$property->city}}" name="city" type="text" class="form-control">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">State</label>
                                        <select name="state" class="form-control" id="">
                                            <option selected disabled>Select Type</option>
                                            @foreach($pstate as $state)
                                            <option value="{{ $state->id }}" {{ (int)$state->id === (int)($property->state ?? 0) ? 'selected' : '' }}>
                                            {{ $state->state_name }}                                            
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Postal Code</label>
                                        <input value="{{$property->postal_code}}" name="postal_code" type="text" class="form-control">
                                    </div>
                                </div>
                            </div><!-- Row -->

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Property Size</label>
                                        <input value="{{$property->property_size}}" name="property_size" type="text" class="form-control">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Property Video</label>
                                        <input value="{{$property->property_video}}" name="property_video" type="text" class="form-control">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Neighborhood</label>
                                        <input value="{{$property->neighborhood}}" name="neighborhood" type="text" class="form-control">
                                    </div>
                                </div><!-- Col -->

                            </div><!-- Row -->


                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Property Type</label>
                                        <select name="ptype_id" class="form-control" id="">
                                            <option selected disabled>Select Type</option>
                                            @foreach($propertyType as $ptype)
                                            <option value="{{$ptype->id}}"
                                                {{ $ptype->id == $property->ptype_id ? 'selected' :'' }}>{{$ptype->type_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Property Amenities</label>
                                        <select name="amenities_id[]" class="js-example-basic-multiple form-select" multiple="multiple" data-width="100%">
                                            @foreach($amenities as $amenitie)
                                            <option value="{{$amenitie->amenitie_name}}"
                                                {{(in_array($amenitie->amenitie_name, $property_ami)) ? 'selected' : ''}}>{{$amenitie->amenitie_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Agent</label>
                                        <select name="agent_id" class="form-select" id="">
                                            <option selected disabled>Select Agent</option>
                                            @foreach($activeAgent as $agent)
                                            <option value="{{$agent->id}}"
                                                {{ $agent->id == $property->agent_id ? 'selected' :'' }}>{{$agent->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- Col -->

                            </div><!-- Row -->


                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Short Description</label>
                                    <textarea type="text" name="short_descp" class="form-control" row="3">
                                    {{$property->short_descp}}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Long Description</label>
                                    <textarea name="long_descp" class="form-control" id="tinymceExample" rows="10">
                                        {!! $property->long_descp !!}</textarea>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Latitude</label>
                                        <input value="{{$property->latitude}}" type="text" name="latitude" class="form-control">
                                        <a href="https://www.latlong.net/convert-address-to-lat-long.html" target="_blank">Go here to get Latitude from address</a>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Longtitude</label>
                                        <input value="{{$property->longtitude}}" type="text" name="longtitude" class="form-control" autocomplete="off">
                                        <a href="https://www.latlong.net/convert-address-to-lat-long.html" target="_blank">Go here to get Longtitude from address</a>

                                    </div>
                                </div><!-- Col -->
                            </div><!-- Row -->

                            <hr>

                            <div class="form-group mb-3">
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" name="featured"
                                        {{$property->featured == 1 ? 'checked' : ''}}
                                        value="1" class="form-check-input" id="checkInline1">
                                    <label class="form-check-label" for="checkInline1">
                                        Features Property
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" name="hot"
                                        {{$property->hot == 1 ? 'checked' : ''}}
                                        value="1" class="form-check-input" id="checkInline">
                                    <label class="form-check-label" for="checkInline">
                                        Hot Property
                                    </label>
                                </div>
                            </div>




                            <button type="submit" class="btn btn-primary">Save Changes</button>

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


<!-- property mainthumbnail image update -->
<div class="page-content" style="margin-top: -35px">


    <div class="row profile-body">

        <!-- middle wrapper start -->
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Edit Main Thumbnail Image</h6>

                        <form method="post" action="{{route('update.property.thumbnail')}}" id="myForm" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{$property->id}}">
                            <input type="hidden" name="old_img" value="{{$property->property_thumbnail}}">

                            <div class="row mb-3">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Main Thumbnail</label>
                                    <input onChange="mainThumbUrl(this)" name="main_thumbnail" type="file" class="form-control" placeholder="Enter first name">
                                    <img src="" alt="" id="mainThumb">
                                </div>
                                <div class="form-group col-md-6">
                                    <img src="{{asset($property->property_thumbnail)}}"
                                        style="width:100px; height: 100px"
                                        alt="">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  -->

<!-- property multi image update -->
<div class="page-content" style="margin-top: -35px">


    <div class="row profile-body">

        <!-- middle wrapper start -->
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Edit Multi Image</h6>

                        <form method="post" action="{{route('update.property.multiimage')}}" id="myForm" enctype="multipart/form-data">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Image</th>
                                            <th>Change Image</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($multiImage as $key => $img)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td class="py-1">
                                                <img src="{{asset($img->photo_name)}}" alt="image" style="width:50px; height: 50px">
                                            </td>
                                            <td>
                                                <input type="file" name="multi_img[{{$img->id}}]" class="form-control">
                                            </td>

                                            <td>
                                                <input type="submit" class="btn btn-primary px-4" value="Update Image">
                                                <a href="{{ route('delete.property.multiimage',$img->id)}}" class="btn btn-danger" id="delete">Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <br><br>
                        </form>




                        <form method="post" action="{{route('store.new.multiimage')}}" id="myForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="imageid" value="{{$property->id}}">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td><input type="file" class="form-control" name="multi_img"></td>
                                        <td><input type="submit" class="btn btn-info px-4" value="Add Image"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  -->

<!-- facility update -->
<div class="page-content" style="margin-top: -35px">


    <div class="row profile-body">

        <!-- middle wrapper start -->
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Edit Property Facility</h6>

                        <form method="post" action="{{route('update.property.facilities')}}" id="myForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$property->id}}">
                            @foreach($facilities as $item)
                            <div class="row add_item">
                                <div class="whole_extra_item_add" id="whole_extra_item_add">
                                    <div class="whole_extra_item_delete" id="whole_extra_item_delete">
                                        <div class="container mt-2">
                                            <div class="row">

                                                <div class="form-group col-md-4">
                                                    <label for="facility_name">Facilities</label>
                                                    <select name="facility_name[]" id="facility_name" class="form-control">
                                                        <option value="">Select Facility</option>
                                                        <option value="Hospital" {{$item->facility_name == 'Hospital' ? 'selected' : '' }}>Hospital</option>
                                                        <option value="SuperMarket" {{$item->facility_name == 'SuperMarket' ? 'selected' : '' }}>Super Market</option>
                                                        <option value="School" {{$item->facility_name == 'School' ? 'selected' : '' }}>School</option>
                                                        <option value="Entertainment" {{$item->facility_name == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                                                        <option value="Pharmacy" {{$item->facility_name == 'Pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                                                        <option value="Airport" {{$item->facility_name == 'Airport' ? 'selected' : '' }}>Airport</option>
                                                        <option value="Railways" {{$item->facility_name == 'Railways' ? 'selected' : '' }}>Railways</option>
                                                        <option value="Bus Stop" {{$item->facility_name == 'Bus Stop' ? 'selected' : '' }}>Bus Stop</option>
                                                        <option value="Beach" {{$item->facility_name == 'Beach' ? 'selected' : '' }}>Beach</option>
                                                        <option value="Mall" {{$item->facility_name == 'Mall' ? 'selected' : '' }}>Mall</option>
                                                        <option value="Bank" {{$item->facility_name == 'Bank' ? 'selected' : '' }}>Bank</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="distance">Distance</label>
                                                    <input type="text" name="distance[]" id="distance" class="form-control" value="{{$item->distance}}">
                                                </div>
                                                <div class="form-group col-md-4" style="padding-top: 20px">
                                                    <span class="btn btn-success btn-sm addeventmore"><i class="fa fa-plus-circle">Add</i></span>
                                                    <span class="btn btn-danger btn-sm removeeventmore"><i class="fa fa-minus-circle">Remove</i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <br><br>
                            <button type="submit" class="btn btn-primary">Save changes</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end facility update  -->
<div style="visibility: hidden">
    <div class="whole_extra_item_add" id="whole_extra_item_add">
        <div class="whole_extra_item_delete" id="whole_extra_item_delete">
            <div class="container mt-2">
                <div class="row">

                    <div class="form-group col-md-4">
                        <label for="facility_name">Facilities</label>
                        <select name="facility_name[]" id="facility_name" class="form-control">
                            <option value="">Select Facility</option>
                            <option value="Hospital">Hospital</option>
                            <option value="SuperMarket">Super Market</option>
                            <option value="School">School</option>
                            <option value="Entertainment">Entertainment</option>
                            <option value="Pharmacy">Pharmacy</option>
                            <option value="Airport">Airport</option>
                            <option value="Railways">Railways</option>
                            <option value="Bus Stop">Bus Stop</option>
                            <option value="Beach">Beach</option>
                            <option value="Mall">Mall</option>
                            <option value="Bank">Bank</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="distance">Distance</label>
                        <input type="text" name="distance[]" id="distance" class="form-control" placeholder="Distance (Km)">
                    </div>
                    <div class="form-group col-md-4" style="padding-top: 20px">
                        <span class="btn btn-success btn-sm addeventmore"><i class="fa fa-plus-circle">Add</i></span>
                        <span class="btn btn-danger btn-sm removeeventmore"><i class="fa fa-minus-circle">Remove</i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!----For Section Facilities- ------->
<script type="text/javascript">
    $(document).ready(function() {
        var counter = 0;
        $(document).on("click", ".addeventmore", function() {
            var whole_extra_item_add = $("#whole_extra_item_add").html();
            $(this).closest(".add_item").append(whole_extra_item_add);
            counter++;
        });
        $(document).on("click", ".removeeventmore", function(event) {
            $(this).closest("#whole_extra_item_delete").remove();
            counter -= 1
        });
    });
</script>
<!--========== End of add multiple class with ajax ==============-->

<script type="text/javascript">
    $(document).ready(function() {
        $('#myForm').validate({
            rules: {
                property_name: {
                    required: true,
                },
                property_status: {
                    required: true,
                },
                lowest_price: {
                    required: true,
                },
                max_price: {
                    required: true,
                },
                property_thumbnail: {
                    required: true,
                },
                multi_img: {
                    required: true,
                },


            },
            messages: {
                property_name: {
                    required: 'Please Enter Property Name',
                },
                property_status: {
                    required: 'Please Select Property Status',
                },
                lowest_price: {
                    required: 'Please Enter Lowest Price',
                },
                max_price: {
                    required: 'Please Enter Max Price',
                },
                property_thumbnail: {
                    required: 'Please Select Property Image',
                },
                multi_img: {
                    required: 'Please Enter Property MultiImage',
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

<script>
    function mainThumbUrl(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#mainThumb').attr('src', e.target.result).width(80).height(80);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script>
    $(document).ready(function() {
        $('#multiImg').on('change', function() { //on file input change
            if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
            {
                var data = $(this)[0].files; //this file data

                $('#preview_img').empty(); // Xóa ảnh cũ trước khi thêm ảnh mới

                $.each(data, function(index, file) { //loop though each file
                    if (/(\.|\/)(gif|jpe?g|png|webp)$/i.test(file.type)) { //check supported file type
                        var fRead = new FileReader(); //new filereader
                        fRead.onload = (function(file) { //trigger function on successful read
                            return function(e) {
                                var img = $('<img/>').addClass('thumb').attr('src', e.target.result).width(100)
                                    .height(80); //create image element 
                                $('#preview_img').append(img); //append image to output element
                            };
                        })(file);
                        fRead.readAsDataURL(file); //URL representing the file's data.
                    }
                });

            } else {
                alert("Your browser doesn't support File API!"); //if File API is absent
            }
        });
    });
</script>

@endsection