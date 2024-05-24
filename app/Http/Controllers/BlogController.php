<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\Like;
use Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shareButtons = \Share::page(
            'http://localhost:8000',
            'Your share text comes here',
        )
        ->facebook()
        ->twitter()
        ->linkedin()
        ->telegram()
        ->whatsapp()        
        ->reddit();

        $blogs = Blog::latest()->paginate(5);
        return view('blog.index', compact('blogs', 'shareButtons'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $this->validate($request, [
            'title' => 'required|min:3',
            'description' => 'required|min:5',
            'image' => 'nullable|mimes:jpeg,jpg,png'
            ]);
            $data = $request->except('_token', 'image');

            if($request->hasfile('image'))
            {
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('blog_images'), $imageName);
                $data['image'] = $imageName;
            }
            $data['user_id'] = 1;
            // Create a new blog blog
            Blog::create($data);
            return redirect()->route('blogs.index')->with('success', 'Blog blog created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shareButtons = \Share::page(
            'http://localhost:8000',
            'Your share text comes here',
        )
        ->facebook()
        ->twitter()
        ->linkedin()
        ->telegram()
        ->whatsapp()        
        ->reddit();

        $blog = Blog::where('title', $title)->first();
        return view('blog.view', compact('shareButtons','blog'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::find($id);
        return view('blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'title' => 'required|min:3|unique:blogs',
            'description' => 'required|min:5',
            'image' => 'nullable|mimes:jpeg,jpg,png'
            ]);
            $data = $request->except('_token', '_method', 'image');
            $blog = Blog::find($id);
            if($request->hasfile('image'))
            {
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('blog_images'), $imageName);
                $data['image'] = $imageName;
            }
            
            $blog->update($data);
            return redirect()->route('blogs.index')->with('success', 'Blog blog updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::find($id);
        $blog->delete();
        return response()->json(['message' => 'Blog deleted successfully'], 200);
        // return redirect()->route('blogs.index')->with('success', 'Blog blog deleted successfully');
    }

    public function like($id)
    {
        
        $blog = Blog::find($id);

        $like = Like::where(['user_id' =>  Auth::user()->id,'blog_id' => $id])->first();
        $Unlike = Like::where(['user_id' =>  Auth::user()->id, 'blog_id' => $id, 'like' => 0])->first();

        if ($like) {
            if ($Unlike) {
                $like->update(['like' => 1]);
                return response()->json(['status' => true,'message'=>'liked', 'data' => $like]);
            }
            else {
                $like->update(['like' => 0]);
                return response()->json(['status' => true,'message'=>'dislike', 'data' => $like]);
            }
        }
        else {
            $join = new Like;
            $join->user_id = Auth::user()->id;
            $join->blog_id = $blog->id;
            $join->like = 1;
            $join->save();
            return response()->json(['status' => true, 'message'=>'like', 'data' => $join]);
        }

    }

}
