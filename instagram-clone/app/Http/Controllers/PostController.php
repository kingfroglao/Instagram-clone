<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\FileService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Resources\AllPostsCollection;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;



class PostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = new Post;
        

        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png',
            'text' => 'required'
        ]);
        
        $post = (new FileService)->updateFile($post, $request, 'post');

        $post->user_id = auth()->user()->id;
        $post->text = $request->input('text');
        $post->save();
    }

    public function update(Request $request)
    {
        $post = Post::find($request->input('id'));

        $post->text = $request->input('text');

        $post->save();
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if (!empty($post->file)) {
            $currentFile = public_path() . $post->file;

            if (file_exists($currentFile)) {
                unlink($currentFile);
            }
        }

        $post->delete();
    }
}