<template>
    <div class="w-2/4 mx-auto">
        <div class="grid grid-cols-2">
            <div v-for="(item, index) in messages" :key="index" :class="(item.sender_id == recipient_id) ? 'col-span-2' : 'col-span-1 col-start-2 text-right'" :id="item.id">
                <div class="mb-4 px-3.5 rounded-lg shadow break-all whitespace-normal" :class="(item.sender_id == recipient_id) ? 'bg-gray-200 notification' : 'bg-green-200'">{{ item.body }}</div>
            </div>
        </div>

        <form @submit.prevent="sendMessage">
            <div class="grid grid-cols-12 auto-cols-auto">
                <div class="col-span-12">
                    <input type="text" v-model="newMessage" class="py-4 pl-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md filter drop-shadow">
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data(){
        return{
            messages: [],
            newMessage: '',
            conversation_id: this.$route.params.conversation,
            sender_id: this.$route.params.recipient,
            recipient_id: this.$route.params.sender,
            subject_id: this.$route.params.subject,
            messageToScroll: '',
        }
    },
    mounted(){
        this.getMessages();

        // timeout needs to work scroll event
        setTimeout(() => {
            this.scrollToMessage(this.messageToScroll);
        }, 500);

        Echo.private(`message-${this.conversation_id}`)
            .listen('NewPrivateMessage', (e) => {
                this.messages.push(e.message);
            });
        
        Echo.private(`App.Models.User.${this.sender_id}`)
            .notification((notification) => {
                console.log(notification.count);
            });
        
    },
    methods:{
        sendMessage(){
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
                this.messages= response.data.messages;
                this.messageToScroll = response.data.messageToScroll ?? null;
            });
        },

        scrollToMessage(messageToScroll){
            // if there are not unseen messages for user then scrolling page to the end
            if(!messageToScroll){
                let el = document.getElementsByTagName('form')[0];
                return el.scrollIntoView({behavior: "smooth", block: "start"});
            }

            // scrolling to the first unseen message
            let el = document.getElementById(messageToScroll);
            return el.scrollIntoView({behavior: "smooth", block: "center"});
        }
    }
}
</script>

<style scoped>
    .notification {
        max-width: 80%;
    }
</style>