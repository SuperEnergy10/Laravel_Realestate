@extends('admin.admin_dashboard')

@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <a href="{{route('export')}}" class="btn btn-inverse-danger">Download Xlsx File</a>
        </ol>
    </nav>

    <div class="row profile-body">

        <!-- middle wrapper start -->
        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Import Permission</h6>

                        <form id="myForm" method="POST" action="{{route('import')}}" class="forms-sample" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3 form-group">
                                <label class="form-label">Xlsx File Import</label>
                                <input name="import_file" type="file" class="form-control">

                            </div>

                            <button type="submit" class="btn btn-inverse-warning me-2">Upload</button>
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