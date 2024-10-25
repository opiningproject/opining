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
use App\Events\MessageEvent;

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

    /**
     * @param $senderId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
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
            })->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page', $pageNumber); // Fetch messages
        $pageCount = $messages->lastPage();
        $messages->pageCount = $pageCount;

        $messages->getCollection()->transform(function ($item) {

            $item->appendStyle = '';
            $item->messageStyle = '';
            $item->messageClass = "leftChat";
            $backgroundColor = "#DBDBDB";
            if ($item->receiver_id != getAdminUser()->id && $item->sender_id == getAdminUser()->id) {
                $item->appendStyle = "margin-left:auto;flex-direction:row-reverse";
                $item->messageStyle = "background-color:var(--theme-cyan1);margin-left:auto;";
                $item->messageClass = "rightChat";
            } else {
                $item->messageStyle = "background-color:".$backgroundColor;
            }

            return $item;
        });
        //message read logic
        Chat::where('sender_id', $userId)->orWhere('receiver_id', $userId)->update(['is_read' => "1"]);
        $chats = $messages->reverse();
        $chats = $chats->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('d-M-Y');
        });
        $unreadCount = getUnreadChatCount();
        return view('admin.chats.messages', ['messages' => $chats, "pageCount" => $pageCount, "unreadCount" => $unreadCount]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function searchChat(Request $request)
    {
        $search = $request->input('q');
        $chats = Chat::select('sender_id', 'receiver_id', 'created_at')
            ->distinct()
            ->whereHas('sender', function ($query) use ($search) {
                $query->where('first_name', 'like', "%$search%");
                $query->orWhere('last_name', 'like', "%$search%");
            })
            ->get()
            ->flatMap(function ($chat) {
                return [$chat->sender_id];
            })
            ->unique()
            ->map(function ($userId) {
                Log::info('UUUU', [$userId]);
                $user = User::find($userId);

                $user->chats = Chat::where('sender_id', $userId)->with(['sender','receiver'])
                    ->orWhere('receiver_id', $userId)
                    ->latest()->first();
                return $user;
            });
        return view('admin.chats.chat-list', ['chats' => $chats, 'q' => $search]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    function getChatUsersList()
    {

        $pageNumber = request()->input('page', 1);

        $chats = Chat::select('sender_id', 'receiver_id', 'created_at')
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->get()
            ->flatMap(function ($chat) {
                return [$chat->sender_id, $chat->receiver_id];
            })
            ->unique()
            ->map(function ($userId) {
                Log::info('UUUU', [$userId]);
                $user = User::find($userId);
                if ($user != null) {
                    $unreadCount = Chat::where(function ($query) use ($userId) {
                        $query->where('sender_id', $userId)
                            ->where('is_read', "0");
                    })->count();
                    if ($unreadCount > 0) {
                        $user->unreadCount = $unreadCount;
                    }
                    // Add unreadCount attribute to the user
                    $user->unreadCount = $unreadCount;

                        $user->chats = Chat::where('sender_id', $userId)->with(['sender', 'receiver'])
                            ->orWhere('receiver_id', $userId)
                            ->latest()->first();
                        return $user;
                    }
                });

        return view('admin.chats.chat-list', ['chats' => $chats,'q' => '']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeMessage(Request $request)
    {
        $storeChat = new Chat();
        $storeChat->sender_id = $request->sender_id;
        $storeChat->receiver_id = $request->receiver_id;
        $storeChat->message = $request->message;
        $storeChat->is_read = "1";
        $storeChat->attachment = $request->fileName;
        if ($storeChat->save()) {
            $storeChat->createdAt = date('h:i A', strtotime($storeChat->created_at));
            $storeChat->timestamp = strtotime($storeChat->created_at) * 1000;
            $storeChat->userImage = auth()->user()->image ? auth()->user()->image : asset('images/user-profile.png');
            $storeChat->socketId = $storeChat->receiver ? $storeChat->receiver->socket_id : null;
            MessageEvent::dispatch($storeChat, $storeChat->userImage, $storeChat->createdAt, 0);
        }
        return \response()->json([
            "status" => "200",
            'data' => $storeChat
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
