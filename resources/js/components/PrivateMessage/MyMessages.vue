<template>
    <div>
        <h1 class="text-2xl pb-2">My Conversations</h1>
        <div v-for="(item, index) in conversations" :key="index">
            <conversation 
                :conversation="item.conversation_id"
                :sender="item.sender_id"
                :subject="item.subject_id"
                :recipient="item.recipient_id"
                :unread="item.unread">
            </conversation>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            conversations: [],
        }
    },
    mounted () {
        this.getConversations();
    },
    methods: {
        getConversations() {  
            axios.get(`/api/user/conversations`)
            .then((response) => {
                this.conversations = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
        }
    }
}
</script>

<style>

</style>