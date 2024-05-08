<?php

namespace App\Http\Controllers\User;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Dish;
use Auth;
use Illuminate\Support\Facades\Log;

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
    public function index()
    {
        $userData = User::find(auth()->user()->id);
        return view('user.chat', compact('userData'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    function getMessages()
    {
        $pageNumber = request()->input('page', 1);
        $userId = auth()->id();
        $adminId = getAdminUser()->id;
        $messages = Chat::with('sender')
            ->with('receiver')->where(function ($query) use ($adminId, $userId) {
                $query->where('sender_id', $adminId)
                    ->where('receiver_id', $userId);
            })->orWhere(function ($query) use ($adminId, $userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $adminId);
            })->orderBy('created_at', 'asc')
            ->paginate(10, ['*'], 'page', $pageNumber); // Fetch messages

        $messages->getCollection()->transform(function ($item) {

            $item->appendStyle = '';
            $item->messageStyle = '';

            if ($item->receiver_id != auth()->id() && $item->sender_id == auth()->id()) {
                $item->appendStyle = "margin-left:auto;flex-direction:row-reverse";
                $item->messageStyle = "background-color:var(--theme-cyan1);margin-left:auto;";
            } else {
                $item->appendStyle = "margin-left:inherit;flex-direction:row";
                $item->messageStyle = "background-color:var(--theme-chat-box);margin-left:inherit;";
            }
            return $item;
        });
//        $chats = $messages->reverse();
        $chats = $messages;
        return view('user.chats.messages', ['messages' => $chats]);
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
        $storeChat->attachment = $request->fileName;
        if($storeChat->save()) {
            $storeChat->createdAt = date('h:i A', strtotime($storeChat->created_at));
            $storeChat->userImage = auth()->user()->image ? auth()->user()->image : asset('images/user-profile.png');
            $unreadCount = Chat::where(function ($query) use ($storeChat) {
                $query->where('sender_id', $storeChat->sender_id)
                    ->where('is_read', "0");
            })->count();
            MessageEvent::dispatch($storeChat, $storeChat->userImage, $storeChat->createdAt, $unreadCount);
//            MessageEvent::dispatch($storeChat, $storeChat->userImage, $storeChat->createdAt);
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
