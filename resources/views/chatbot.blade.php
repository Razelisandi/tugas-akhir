<x-app-layout>
    <div class="flex min-h-[calc(100vh-4.5rem)] bg-gray-100">
        <aside class="w-64 bg-white shadow-md flex flex-col" style="height: calc(100vh - 4.5rem);">
            <div class="px-6 py-4 border-b border-gray-200 font-semibold text-lg">
                CHATBOT
            </div>
            <button id="newChatBtn"
                class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 focus:outline-none border-b border-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                    <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                </svg>
                New Chat
            </button>
            <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-1" id="chatSessionsList"
                style="max-height: calc(100vh - 9rem);">

            </nav>
        </aside>

        <div class="flex-1 flex flex-col bg-gray-50 relative" style="height: calc(100vh - 4.5rem);">
            <div class="flex-1 p-6 overflow-y-auto" style="min-height: 0;">
                <div id="chat-main" class="space-y-4"></div>
<div id="chat-main-container" class="h-full relative">
    <div id="chat-placeholder"
        class="absolute inset-0 flex items-center justify-center text-gray-400 text-lg font-semibold">
        Hello, what's in your mind?
    </div>

    <div id="chat-main" class="space-y-4 px-4 pb-4 overflow-y-auto h-full"></div>
</div>
            </div>

            <form id="chat-form" class="p-4 bg-white border-t border-gray-300 flex items-center space-x-3">
                <input id="message" type="text" placeholder="Ask chatbot"
                    class="flex-1 rounded-full border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    autocomplete="off" />
                <button type="submit"
                    class="bg-black text-white rounded-full p-2 hover:bg-gray-800 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentChatSessionId = null;
            let chatSessions = [];
            let isWaitingForResponse = false;

            // Fungsi untuk membuat bubble chat
            function createMessageBubble(sender, message) {
                if (sender === 'user') {
                    return `<div class="flex justify-end">
                                <div class="bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm break-words whitespace-pre-wrap max-w-full sm:max-w-2xl overflow-hidden">${message}</div>
                            </div>`;
                } else {
                    return `<div class="flex justify-start">
                                <div class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm break-words whitespace-pre-wrap max-w-full sm:max-w-2xl overflow-hidden">${message}</div>
                            </div>`;
                }
            }

            // Fungsi untuk scroll ke bawah
            function scrollToBottom() {
                const main = document.getElementById('chat-main');
                setTimeout(() => {
                    main.scrollTop = main.scrollHeight;
                }, 100);
            }

            // Fungsi untuk menampilkan pesan loading
            function showLoadingIndicator() {
                const main = document.getElementById('chat-main');
                main.innerHTML += `<div class="flex justify-start" id="loading-indicator">
                                    <div class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm">
                                        <div class="flex space-x-2">
                                            <div class="w-2 h-2 rounded-full bg-gray-500 animate-bounce"></div>
                                            <div class="w-2 h-2 rounded-full bg-gray-500 animate-bounce" style="animation-delay: 0.2s"></div>
                                            <div class="w-2 h-2 rounded-full bg-gray-500 animate-bounce" style="animation-delay: 0.4s"></div>
                                        </div>
                                    </div>
                                </div>`;
                scrollToBottom();
            }

            // Fungsi untuk menghilangkan pesan loading
            function hideLoadingIndicator() {
                const indicator = document.getElementById('loading-indicator');
                if (indicator) {
                    indicator.remove();
                }
            }

            // Fungsi untuk mengosongkan chat
function clearChat() {
    document.getElementById('chat-main').innerHTML = '';
    // Show placeholder when chat is cleared
    const placeholder = document.getElementById("chat-placeholder");
    if (placeholder) {
        placeholder.style.display = 'flex';
    }
}

            // Event listener untuk form chat
document.getElementById("chat-form").addEventListener("submit", async function(e) {
    e.preventDefault();

    if (isWaitingForResponse) return;

    const messageInput = document.getElementById("message");
    const userMessage = messageInput.value.trim();

    if (!userMessage) return;

    // Hide placeholder when user sends a message
    const placeholder = document.getElementById("chat-placeholder");
    if (placeholder) {
        placeholder.style.display = 'none';
    }

    const main = document.getElementById("chat-main");
    main.innerHTML += createMessageBubble('user', userMessage);

                // Tampilkan loading indicator
                showLoadingIndicator();
                isWaitingForResponse = true;
                messageInput.disabled = true;

                try {
                    // Kirim pesan ke backend Laravel
                    const saveRes = await fetch(`/chat-sessions/${currentChatSessionId}/messages`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: userMessage,
                            sender: 'user'
                        })
                    });

                    // Kirim ke Flask chatbot
                    const botRes = await fetch("http://127.0.0.1:5000/chat", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            message: userMessage
                        })
                    });

                    if (!botRes.ok) {
                        throw new Error("Gagal mengambil response dari chatbot");
                    }

                    const botData = await botRes.json();
                    let botResponse = botData.response;

                    // Jika ada error dalam response
                    if (botResponse.includes("Terjadi kesalahan:")) {
                        botResponse =
                            "Maaf, aku sedang mengalami kesalahan teknis. Coba tanyakan hal lain atau coba lagi nanti ya!";
                    }

                    // Tampilkan response dari chatbot
                    hideLoadingIndicator();
                    main.innerHTML += createMessageBubble('bot', botResponse);

                    if (!currentChatSessionId) {
                        const sessionRes = await fetch('/chat-sessions', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        const sessionData = await sessionRes.json();
                        currentChatSessionId = sessionData.chat_session_id;

                        // Update session name di backend
                        await fetch(`/chat-sessions/${currentChatSessionId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                name: `Chat ${chatSessions.length + 1}`
                            })
                        });

                        chatSessions.push({
                            id: currentChatSessionId,
                            name: `Chat ${chatSessions.length + 1}`
                        });

                        renderChatSessions();

                        // Tandai session ini sebagai aktif
                        document.querySelectorAll('#chatSessionsList button').forEach(btn => {
                            btn.classList.remove('bg-gray-300', 'font-bold');
                            if (btn.dataset.sessionId == currentChatSessionId) {
                                btn.classList.add('bg-gray-300', 'font-bold');
                            }
                        });
                    }


                    // Simpan response bot ke database
                    await fetch(`/chat-sessions/${currentChatSessionId}/messages`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: botResponse,
                            sender: 'bot'
                        })
                    });

                } catch (error) {
                    console.error("Terjadi kesalahan:", error);
                    hideLoadingIndicator();
                    main.innerHTML += createMessageBubble('bot',
                        "Maaf, aku sedang tidak bisa merespons. Coba lagi nanti ya!");
                } finally {
                    isWaitingForResponse = false;
                    messageInput.disabled = false;
                    messageInput.value = "";
                    messageInput.focus();
                    scrollToBottom();
                }
            });

function renderChatSessions() {
    const list = document.getElementById('chatSessionsList');
    list.innerHTML = '';
    chatSessions.forEach((session, index) => {
        const container = document.createElement('div');
        container.className =
            'relative flex items-center justify-between px-2 py-1 rounded hover:bg-gray-200';

        const sessionButton = document.createElement('button');
        sessionButton.textContent = session.name || `Chat ${index + 1}`;
        sessionButton.className = 'flex-1 text-left px-4 py-2 rounded focus:outline-none';
        sessionButton.dataset.sessionId = session.id;

        // Add active class if this session is the current active session
        if (session.id === currentChatSessionId) {
            sessionButton.classList.add('bg-gray-300', 'font-bold');
        }

        sessionButton.addEventListener('click', () => {
            if (currentChatSessionId !== session.id) {
                loadChatSession(session.id);
            }
            // Update active button styles
            document.querySelectorAll('#chatSessionsList button').forEach(btn => {
                btn.classList.remove('bg-gray-300', 'font-bold');
            });
            sessionButton.classList.add('bg-gray-300', 'font-bold');
        });

        const menuButton = document.createElement('button');
        menuButton.innerHTML = '&#x22EE;'; // Vertical ellipsis
        menuButton.className =
            'px-2 text-gray-600 hover:text-gray-900 focus:outline-none relative';
        menuButton.title = 'Options';

        const menu = document.createElement('div');
        menu.className =
            'absolute right-0 mt-2 w-24 bg-white border border-gray-300 rounded shadow-lg hidden flex-col z-10';
        menu.style.top = '100%';

        const editOption = document.createElement('button');
        editOption.textContent = 'Edit';
        editOption.className = 'px-4 py-2 text-left hover:bg-gray-100 focus:outline-none';
        editOption.addEventListener('click', async (e) => {
            e.stopPropagation();
            const newName = prompt('Enter new chat session name:', session.name);
            if (newName && newName.trim() !== '') {
                try {
                    const res = await fetch(`/chat-sessions/${session.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            name: newName.trim()
                        })
                    });
                    if (res.ok) {
                        session.name = newName.trim();
                        renderChatSessions();
                    } else {
                        alert('Failed to update session name.');
                    }
                } catch (error) {
                    alert('Error updating session name.');
                }
            }
            menu.classList.add('hidden');
        });

        const deleteOption = document.createElement('button');
        deleteOption.textContent = 'Delete';
        deleteOption.className =
            'px-4 py-2 text-left hover:bg-gray-100 focus:outline-none text-red-600';
        deleteOption.addEventListener('click', async (e) => {
            e.stopPropagation();
            if (confirm('Are you sure you want to delete this chat session?')) {
                try {
                    const res = await fetch(`/chat-sessions/${session.id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'include' // Untuk mengirim session cookie
                    });

                    const data = await res.json();

                    if (!res.ok) {
                        throw new Error(data.message || 'Failed to delete session');
                    }

                    // Update UI
                    chatSessions = chatSessions.filter(s => s.id !== session.id);
                    if (currentChatSessionId === session.id) {
                        if (chatSessions.length > 0) {
                            loadChatSession(chatSessions[0].id);
                        } else {
                            clearChat();
                            currentChatSessionId = null;
                        }
                    }
                    renderChatSessions();

                } catch (error) {
                    console.error('Delete error:', error);
                    alert(error.message);
                }
            }
            menu.classList.add('hidden');
        });

        menu.appendChild(editOption);
        menu.appendChild(deleteOption);

        menuButton.addEventListener('click', (e) => {
            e.stopPropagation();
            const isHidden = menu.classList.contains('hidden');
            document.querySelectorAll('#chatSessionsList div > div:last-child > div')
                .forEach(m => m.classList.add('hidden'));
            if (isHidden) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
            }
        });

        document.addEventListener('click', () => {
            menu.classList.add('hidden');
        });

        container.appendChild(sessionButton);
        container.appendChild(menuButton);
        container.appendChild(menu);
        list.appendChild(container);
    });
}

            // Fungsi untuk load chat session messages
async function loadChatSession(sessionId) {
    try {
        const res = await fetch(`/chat-sessions/${sessionId}/messages`);
        if (res.ok) {
            const data = await res.json();
            currentChatSessionId = sessionId;
            clearChat();
            if (data.messages.length === 0) {
                // Show placeholder if no messages
                const placeholder = document.getElementById("chat-placeholder");
                if (placeholder) {
                    placeholder.style.display = 'flex';
                }
            } else {
                const placeholder = document.getElementById("chat-placeholder");
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
                data.messages.forEach(msg => {
                    const bubble = createMessageBubble(msg.sender, msg.message);
                    document.getElementById('chat-main').innerHTML += bubble;
                });
            }
            scrollToBottom();
            // Update session list UI to highlight active session
            renderChatSessions();
        }
    } catch (error) {
        console.error('Gagal memuat sesi chat:', error);
    }
}

            // Fungsi untuk fetch all chat sessions
            async function fetchChatSessions() {
                try {
                    const res = await fetch('/chat-sessions');
                    if (res.ok) {
                        const data = await res.json();
                        chatSessions = data.sessions;
                        renderChatSessions();
                        if (chatSessions.length > 0) {
                            // Find session named "Jurusan"
                            const jurusanSession = chatSessions.find(session => session.name === "Jurusan");
                            if (jurusanSession) {
                                await loadChatSession(jurusanSession.id);
                            } else {
                                await loadChatSession(chatSessions[0].id);
                            }
                        }
                    }
                } catch (error) {
                    console.error('Gagal mengambil sesi chat:', error);
                }
            }

            // Event listener untuk tombol New Chat
            document.getElementById('newChatBtn').addEventListener('click', async () => {
                try {
                    const res = await fetch('/chat-sessions', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    if (res.ok) {
                        const data = await res.json();
                        // Add new session to chatSessions array with incremented name
                        const newSessionId = data.chat_session_id;
                        const newSessionName = `Chat ${chatSessions.length + 1}`;
                        // Update session name in backend
                        await fetch(`/chat-sessions/${newSessionId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                name: newSessionName
                            })
                        });
                        // Add to local array and re-render
                        chatSessions.push({
                            id: newSessionId,
                            name: newSessionName
                        });
                        renderChatSessions();
                        loadChatSession(newSessionId);
                    }
                } catch (error) {
                    console.error('Gagal membuat sesi chat baru:', error);
                }
            });

            // Inisialisasi
            async function initialize() {
                await fetchChatSessions();
            }



            initialize();
        });
    </script>
</x-app-layout>
