<template>
    <div>
        <router-link class="mt-2" :to="{ name: 'MyMessage', params: { conversation: conversation, sender: sender, recipient: recipient, subject: subject}}">
            <div class="notification mb-4 px-3.5 bg-green-100 rounded-lg shadow break-all whitespace-normal">
                <small class="bg-green-600 bg-opacity-25 text-green-800 text-purple-800 text-opacity-100 text-xs -ml-2 rounded-full py-0.3 px-1">From {{ sender }}</small>
                <small v-if="conversation == conversation_id && notifications">({{ notifications }})</small>
                <br>
                {{ subject }}
            </div>
         </router-link> 
    </div>
</template>

<script>
export default {
    props: [
        'conversation',
        'sender',
        'subject',
        'recipient',
        'unread'
        ],
    data () {
        return { 
            notifications: '',
            conversation_id: ''
            // DONE when broadcast message then notification updates count of unread messages to the correct conversation
            // DONE mark READ notifications when notified user sends new messages in room
            // DONE on page load to get counted messages for each dialog
            // DONE scroll to the first unread user's message on mounted or to the end of page if there are no unseen messages
            // todo on conversation page to display user_name, topic, last message
        }
    },
    mounted(){
        this.notifications = this.unread;
        this.conversation_id = this.conversation;
        Echo.private(`App.Models.User.${this.$route.params.userId}`)
            .notification((notification) => {
                this.notifications = this.incrUnread(notification);
            });
    },
    methods:{
        incrUnread(notification){
            if(this.conversation == notification.data.data.conversation_id){  
                return notification.count;
            } else{
                return this.notifications = this.notifications;
            }
        }
    }
}
</script>

<style>

</style>