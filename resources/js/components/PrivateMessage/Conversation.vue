<template>
    <div>
        <router-link class="mt-2" :to="{ name: 'MyMessage', params: { conversation: conversation, sender: sender, recipient: recipient, subject: subject}}">
            <div class="notification mb-4 px-3.5 bg-green-100 rounded-lg shadow break-all whitespace-normal">
                <small class="bg-green-600 bg-opacity-25 text-green-800 text-purple-800 text-opacity-100 text-xs -ml-2 rounded-full py-0.3 px-1">From {{ sender }}</small><small v-if="conversation == conversation_id">({{ notifications.count }})</small><br>
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
        'recipient'
        ],
    data () {
        return { 
            notifications: '',
            conversation_id: ''
            // DONE when broadcast message then notification updates count of unread messages to the correct conversation
            // todo mark READ notifications when notified user checked messages in room
            // todo on page load to get counted messages for each dialog
        }
    },
    mounted(){
        Echo.private(`App.Models.User.${this.$route.params.userId}`)
            .notification((notification) => {
                this.notifications = this.compareConversations(notification);
            });
    },
    methods:{
        compareConversations(notification){
            if(this.conversation == notification.data.data.conversation_id){
                this.conversation_id = notification.data.data.conversation_id;
                return notification;
            }
        }
    }
}
</script>

<style>

</style>