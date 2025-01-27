<template>
  <div>
    <Head title="Dashboard" />
    <div class="flex h-screen overflow-hidden">

      <div class="w-1/4 bg-white border-r border-gray-300 p-5">
      <Rooms></Rooms>
      </div>

      <div class="flex-1">
        <ChatMessage :messages="messages" :id="id"/><br>
        <ChatForm :messages="messages" @send="addMessage" />
      </div>
    </div>
  </div>
</template>

<script setup>

import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import Rooms from '@/Shared/Rooms.vue';
import ChatForm from '@/Shared/ChatForm.vue';
import ChatMessage from '@/Shared/ChatMessage.vue';
import Layout from '@/Shared/Layout.vue';
import Echo from 'laravel-echo';

import axios from 'axios';

const props = defineProps({ id: String });
const messages = ref([]);

const fetchMessages = async () => {
  try {
    const response = await axios.get(`/messages/${props.id}`);
    messages.value = response.data;
  } catch (error) {
    console.error('Error fetching messages:', error);
  }
};

const addMessage = async (message) => {
  try {
    const response = await axios.post(`/messages/${props.id}`, message);
    //messages.value.push(message); // Optimistically adding the message to the list
    console.log('Message sent:', response.data);
  } catch (error) {
    console.error('Error posting message:', error);
  }
};

onMounted(async () => {
  await fetchMessages();

  window.Echo.private(`chat.${props.id}`)
    .listen('MessageSent', (e) => {
      messages.value.push(e.message);
    });

});


// Use Inertia.js layout component

defineOptions({ layout: Layout })

</script>

<style scoped>
/* Your styles here */
</style>
