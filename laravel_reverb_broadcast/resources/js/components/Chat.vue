<template>
    <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-xl sm:mx-auto">
            <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
                <!-- Chat Header -->
                <div class="flex items-center space-x-4 mb-6">
                    <div class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center">
                        <span class="text-white text-xl font-bold">{{ username.charAt(0) }}</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Laravel Realtime Chat</h1>
                        <p class="text-sm text-gray-500">Bağlı: {{ username }}</p>
                    </div>
                </div>
                
                <!-- Messages Container -->
                <div class="h-[400px] overflow-y-auto p-4 space-y-4 bg-gray-50 rounded-lg mb-4" ref="messages">
                    <template v-for="(message, index) in messages" :key="index">
                        <div :class="`flex ${message.isCurrentUser ? 'justify-end' : 'justify-start'}`">
                            <div :class="`max-w-xs lg:max-w-md px-4 py-2 rounded-2xl ${
                                message.isCurrentUser 
                                    ? 'bg-indigo-600 text-white rounded-tr-none' 
                                    : 'bg-white text-gray-800 rounded-tl-none shadow-sm'
                            }`">
                                <div v-if="!message.isCurrentUser" class="text-xs font-semibold text-indigo-600 mb-1">
                                    {{ message.username }}
                                </div>
                                <div class="text-sm">{{ message.message }}</div>
                                <div class="text-xs mt-1 opacity-75 text-right">
                                    {{ message.time }}
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                
                <!-- Message Input -->
                <div class="border-t pt-4">
                    <form @submit.prevent="sendMessage" class="flex space-x-2">
                        <input 
                            type="text" 
                            v-model="newMessage"
                            placeholder="Mesajınızı yazın..." 
                            class="flex-1 p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                            autocomplete="off"
                            :disabled="isSending"
                            @keydown.enter="sendMessage"
                        >
                        <button 
                            type="submit" 
                            class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="!newMessage.trim() || isSending"
                        >
                            <span v-if="!isSending" class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                </svg>
                                Gönder
                            </span>
                            <span v-else class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Gönderiliyor...
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

export default {
    data() {
        return {
            messages: [],
            newMessage: '',
            username: 'Kullanıcı' + Math.floor(1000 + Math.random() * 9000),
            user_id: Math.floor(1000 + Math.random() * 9000),
            isSending: false,
            echo: null,
        }
    },

    mounted() {
        this.initializeEcho();

        this.echo = new Echo({
            broadcaster: 'reverb',
            key: import.meta.env.VITE_REVERB_APP_KEY,  // .env’de REVERB_APP_KEY
            wsHost: window.location.hostname,
            wsPort: 8080,
            forceTLS: false,
            enabledTransports: ['ws', 'wss'],
        });
        this.echo.channel(`chat`)
        .listen('.NewMessage', (event) => {
            this.addMessage(event);
        });
            
    },

    methods: {
        initializeEcho() {
           
        },

        addMessage(message) {
            this.messages.push(message);
            this.$nextTick(() => this.scrollToBottom());
        },

        async sendMessage() {
            const message = this.newMessage.trim();
            if (!message || this.isSending) return;

            this.isSending = true;
            
            try {
                const response = await fetch('/api/send-message', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        message: message,
                        //username: this.username
                    })
                });
                //console.log(response)
                if (!response.ok) {
                    throw new Error('Mesaj gönderilemedi');
                }

                this.newMessage = '';
            } catch (error) {
                console.error('Hata:', error);
                alert('Mesaj gönderilirken bir hata oluştu. Lütfen tekrar deneyin.');
            } finally {
                this.isSending = false;
            }
        },

        scrollToBottom() {
            const container = this.$refs.messages;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }
    }
}
</script>
