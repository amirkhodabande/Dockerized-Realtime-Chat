<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\NewMessage;
use App\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['store', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('chat');
    }

    public function indexApi()
    {
        $chats = Chat::all();
        foreach ($chats as $key => $chat) {
            if ($chats[$key]->user_id == auth()->user()->id)
                $chats[$key]->user_id = "You";
            else
                $chats[$key]->user_id = User::find($chats[$key]->user_id)->name;
        }
        return response()->json(
            $chats,
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $chat = Chat::create(
            [
                'user_id' => $user->id,
                'message' => $request->message,
                'time' => $request->time,
            ]
        );
        broadcast(new NewMessage($request->message, $user))->toOthers();
        return response()->json($chat, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();
        event(new NewMessage("Lst", $user));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
