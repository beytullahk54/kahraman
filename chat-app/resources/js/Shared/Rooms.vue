<template>
    <div>
        
        <h1 class="mb-8 text-3xl font-bold">Odalar</h1>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="addRoom()">
            Oda Oluştur
        </button><br><br>
        <div
          class="flex flex-row py-4 px-2 justify-center items-center border-b-2"
           v-for="i in rooms"
        >
          <div class="w-full" >
            <Link class="mt-1 " :href="'/room/'+i.id">
                <div class="text-lg font-semibold">Oda {{i.id}}</div>
            </Link>
          </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue';
import axios from 'axios';

const rooms = ref(5);

const fetchRooms = async () => {
  try {
    const response = await axios.get('/getRooms');
    rooms.value = response.data;
  } catch (error) {
    console.error('Error fetching messages:', error);
  }
};

const addRoom = async (message) => {
  try {
    const response = await axios.post(`/addRoom`, message);

    rooms.value.push(response.data); // Optimistically adding the message to the list
    //messages.value.push(message); // Optimistically adding the message to the list
    console.log('Message sent:', response.data);
  } catch (error) {
    console.error('Error posting message:', error);
  }
};


onMounted(async () => {
    fetchRooms()
})

</script>