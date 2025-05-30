@extends('admin.admin_dashboard')
@section('admin')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary"
                data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add Category
            </button>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Blog Category All</h6>

                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Blog Category Name</th>
                                    <th>Blog Category Slug</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($category as $key => $item)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->category_name}}</td>
                                    <td>{{$item->category_slug}}</td>
                                    <td>
                                    @if(Auth::user()->can('post.edit'))
                                        <button type="button" class="btn btn-warning"
                                            data-bs-toggle="modal" data-bs-target="#catedit"
                                            id="{{$item->id}}"
                                            onclick="categoryEdit(this.id)">
                                            Edit
                                        </button>

                                        @endif

                                        @if(Auth::user()->can('post.delete'))
                                        <a href="{{route('delete.blog.category', $item->id)}}" class="btn btn-inverse-danger" id="delete">Delete</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('store.blog.category')}}" class="forms-sample">
                    @csrf

                    <div class="mb-3 form-group">
                        <label for="category_name" class="form-label">Blog Category Name</label>
                        <input name="category_name" type="text" class="form-control" id="category_name">

                    </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>

            </form>

        </div>
    </div>
</div>

<!-- edit category modal -->
<div class="modal fade" id="catedit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('update.blog.category')}}" class="forms-sample">
                    @csrf

                    <input type="hidden" name="cat_id" id="cat_id">

                    <div class="mb-3 form-group">
                        <label for="cat" class="form-label">Blog Category Name</label>
                        <input name="category_name"  type="text" class="form-control" id="cat">

                    </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>

            </form>

        </div>
    </div>
</div>


<script>
function categoryEdit(id){
    $.ajax({
        type: 'GET',
        url: '/edit/blog/category/'+id,
        dataType: 'json',

        success: function(data){
            // console.log(data);
            $('#cat').val(data.category_name);
            $('#cat_id').val(data.id);
        }
    })
}


</script>
@endsection