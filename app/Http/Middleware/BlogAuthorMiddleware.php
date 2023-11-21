<?php

namespace App\Http\Middleware;

use App\Models\BlogAuthor;
use App\Models\BlogPost;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogAuthorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $author = BlogAuthor::where(['auth_key' => $request->header('Authorization')])->first();
        if (! $author) {
            return response()->json([
                'status' => 'unauthorized',
                'message' => 'You are not authorized.',
            ], 401);
        }

        if ($author->id != BlogPost::where(['id' => $request->route('id')])->first()->author_id) {
            return response()->json([
                'status' => 'forbidden',
                'message' => 'You dont have permission to do that.',
            ], 403);
        }

        return $next($request);
    }
}
