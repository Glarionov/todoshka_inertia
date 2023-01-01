<script setup>
import {onMounted} from "vue";

const loadMessages = async () => {

}

const listenUpdates = async () => {
    window.Echo.channel('update')
        .listen('Update', e => {
            /*s*/console.log('e=', e); //todo r
        });
}

onMounted(() => {
    listenUpdates();
    loadMessages();
});

</script>

<template>

</template>

<style scoped>

</style>
