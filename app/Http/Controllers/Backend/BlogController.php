<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class BlogController extends Controller
{
    //

    public function AllBlogCategory()
    {
        $category = BlogCategory::latest()->get();
        return view('backend.category.blog_category', compact('category'));
    }

    public function StoreBlogCategory(Request $request)
    {


        BlogCategory::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name))
        ]);

        $notification = [
            'message' => 'Blog Category Created Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.blog.category')->with($notification);
    }

    public function EditBlogCategory($id)
    {
        $categories = BlogCategory::findOrFail($id);
        return response()->json($categories);
    }

    public function UpdateBlogCategory(Request $request)
    {
        $cat_id = $request->cat_id;


        BlogCategory::findOrFail($cat_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name))
        ]);

        $notification = [
            'message' => 'Blog Category Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.blog.category')->with($notification);
    }

    public function DeleteBlogCategory($id)
    {


        BlogCategory::findOrFail($id)->delete();

        $notification = [
            'message' => 'Blog Category Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }


    // Blog Post

    public function AllBlogPost()
    {
        $post = BlogPost::latest()->get();
        return view('backend.post.all_post', compact('post'));
    }

    public function AddBlogPost()
    {
        $blogcat = BlogCategory::latest()->get();

        return view('backend.post.add_post', compact('blogcat'));
    }

    public function StoreBlogPost(Request $request)
    {
        // $request->validate([
        //     'state_name' => 'required|max:200',
        //     'state_image' => 'required',
        // ]);

        $img = $request->file('post_image');
        $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
        Image::make($img)->resize(370, 250)->save('upload/post/' . $make_name);
        $save_url = 'upload/post/' . $make_name;



        BlogPost::insert([
            'blogcat_id' => $request->blogcat_id,
            'user_id' => Auth::user()->id,
            'post_title' => $request->post_title,
            'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'post_tags' => $request->post_tags,
            'created_at' => Carbon::now(),
            'post_image' => $save_url
        ]);

        $notification = [
            'message' => 'Blog Post Created Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.blog.post')->with($notification);
    }

    public function EditBlogPost($id)
    {
        $post = BlogPost::findOrFail($id);
        $blogcat = BlogCategory::latest()->get();

        return view('backend.post.edit_post', compact('post', 'blogcat'));
    }

    public function UpdateBlogPost(Request $request)
    {
        $post_id = $request->id;
        $post = BlogPost::findOrFail($post_id);

        if ($request->file('post_image')) {
            // Xóa ảnh cũ nếu có
            if ($post->post_image) {
                @unlink($post->post_image);
            }

            // Lưu ảnh mới
            $img = $request->file('post_image');
            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(370, 250)->save('upload/post/' . $make_name);
            $save_url = 'upload/post/' . $make_name;

            // Cập nhật ảnh trong database
            $post->update([
                'blogcat_id' => $request->blogcat_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
                'short_descp' => $request->short_descp,
                'long_descp' => $request->long_descp,
                'post_tags' => $request->post_tags,
                'created_at' => Carbon::now(),
                'post_image' => $save_url // Cập nhật đường dẫn ảnh mới
            ]);

            $notification = [
                'message' => 'Blog Post Updated with Image Successfully',
                'alert-type' => 'success'
            ];
        } else {
            // Chỉ cập nhật tên nếu không có ảnh mới
            $post->update([
                'blogcat_id' => $request->blogcat_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
                'short_descp' => $request->short_descp,
                'long_descp' => $request->long_descp,
                'post_tags' => $request->post_tags,
                'updated_at' => Carbon::now(),

            ]);

            $notification = [
                'message' => 'Blog Post Updated without Image Successfully',
                'alert-type' => 'success'
            ];
        }

        return redirect()->route('all.blog.post')->with($notification);
    }


    public function DeleteBlogPost($id)
    {


        BlogPost::findOrFail($id)->delete();

        $notification = [
            'message' => 'Blog Post Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }


    public function BlogDetails($slug){
        $blog = BlogPost::where('post_slug', $slug)->first();
        $tags = $blog->post_tags;

        $bcategory = BlogCategory::latest()->get();
        $dpost = BlogPost::latest()->limit(3)->get();
        $tags_all = explode(',', $tags);

        return view('frontend.blog.blog_details', compact('blog', 'tags_all','bcategory', 'dpost'));
    }


    public function BlogCatList($id){
        $blog = BlogPost::where('blogcat_id', $id)->get();
        $breadcat = BlogCategory::where('id', $id)->first();
        $bcategory = BlogCategory::latest()->get();
        $dpost = BlogPost::latest()->limit(3)->get();

        return view('frontend.blog.blog_cat_list', compact('blog','breadcat','bcategory', 'dpost'));


    }
    public function BlogList(){
        $blog = BlogPost::latest()->get();
        $bcategory = BlogCategory::latest()->get();
        $dpost = BlogPost::latest()->limit(3)->get();

        return view('frontend.blog.blog_list', compact('blog','bcategory', 'dpost'));

    }

    public function StoreComment(Request $request){
        $pid = $request->post_id;

        Comment::insert([
            'user_id' => Auth::user()->id,
            'post_id' => $pid,
            'parent_id' => NULL,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now()
        ]);

        $notification = [
            'message' => 'Comment Inserted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);

    }

    public function AdminBlogComment(){
        $comment = Comment::where('parent_id', null)->latest()->get();

        return view('backend.comment.comment_all', compact('comment'));
    }

    public function AdminCommentReply($id){
        $comment = Comment::where('id', $id)->first();

        return view('backend.comment.comment_reply', compact('comment'));

    }

    public function ReplyComment(Request $request){
        $id = $request->id;
        $post_id = $request->post_id;
        $user_id = $request->user_id;


        Comment::insert([
            'user_id' => $user_id,
            'post_id' => $post_id,
            'parent_id' => $id,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now()
        ]);

        $notification = [
            'message' => 'Comment Reply Inserted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
}
