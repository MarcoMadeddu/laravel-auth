<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPost;
use Illuminate\Support\Str;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('user_id' , Auth::id() )->orderBy('created_at', 'desc')->paginate(5);

        return view('admin.posts.index' , compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validationRules());

        $data=$request->all();

        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($data['title'], '-');

        //set image
        if(!empty($data['path_img'])){
            $data['path_img'] = Storage::disk('public')->put('images' , $data['path_img']);
        }


        $newPost = new Post();
        $newPost->fill($data);

        $saved = $newPost->save();

        if($saved){
            Mail::to('user@test.it')->send(new NewPost($newPost));
            return redirect()->route('admin.posts.show' , $newPost->id);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show' , compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit' , compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate($this->validationRules());

        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');

        if(!empty($data['path_img'])){
            //delete prev img
            if(!empty($post->path_img)){
                Storage::disk('public')->delete($post->path_img);
            }

            //setnew img
            $data['path_img'] =Storage::disk('public')->put('images' , $data['path_img']);
        }

        $update = $post->update($data);

        if($update){
            return redirect()->route('admin.posts.show' , $post->id);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (empty($post)) {
            abort(404);
        }

        $title=$post->title;

        $deleted=$post->delete();

        if($deleted){
                    //remove image
            if(!empty($post->path_img)){
                Storage::disk('public')->delete($post->path_img);
            }
            return redirect()->route('admin.posts.index')->with('post-deleted' , $title);

        }
    }

    //validation rules

    private function validationRules()
    {
        return[
            'title' => 'required',
            'body' => 'required',
            'path_img' => 'image',
        ];
    }
}
