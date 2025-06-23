<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatSession;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatSessionController extends Controller
{

    public function create(Request $request)
    {
        $chatSession = ChatSession::create([
            'user_id' => Auth::id(),
            'name' => 'New chat created',
        ]);

        return response()->json(['chat_session_id' => $chatSession->id]);
    }


    public function getMessages($id)
    {
        try {

            $chatSession = ChatSession::where('id', $id)->firstOrFail();
            $messages = $chatSession->messages()->orderBy('created_at')->get();

            return response()->json(['messages' => $messages]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to get messages',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function addMessage(Request $request, $id)
    {
        $request->validate([
            'sender' => 'required|string',
            'message' => 'required|string',
        ]);

        $chatSession = ChatSession::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $message = $chatSession->messages()->create([
            'sender' => $request->sender,
            'message' => $request->message,
        ]);

        return response()->json(['message' => $message]);
    }


    public function listSessions()
    {
        $sessions = ChatSession::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->get();

        return response()->json(['sessions' => $sessions]);
    }


    public function updateSessionName(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $chatSession = ChatSession::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $chatSession->name = $request->name;
        $chatSession->save();

        return response()->json(['session' => $chatSession]);
    }


    public function deleteSession($id)
    {
        \DB::beginTransaction();

        try {
            $chatSession = ChatSession::findOrFail($id);


            if ($chatSession->user_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action'
                ], 403);
            }


            $chatSession->delete();

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Session deleted successfully'
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete session',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
