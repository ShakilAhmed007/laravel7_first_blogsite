<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use Auth;



class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Post::orderBy('title','desc')->get();
        $posts = Post::orderBy('id','desc')->paginate(10);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //field validation
        $validateData = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);
        //handle file upload
        if($request->hasFile('cover_image')){
            //get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get file name
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get file extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //file name to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);

        }else{
            $fileNameToStore = 'no_image.jpg';
        }
        //storing data on database
        $posts = new Post;
        $posts->title = $request->title;
        $posts->body = $request->body;
        $posts->user_id = Auth::user()->id;
        $posts->cover_image = $filenameToStore;
        $posts->save();
        return redirect()->back()->with('success', 'Post submited');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        //Check for correct user

        if(!(Auth::user()->id == $post->user_id)){
            return redirect('/posts')->with('error', 'Unauthorize page');
        }
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //field validation
        $validateData = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
        //handle file upload
        if($request->hasFile('cover_image')){
            //get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get file name
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get file extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //file name to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //uploading image to local dir
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);

        }
        //storing data on database
        $posts = Post::findOrFail($id);
        $posts->title = $request->title;
        $posts->body = $request->body;
        if($request->hasFile('cover_image')){
            $posts->cover_image = $filenameToStore;
        }
        $posts->save();
        return redirect()->back()->with('success', 'Post Edited successfully!^_^');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if(!(Auth::user()->id == $post->user_id)){
            return redirect('/posts')->with('error', 'Unauthorize page');
        }
        if($post->cover_image != 'no_image.jpg'){
            //delete image from dir
            Storage::delete('public/cover_images/'.$post->cover_image);
        }

        $post->delete();
        return redirect('/posts')->with('success', 'Post Deleted successfully!^_^');
    }
}
