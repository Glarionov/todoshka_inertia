<script setup>
import { ref } from 'vue';
let readyToUpdateOnlineStatus = ref(true);

const updateOnlineStatus = () => {
    if (readyToUpdateOnlineStatus.value) {
        readyToUpdateOnlineStatus.value = false;
        axios.post(route('chat.updateOnlineStatus'));
        setTimeout(() => {
            readyToUpdateOnlineStatus.value = true;
        }, 10000);
    }
}

</script>

<template>
    <div @mousemove="updateOnlineStatus" @click="updateOnlineStatus" @keyup="updateOnlineStatus" @scroll="updateOnlineStatus">
        <notifications />
        <slot></slot>
    </div>
</template>
