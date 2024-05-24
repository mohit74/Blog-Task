<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {

        if(Auth::check()){
        $request->validate([

            'message' => 'required',

        ]);

        $input = $request->all();

        $input['user_id'] = Auth::user()->id;

        $comment = Comment::create($input);

        return back();
        // return response()->json(['user' => auth()->user(), 'message' => $comment->message, 'cmt' => $comment]);
    }
    return redirect()->route('signIn')->with('warning', 'Please login first');

    }

}
