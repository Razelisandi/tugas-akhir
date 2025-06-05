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

        // Simulasikan respon chatbot, di sini cuma balas echo balik pesan user
        $response = "Bot balas: " . $message;

        // Ambil chat history dari session
        $chatHistory = session('chat_history', []);

        // Tambahkan pesan user
        $chatHistory[] = [
            'sender' => 'user',
            'message' => $message,
        ];

        // Tambahkan balasan bot
        $chatHistory[] = [
            'sender' => 'bot',
            'message' => $response,
        ];

        // Simpan kembali ke session
        session(['chat_history' => $chatHistory]);

        // Redirect ke halaman chatbot dengan data terbaru
        return redirect()->route('chatbot');
    }
}
