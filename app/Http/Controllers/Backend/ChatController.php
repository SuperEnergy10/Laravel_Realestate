<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    //
    public function SendMsg(Request $request){
        $request->validate([
            'msg' => 'required'
        ]);

        ChatMessage::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $request->receiver_id,
            'msg' => $request->msg,
            'created_at' => Carbon::now()
        ]);

        return response()->json(['message' => 'Message Send Successfull']);
    }

    // chat all

    public function GetAllUser(){
        {
            $chats = ChatMessage::orderBy('id', 'DESC')
                ->where(function($query) {
                    $query->where('sender_id', auth()->id())
                          ->orWhere('receiver_id', auth()->id());
                })
                ->get();

            $users = $chats->flatMap(function($chat){
                if($chat->sender_id === auth()->id()){
                    return [$chat->sender, $chat->receiver];
                }

                return [$chat->receiver, $chat->sender];
            })->unique();    
        
            return $users;
        }
    }

    
    
    public function UserMsgById($userId){
        $user = User::find($userId);

        if($user){
            $messages = ChatMessage::where(function($q) use ($userId){
                $q->where('sender_id', auth()->id());
                $q->where('receiver_id', $userId);
            })->orWhere(function($q) use ($userId){
                $q->where('sender_id', $userId);
                $q->where('receiver_id', auth()->id());

            })->with('user')->get();

            return response()->json([
                'user' => $user,
                'messages' => $messages
            ]);
        }else{
            abort(404);
        }
    }

    public function AgentLiveChat(){
        return view('agent.message.live_chat');
    }
}
