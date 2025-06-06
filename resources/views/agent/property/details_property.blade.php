@extends('agent.agent_dashboard')

@section('agent')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Property Details</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">

                            <tbody>
                                <tr>
                                    <td>Property Name</td>
                                    <td><code>{{$property->property_name}}</code></td>
                                </tr>
                                <tr>
                                    <td>Property Status</td>
                                    <td><code>{{$property->property_status}}</code></td>
                                </tr>
                                <tr>
                                    <td>Lowest Price</td>
                                    <td><code>{{$property->lowest_price}}</code></td>
                                </tr>
                                <tr>
                                    <td>Max Price</td>
                                    <td><code>{{$property->max_price}}</code></td>
                                </tr>
                                <tr>
                                    <td>Bedrooms</td>
                                    <td><code>{{$property->bedrooms}}</code></td>
                                </tr>
                                <tr>
                                    <td>Bathrooms</td>
                                    <td><code>{{$property->bathrooms}}</code></td>
                                </tr>
                                <tr>
                                    <td>Garage Size</td>
                                    <td><code>{{$property->garage_size}}</code></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td><code>{{$property->address}}</code></td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td><code>{{$property->city}}</code></td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td><code>{{$property['pstate']['state_name']}}</code></td>
                                </tr>
                                <tr>
                                    <td>Postal Code</td>
                                    <td><code>{{$property->postal_code}}</code></td>
                                </tr>
                                <tr>
                                    <td>Main Thumbnail</td>
                                    <td>
                                        <img src="{{asset($property->property_thumbnail)}}" style="height: 70px; width: 100px" alt="">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        @if($property->status == 1)
                                        <span class="badge rounded-pill bg-success">Active</span>
                                        @else
                                        <span class="badge rounded-pill bg-danger">InActive</span>

                                        @endif
                                    </td>
                                </tr>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">

                            <tbody>
                                <tr>
                                    <td>Property Code</td>
                                    <td><code>{{$property->property_code}}</code></td>
                                </tr>
                                <tr>
                                    <td>Property Size</td>
                                    <td><code>{{$property->property_size}}</code></td>
                                </tr>
                                <tr>
                                    <td>Property Video</td>
                                    <td><code>{{$property->property_video}}</code></td>
                                </tr>
                                <tr>
                                    <td>Neighborhood</td>
                                    <td><code>{{$property->neighborhood}}</code></td>
                                </tr>
                                <tr>
                                    <td>Latitude</td>
                                    <td><code>{{$property->latitude}}</code></td>
                                </tr>
                                <tr>
                                    <td>Longitude</td>
                                    <td><code>{{$property->longtitude}}</code></td>
                                </tr>
                                <tr>
                                    <td>Property Type</td>
                                    <td><code>{{$property['type']['type_name']}}</code></td>
                                </tr>
                                <tr>
                                    <td>Property Amenities</td>
                                    <td>
                                        <select name="amenities_id[]" class="js-example-basic-multiple form-select" multiple="multiple" data-width="100%">
                                            @foreach($amenities as $amenitie)
                                            <option value="{{$amenitie->amenitie_name}}"
                                                {{(in_array($amenitie->amenitie_name, $property_ami)) ? 'selected' : ''}}>{{$amenitie->amenitie_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Agent</td>
                                    @if($property->agent_id == NULL)
                                    <td><code>Admin</code></td>
                                    @else
                                    <td><code>{{$property['user']['name']}}</code></td>
                                    @endif
                                </tr>

                                <tr>
                                    <td>Short Description</td>
                                    <td><code>{{$property->short_descp}}</code></td>
                                </tr>
                                <tr>
                                    <td>Long Description</td>
                                    <td><code>{!! $property->long_descp !!}</code></td>
                                </tr>

                            </tbody>
                        </table>
                        <br><br>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection