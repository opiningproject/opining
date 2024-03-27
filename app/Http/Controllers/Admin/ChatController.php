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
        return view('admin.chat');
    }

    function getMessages($senderId) 
    {
        $pageNumber = request()->input('page', 1);

        $messages = Chat::where('sender_id', auth()->id())
        ->with(['sender','receiver'])
        ->where('receiver_id', $senderId)
        ->orWhere('sender_id', $senderId)
        ->where('receiver_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->paginate(8, ['*'], 'page', $pageNumber); // Fetch messages

        $messages->getCollection()->transform(function ($item) {

            $item->appendStyle = '';
            $item->messageStyle = '';
            if($item->receiver_id != 2 && $item->sender_id == 2) {
                $item->appendStyle = "margin-left:auto;flex-direction:row-reverse";
                $item->messageStyle = "background-color:var(--theme-cyan1);margin-left:auto;";
            }

            return $item;
        });

        $chats = $messages->reverse();

        return view('admin.chats.messages', ['messages' => $chats]);
    }

    public function searchChat(Request $request)
    {
        $search = $request->input('q');

        $chats = Chat::with(['sender','receiver'])->distinct()->whereHas('receiver', function($query) use ($search) {
            $query->where('first_name', 'like', "%$search%");
        })->get();
        $chats = $chats->unique('receiver_id');

    
        return view('admin.chats.chat-list', ['chats' => $chats,'q' => $search]);   
    }

    function getChatUsersList() 
    {

        $pageNumber = request()->input('page', 1);

        $chats = Chat::with(['sender','receiver'])->distinct()->paginate(9, ['*'], 'page', $pageNumber);
        $chats = $chats->unique('receiver_id');

        return view('admin.chats.chat-list', ['chats' => $chats,'q' => '']);
    }
}
