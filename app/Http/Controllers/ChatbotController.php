<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function index()
    {
        // Contoh data chat history, biasanya dari database atau session
        $chatHistory = session('chat_history', []);

        return view('chatbot', compact('chatHistory'));
    }

    public function send(Request $request)
    {
        $message = $request->input('message');


        $response = "Bot balas: " . $message;


        $chatHistory = session('chat_history', []);


        $chatHistory[] = [
            'sender' => 'user',
            'message' => $message,
        ];


        $chatHistory[] = [
            'sender' => 'bot',
            'message' => $response,
        ];


        session(['chat_history' => $chatHistory]);


        return redirect()->route('chatbot');
    }
}
