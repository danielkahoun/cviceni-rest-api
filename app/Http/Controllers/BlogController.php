<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/blog",
     *     operationId="index",
     *     tags={"Blog"},
     *     summary="Get list of posts",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     * )
     */
    public function index()
    {
        $posts = BlogPost::orderBy('id', 'DESC')->get();

        return $posts;
    }

    /**
     * @OA\Post(
     *     path="/api/blog",
     *     operationId="store",
     *     tags={"Blog"},
     *     summary="Store a new post",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="title", type="string", example="New Title"),
     *                 @OA\Property(property="content", type="string", example="New Content"),
     *                 @OA\Property(property="author_id", type="integer", example=1),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/blog/{id}",
     *     operationId="show",
     *     tags={"Blog"},
     *     summary="Show the specified post",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the specified post",
     *         required=true,
     *         in="path"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $post = BlogPost::findOrFail($id);

        return $post;
    }

    /**
     * @OA\Patch(
     *     path="/api/blog/{id}",
     *     operationId="update",
     *     tags={"Blog"},
     *     summary="Update the specified post",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the specified post",
     *         required=true,
     *         in="path"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="title", type="string", example="Updated Title"),
     *                 @OA\Property(property="content", type="string", example="Updated Content")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=400, description="Bad request"),
     *     security={
     *         {"Authorization": {}}
     *     }
     * )
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
     * @OA\Delete(
     *     path="/api/blog/{id}",
     *     operationId="destroy",
     *     tags={"Blog"},
     *     summary="Remove the specified post",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the specified post",
     *         required=true,
     *         in="path"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=400, description="Bad request"),
     *     security={
     *         {"Authorization": {}}
     *     }
     * )
     */
    public function destroy(string $id)
    {
        $post = BlogPost::findOrFail($id)->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
