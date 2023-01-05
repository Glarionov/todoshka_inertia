<script setup>
import { ref } from 'vue';
let readyToUpdateOnlineStatus = ref(true);
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

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
        <header>
            <div class="text-yellow-300 bg-blue-900 w-full p-1 flex justify-end">
                <slot name="extra-header-elements"></slot>
                <div>
                    <ResponsiveNavLink :href="route('profile.edit')"> Profile</ResponsiveNavLink>
                </div>
                <div>
                    <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                        Log Out
                    </ResponsiveNavLink>
                </div>
            </div>
        </header>

        <main>
            <slot />
        </main>
    </div>
</template>
