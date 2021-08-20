<template>
    <div>
        <router-link class="mt-2" :to="{ name: 'MyMessage', params: { conversation: conversation, sender: sender, recipient: recipient, subject: subject}}">
            <div class="notification mb-4 px-3.5 bg-green-100 rounded-lg shadow break-all whitespace-normal">
                <small class="bg-green-600 bg-opacity-25 text-green-800 text-purple-800 text-opacity-100 text-xs -ml-2 rounded-full py-0.3 px-1">From {{ sender }}</small><br>
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
    ]
}
</script>

<style>

</style>