<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Listado público de posts publicados.
     */
    public function index()
    {
        return response()->json(
            Post::with('user')
                ->where('status', 'published')
                ->latest('published_at')
                ->paginate(15)
        );
    }

    /**
     * Mostrar un post.
     */
    public function show(Post $post)
    {
        return response()->json($post->load('user'));
    }

    /**
     * Crear un post.
     */
    public function store(StorePostRequest $request)
    {
        $this->authorize('create', Post::class);

        $post = $request->user()->posts()->create([
            ...$request->validated(),
            'status' => 'draft',
        ]);

        return response()->json($post, 201);
    }

    /**
     * Actualizar un post.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->validated());

        return response()->json($post);
    }

    /**
     * Eliminar un post.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json([
            'message' => 'Post eliminado.'
        ]);
    }

    /**
     * Mis posts.
     */
    public function myPosts(Request $request)
    {
        return response()->json(
            $request->user()
                ->posts()
                ->latest()
                ->paginate(15)
        );
    }
}
