<template>
    <div>
        <div>
            <ul class="grid grid-cols-1">
                <li class="col-span-1" v-for="(item, index) in messages" :key="index">{{ item.body }}</li>
            </ul>
        </div>

        <form @submit.prevent="sendMessage">
            <input type="text" v-model="newMessage" class="shadow appearance-none border rounded w-3/12 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </form>
    </div>
</template>

<script>
export default {
    data(){
        return{
            messages: [],
            newMessage: '',
            sender_id: this.$route.params.from,
            recipient_id: this.$route.params.to,
            conversation_id: '',
            subject_id: this.$route.params.car
        }
    },
    beforeMount(){
        this.conversation_id = this.sender_id + this.recipient_id + this.subject_id;
    },
    mounted(){
        this.getMessages();
        Echo.private(`message-${this.conversation_id}`)
            .listen('NewPrivateMessage', (e) => {
                this.messages.push(e.message);
            });
    },
    methods:{
        sendMessage(){
            /*              buyer       seller
            sender_id           1       3
            recipient_id        3       1
            subject_id          38      38
            conversation_id     1338    1338

            */
            axios.post(`/api/message/conversation/${this.conversation_id}`, {
                message: this.newMessage,
                sender_id: this.sender_id,
                recipient_id: this.recipient_id,
                conversation_id: this.conversation_id,
                subject_id: this.subject_id
            })
            .then(() => {
                this.messages.push({
                    body: this.newMessage
                });

                this.newMessage = '';
            });
        },
        getMessages(){
            axios.post('/api/messages', {
                conversation_id: this.conversation_id
            }).then((response) => {
                this.messages= response.data;
            });
        }
    }
}
</script>

<style>

</style>