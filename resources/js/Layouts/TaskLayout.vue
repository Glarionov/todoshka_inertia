<script setup>
import { ref } from 'vue';
let readyToUpdateOnlineStatus = ref(true);
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

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
