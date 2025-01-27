<template>
    <div>
        
        <header class="bg-white p-4 text-gray-700">
           
            <div class="flex justify-between items-center w-full">
                <h1 class=" text-2xl font-semibold w-1/2">
                    {{ props.id }} Nolu Oda</h1>
            
                <button @click="showUsers = !showUsers"  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" >
                    Kullanıcılar
                </button> 
                <!-- Kullanıcılar Modal -->
                <div v-if="showUsers" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                  <div class="bg-white p-6 rounded shadow-lg w-1/3">
                    <h2 class="text-2xl mb-4">Kullanıcıları Yönet</h2>
                    <input 
                      type="text" 
                      v-model="search" 
                      placeholder="Kullanıcı ara..." 
                      class="w-full p-2 mb-4 border rounded"
                    >
                    
                    <ul class="mb-4">
                      <li 
                        v-for="user in filteredUsers" 
                        :key="user.id" 
                        class="flex justify-between items-center"
                      >
                        <span>{{ user.first_name }}</span>
                        <button 
                          @click="toggleUserInRoom(user)" 
                          :class="{
                            'bg-green-500 hover:bg-green-700': !isUserInRoom(user),
                            'bg-red-500 hover:bg-red-700': isUserInRoom(user)
                          }"
                          class="text-white py-1 px-3 rounded"
                        >
                          {{ isUserInRoom(user) ? 'Çıkar' : 'Ekle' }}
                        </button>
                      </li>
                    </ul>
            
                    <button @click="toggleUserModal" class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded">
                      Kapat
                    </button>
                  </div>
                </div>
            </div>
                
        </header>
        <div id="messages"  class=" pl-5 pr-5 flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch" v-if="messages.length>0">
            <div v-for="message in messages" :key="message.id" class="chat-message">
                <div class="flex items-end">
                    <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                        <div><span class="px-4 py-2 rounded-lg inline-block bg-gray-300 text-gray-600">{{ message.user_name }}: {{ message.body }} </span></div>
                    </div>
                    <img width="24" height="24" src="https://img.icons8.com/external-those-icons-fill-those-icons/24/external-Chat-user-actions-those-icons-fill-those-icons.png" alt="external-Chat-user-actions-those-icons-fill-those-icons"/>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

    const props = defineProps({ messages:Object,id: String });

    import { ref, computed, onMounted } from 'vue';
    import axios from 'axios';

    const showUsers = ref(false);
    const search = ref('');
    const allUsers = ref([]);
    const roomUsers = ref([]);

    const toggleUserModal = () => {
        showUsers.value = !showUsers.value;
    };

    const fetchUsers = async () => {
        const response = await axios.get(`/room/${props.id}/users`);
        allUsers.value = response.data.allUsers;
        roomUsers.value = response.data.roomUsers;
    };

    const filteredUsers = computed(() => {
    return allUsers.value.filter(user => {
        const fullName = `${user.first_name} ${user.last_name}`.toLowerCase();
        return fullName.includes(search.value.toLowerCase());
    });
    });

    const isUserInRoom = (user) => {
        return roomUsers.value.some(roomUser => roomUser.id === user.id);
    };
    const toggleUserInRoom = async (user) => {
        if (isUserInRoom(user)) {
            await removeUserFromRoom(user);
        } else {
            await addUserToRoom(user);
        }
    };
    const addUserToRoom = async (user) => {
        await axios.post(`/room/${props.id}/add-user`, { user_id: user.id });
        roomUsers.value.push(user);
    };

    const removeUserFromRoom = async (user) => {
        await axios.post(`/room/${props.id}/remove-user`, { user_id: user.id });
        roomUsers.value = roomUsers.value.filter(roomUser => roomUser.id !== user.id);
    };

    onMounted(fetchUsers);

</script>

<style>
.scrollbar-w-2::-webkit-scrollbar {
    width: 0.25rem;
    height: 0.25rem;
  }
  
  .scrollbar-track-blue-lighter::-webkit-scrollbar-track {
    --bg-opacity: 1;
    background-color: #f7fafc;
    background-color: rgba(247, 250, 252, var(--bg-opacity));
  }
  
  .scrollbar-thumb-blue::-webkit-scrollbar-thumb {
    --bg-opacity: 1;
    background-color: #edf2f7;
    background-color: rgba(237, 242, 247, var(--bg-opacity));
  }
  
  .scrollbar-thumb-rounded::-webkit-scrollbar-thumb {
    border-radius: 0.25rem;
  }
</style>