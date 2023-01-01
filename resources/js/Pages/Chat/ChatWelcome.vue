<script setup>
import ChatLayout from '@/Layouts/ChatLayout.vue';
import ChatRooms from "@/Pages/Chat/ChatRooms.vue";
import {onMounted} from "vue";

onMounted(() => {
    window.Echo.channel('update')
        .listen('Update', e => {
            /*s*/console.log('e=', e); //todo r
        });
});

</script>

<template>
    <ChatLayout>
        <ChatRooms />
    </ChatLayout>
</template>


<style scoped>

</style>
