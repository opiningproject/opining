<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Dish;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $userId = request()->input('user_id');
        $adminId = auth()->id();

        $messages = Chat::with('sender')
            ->with('receiver')->where(function ($query) use ($adminId, $userId) {
            $query->where('sender_id', $adminId)
                  ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($adminId, $userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $adminId);
        })->orderBy('created_at', 'asc')
            ->paginate(50, ['*'], 'page', $pageNumber); // Fetch messages
        $messages->getCollection()->transform(function ($item) {

            $item->appendStyle = '';
            $item->messageStyle = '';
            if($item->receiver_id != 1 && $item->sender_id == 1) {
                $item->appendStyle = "margin-left:auto;flex-direction:row-reverse";
                $item->messageStyle = "background-color:var(--theme-cyan1);margin-left:auto;";
            }

            return $item;
        });
        //message read logic
         Chat::where('sender_id', $userId)->orWhere('receiver_id', $userId)->update(['is_read' => "1"]);
        $chats = $messages;

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

        $chats = Chat::select('sender_id', 'receiver_id','created_at')
            ->orderBy('created_at', 'desc')
            ->distinct()
                ->paginate(9, ['*'], 'page', $pageNumber)
                ->flatMap(function ($chat) {
                    return [$chat->sender_id, $chat->receiver_id];
                })
                ->unique()
                ->map(function ($userId) {
                    Log::info('UUUU',[$userId]);
                    $user = User::find($userId);
                    $unreadCount = Chat::where(function ($query) use ($userId) {
                        $query->where('sender_id', $userId)
                            ->where('is_read', "0");
                    })->count();

                    // Add unreadCount attribute to the user
                    $user->unreadCount = $unreadCount;

                    $user->chats = Chat::where('sender_id', $userId)->with(['sender','receiver'])
                        ->orWhere('receiver_id', $userId)
                        ->latest()->first();
                    return $user;
                });

        return view('admin.chats.chat-list', ['chats' => $chats,'q' => '']);
    }

    public function storeMessage(Request $request)
    {
        $storeChat = new Chat();
        $storeChat->sender_id = $request->sender_id;
        $storeChat->receiver_id = $request->receiver_id;
        $storeChat->message = $request->message;
        $storeChat->attachment = $request->fileName;
        $storeChat->save();
        $storeChat->createdAt = $storeChat->created_at->format('h:m a');
        $storeChat->userImage  = auth()->user()->image ? auth()->user()->image : asset('images/user-profile.png');
        return \response()->json([
            "status"=>"200",
            'data' =>$storeChat
        ]);
    }


    public function storeAttachment(Request $request)
    {
        $attachmentName = "";
        if ($request->has('file')) {
            $imageName = uploadAttachmentToBucket($request, '/chat');
            $attachmentName = $imageName;
        }
        return \response()->json([
            "status" => "200",
            'imageName' => $attachmentName
        ]);
    }
}
