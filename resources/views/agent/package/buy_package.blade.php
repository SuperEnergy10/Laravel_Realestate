@extends('agent.agent_dashboard')
@section('agent')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <a href="{{route('agent.add.property')}}" class="btn btn-inverse-info">Add Property</a>

        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center mb-3 mt-4">Choose a plan</h3>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 stretch-card grid-margin grid-margin-md-0">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="text-center mt-3 mb-4">Basic</h4>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award text-primary icon-xxl d-block mx-auto my-3">
                                            <circle cx="12" cy="8" r="7"></circle>
                                            <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                                        </svg>
                                        <h1 class="text-center">$0</h1>
                                        <p class="text-muted text-center mb-4 fw-light">Limited</p>
                                        <h5 class="text-primary text-center mb-4">Up to 1 Property</h5>
                                        <table class="mx-auto">
                                            <tbody>
                                                <tr>
                                                    <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2">
                                                            <polyline points="20 6 9 17 4 12"></polyline>
                                                        </svg></td>
                                                    <td>
                                                        <p>Up to 1 Property</p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x icon-md text-danger me-2">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg></td>
                                                    <td>
                                                        <p class="text-muted">Premium apps</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="d-grid">
                                            <button class="btn btn-primary mt-4">Start Now</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 stretch-card grid-margin grid-margin-md-0">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="text-center mt-3 mb-4">Business</h4>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-gift text-success icon-xxl d-block mx-auto my-3">
                                            <polyline points="20 12 20 22 4 22 4 12"></polyline>
                                            <rect x="2" y="7" width="20" height="5"></rect>
                                            <line x1="12" y1="22" x2="12" y2="7"></line>
                                            <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path>
                                            <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
                                        </svg>
                                        <h1 class="text-center">$20</h1>
                                        <p class="text-muted text-center mb-4 fw-light">Unlimited per month</p>
                                        <h5 class="text-success text-center mb-4">Up to 3 Property</h5>
                                        <table class="mx-auto">
                                            <tbody>
                                                <tr>
                                                    <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2">
                                                            <polyline points="20 6 9 17 4 12"></polyline>
                                                        </svg></td>
                                                    <td>
                                                        <p>Up to 3 Property</p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x icon-md text-danger me-2">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg></td>
                                                    <td>
                                                        <p class="text-muted">Premium Support</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="d-grid">
                                            <a href="{{route('buy.business.plan')}}" class="btn btn-success mt-4">Start Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="text-center mt-3 mb-4">Professional</h4>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase text-primary icon-xxl d-block mx-auto my-3">
                                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                        </svg>
                                        <h1 class="text-center">$50</h1>
                                        <p class="text-muted text-center mb-4 fw-light">Unlimited per month</p>
                                        <h5 class="text-primary text-center mb-4">Up to 10 Property</h5>
                                        <table class="mx-auto">
                                            <tbody>
                                                <tr>
                                                    <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2">
                                                            <polyline points="20 6 9 17 4 12"></polyline>
                                                        </svg></td>
                                                    <td>
                                                        <p>Up to 10 Property</p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2">
                                                            <polyline points="20 6 9 17 4 12"></polyline>
                                                        </svg></td>
                                                    <td>
                                                        <p>Premium Support</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="d-grid">
                                            <a href="{{route('buy.professional.plan')}}" class="btn btn-primary mt-4">Start Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection