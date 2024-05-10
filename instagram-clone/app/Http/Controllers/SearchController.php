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

class SearchController extends Controller
{
    public function search(Request $request)
    {
        return Inertia::render('Profile/Search', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    public function users(Request $request)
    {
        $name = $request->input('name');

        $user = User::where('name', $name)->first();

        // $users = User::find($request->name); 
        if ($user) {
            return Redirect::route('users.show', ['id' => $user->_id]);
        } else {
            return Redirect::back()->withErrors(['msg' => 'User not found'])->withInput();
        }
            
    }

}
