<script setup>
defineProps(['task']);
</script>

<template>
    <div v-show="task">
        <p class="text-sm text-red-600">
            {{ task }}
        </p>
    </div>
</template>
