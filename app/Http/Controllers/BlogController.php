<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BlogPost::orderBy('id', 'DESC')->get();

        //return response()->json($posts);
        return $posts;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = new BlogPost;
        $post->title = $request->input('title');
        $post->author_id = $request->input('author');
        $post->content = $request->input('content');
        $post->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = BlogPost::findOrFail($id);

        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = BlogPost::findOrFail($id);

        if ($request->filled('title')) {
            $post->title = $request->input('title');
        }

        if ($request->filled('content')) {
            $post->content = $request->input('content');
        }

        $post->save();

        return response()->json([
            'success' => true
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = BlogPost::findOrFail($id)->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
