@extends('frontend.frontend_dashboard')
@section('main')

<!--Page Title-->
<section class="page-title-two bg-color-1 centred">
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url({{ asset('frontend/assets/images/shape/shape-9.png')}});"></div>
        <div class="pattern-1" style="background-image: url({{ asset('frontend/assets/images/shape/shape-10.png') }});"></div>
    </div>
    <div class="auto-container">
        <div class="content-box clearfix">
            <h1>Property Search</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="index.html">Home</a></li>
                <li>Property Search</li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Title-->


<!-- property-page-section -->
<section class="property-page-section property-list">
    <div class="auto-container">
        <div class="row clearfix">
           
            <div class="col-lg-12 col-md-12 col-sm-12 content-side">
                <div class="property-content-side">
                    <div class="item-shorting clearfix">
                        <div class="left-column pull-left">
                            <h5>Search Reasults: <span>Showing {{count($property)}} Listings</span></h5>
                        </div>
                        <div class="right-column pull-right clearfix">

                        </div>
                    </div>
                    <div class="wrapper list">
                        <div class="deals-list-content list-item">



                            @foreach($property as $item)
                            <div class="deals-block-one">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <figure class="image">
                                            <img src="{{asset($item->property_thumbnail)}}"
                                                style="width: 300px; height: 350px" alt="">
                                        </figure>

                                        <div class="batch"><i class="icon-11"></i></div>
                                        @if($item->featured == 1)
                                        <span class="category">Featured</span>

                                        @else
                                        <span class="category">New</span>

                                        @endif
                                        <div class="buy-btn"><a href="property-details.html">For {{$item->property_status}}</a></div>
                                    </div>
                                    <div class="lower-content">
                                        <div class="title-text">
                                            <h4><a href="{{url('property/details/'.$item->id.'/'.$item->property_slug)}}">{{$item->property_name}}</a></h4>
                                        </div>
                                        <div class="price-box clearfix">
                                            <div class="price-info pull-left">
                                                <h6>Start From</h6>
                                                <h4>${{$item->lowest_price}}</h4>
                                            </div>
                                            <div class="author-box pull-right">
                                                @if($item->agent_id == Null)
                                                <figure class="author-thumb"><img src="{{ url('upload/no_image.jpg')}}" alt=""></figure>
                                                <h6>Admin</h6>
                                                @else
                                                <figure class="author-thumb"><img src="{{ !empty($item->user->photo) ?
                    
                    url('upload/agent_images/'.$item->user->photo) : url('upload/no_image.jpg')}}" alt="">
                                                    <span>{{$item->user->name}}</span>
                                                </figure>
                                                @endif

                                            </div>
                                        </div>
                                        <p>{{$item->short_descp}}</p>
                                        <ul class="more-details clearfix">
                                            <li><i class="icon-14"></i>{{$item->bedrooms}} Beds</li>
                                            <li><i class="icon-15"></i>{{$item->bathrooms}} Baths</li>
                                            <li><i class="icon-16"></i>{{$item->property_size}} Sq Ft</li>
                                        </ul>
                                        <div class="other-info-box clearfix">
                                            <div class="btn-box pull-left">
                                                <a href="{{url('property/details/'.$item->id.'/'.$item->property_slug)}}"
                                                    class="theme-btn btn-two">See Details</a>
                                            </div>
                                            <ul class="other-option pull-right clearfix">
                                                <li><a aria-label="Compare" class="action_btn" id="{{$item->id}}"
                                                        onclick="addToCompare(this.id)"><i class="icon-12"></i></a></li>
                                                <li><a aria-label="Add To Wishlist" class="action_btn" id="{{$item->id}}"
                                                        onclick="addToWishList(this.id)"><i class="icon-13"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>

                    </div>
                    <div class="pagination-wrapper">
                        <ul class="pagination clearfix">
                            <li><a href="property-list.html" class="current">1</a></li>
                            <li><a href="property-list.html">2</a></li>
                            <li><a href="property-list.html">3</a></li>
                            <li><a href="property-list.html"><i class="fas fa-angle-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- property-page-section end -->


<!-- subscribe-section -->
<section class="subscribe-section bg-color-3">
    <div class="pattern-layer" style="background-image: url(assets/images/shape/shape-2.png);"></div>
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-12 text-column">
                <div class="text">
                    <span>Subscribe</span>
                    <h2>Sign Up To Our Newsletter To Get The Latest News And Offers.</h2>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 form-column">
                <div class="form-inner">
                    <form action="contact.html" method="post" class="subscribe-form">
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Enter your email" required="">
                            <button type="submit">Subscribe Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- subscribe-section end -->

@endsection