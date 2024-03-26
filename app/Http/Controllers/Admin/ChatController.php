<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $chats = Chat::getChats()->paginate(10);

        return view('admin.chat', ['chats' => $chats]);
    }

    function getMessages($senderId) 
    {
        $messages = Chat::where('sender_id', auth()->id())
        ->with(['sender','receiver'])
        ->where('receiver_id', $senderId)
        ->orWhere('sender_id', $senderId)
        ->where('receiver_id', auth()->id())
        ->orderBy('created_at', 'asc')
        ->get(); // Fetch messages

        $chats = $messages->map(function ($item) {

            $item->appendStyle = '';
            $item->messageStyle = '';
            if($item->receiver_id != 2 && $item->sender_id == 2) {
                $item->appendStyle = "margin-left:auto;flex-direction:row-reverse";
                $item->messageStyle = "background-color:var(--theme-cyan1);margin-left:auto;";
            }

            return $item;
        });


        return view('admin.chats.messages', ['messages' => $chats]);

        return response()->json(['status' => Response::HTTP_OK,'data' => $messages], Response::HTTP_OK);
    }

    public function searchChat(Request $request)
    {
        $search = $request->input('q');

        $chats = Chat::getChats($search);
    
        return view('admin.chats.chat-list', ['chats' => $chats->get(),'q' => $search]);   
    }
}
