<template>
    <div class="w-2/4 mx-auto">
        <div class="grid grid-cols-2">
            <p v-if="!messages.length">Start typing the first message</p>

            <div v-for="(message, index) in messages" :class="(message.userId == userId) ? 'col-span-1 col-start-2' : 'col-span-2'" :key="index">
                <my-message
                    v-if="message.userId == userId"
                    :message="message.text">
                </my-message>

                <message
                    v-if="message.userId != userId"
                    :message="message.text"
                    :userName="message.userName">
                </message>
            </div>
        </div>
        <hr class="py-3">
        <form @submit.prevent="sendMessage">
            <div class="grid grid-cols-12 auto-cols-auto">
                <div class="col-span-12">
                    <input 
                        type="text" 
                        v-model="newMessage" 
                        class="py-4 pl-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md filter drop-shadow" 
                        placeholder="Type a message">
                </div>
            </div>
        </form>

    </div>
</template>

<script>
export default {
    data () {
        return {
            userId: '',
            userName: '',
            messages: [],
            newMessage: '',
        }
    },
    mounted () {

       this.getUser();

        Echo.private('chat')
            .listen('NewChatMessage', (e) => {
                if(e.userId != this.userId) {
                    this.messages.push({
                        text: e.text,
                        userId: e.userId,
                        userName: e.userName
                    });
                }
            });

    },
    methods: {
        sendMessage() {  
            if(this.userId != ''){
                axios.post(`/api/message`, {
                    text: this.newMessage,
                    userId: this.userId,
                    userName: this.userName
                })
                .then((response) => {
                    this.messages.push({
                        text: this.newMessage,
                        userId: this.userId,
                        userName: this.userName
                    });
                    
                    this.newMessage = '';
                })
                .catch((error) => {
                    console.log(error);
                });
            }
        },

        getUser(){
            axios.get('/api/user')
            .then((response) =>{
                this.userId = response.data.id; 
                this.userName = response.data.email;
            });
        }
        
    }
}
</script>

<style>

</style>