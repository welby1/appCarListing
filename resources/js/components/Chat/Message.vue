<template>
    <div>
        <div class="notification mb-4 px-3.5 bg-green-200 rounded-r-lg shadow break-all whitespace-normal">
            <small class="bg-green-600 bg-opacity-25 text-green-800 text-purple-800 text-opacity-100 text-xs -ml-2 rounded-full py-0.3 px-1.5">Sent by {{ userName }}</small><br>
            {{ message }}
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'message',
        'userName'
    ]
}
</script>

<style scoped>
    .notification {
        max-width: 80%;
    }
</style>