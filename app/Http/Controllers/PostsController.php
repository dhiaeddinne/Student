<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use DB;


class PostsController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth' , ['except'=>['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(11);
        return view('posts.index')->with('posts',$posts);
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
        $this->validate($request,[
            'University_Name'=>'required',
            'Entry_Date'=>'required',
            'Release_Date'=>'required',
            'Advantages'=>'required',
            'cover_img'=> 'image|nullable|max:1999'
        ]);

        // Handle File Upload
        if($request->hasFile('cover_img')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_img')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_img')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('cover_img')->storeAs('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        //Create Post
        $post = new Post;
        $post->University_Name = $request->input('University_Name');
        $post->Entry_Date = $request->input('Entry_Date');
        $post->Release_Date = $request->input('Release_Date');
        $post->Advantage = $request->input('Advantages');
        $post->Drowbacks =$request->input('Drowbacks');
        $post->Tips = $request->input('Tips');
        $post->user_id = auth()->user()->id;
        $post->cover_img = $fileNameToStore;
        $post->save();
        
        return redirect('/posts')->with('success','Post Created');
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
        return view('posts.show')->with('posts', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'unauthorized page');
        }
        return view('posts.edit')->with('posts', $post);
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
        $this->validate($request,[
            'University_Name'=>'required',
            'Entry_Date'=>'required',
            'Release_Date'=>'required',
        ]);

         // Handle File Upload
         if($request->hasFile('cover_img')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_img')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_img')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('cover_img')->storeAs('public/cover_images', $fileNameToStore);
        } 

        //Create Post
        $post = Post::find($id);
        $post->University_Name = $request->input('University_Name');
        $post->Entry_Date = $request->input('Entry_Date');
        $post->Release_Date = $request->input('Release_Date');
        $post->Advantage = $request->input('Advantages');
        $post->Drowbacks =$request->input('Drowbacks');
        $post->Tips = $request->input('Tips');
        $post->user_id = auth()->user()->id;
        if($request->hasFile('cover_img')){
            $post->cover_img = $fileNameToStore;
        }
        $post->save();
        
        return redirect('/posts')->with('success','Post updated');
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
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'unauthorized page');
        }
        if($post->cover_img != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/cover_images/'.$post->cover_img);
        }
        $post->delete();
        return redirect('/posts')->with('success','Post deleted');
    }
}
