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

                        <h6 class="card-title">Comment Reply</h6>

                        <form method="POST" action="{{route('reply.comment')}}" class="forms-sample" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{$comment->id}}">
                            <input type="hidden" name="user_id" value="{{$comment->user_id}}">
                            <input type="hidden" name="post_id" value="{{$comment->post_id}}">

                            <div class="mb-3">
                                <label class="form-label">User Name:</label>
                                <code>{{$comment->user->name}}</code>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">Post Tittle:</label>
                                <code>{{$comment->post->post_title}}</code>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Subject:</label>
                                <code>{{$comment->subject}}</code>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Message:</label>
                                <code>{{$comment->message}}</code>
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input name="subject" type="text" class="form-control" id="subject">

                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <input name="message" type="text" class="form-control" id="message">

                            </div>

                            <button type="submit" class="btn btn-primary me-2">Reply Comment</button>
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