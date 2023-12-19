<script setup>
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

</script>

<template>
  <div>
    <notifications />
    <header class="bg-primary py-2">
      <div class="container d-flex justify-content-end align-items-center">
        <slot name="extra-header-elements"></slot>
        <div class="ms-2">
          <ResponsiveNavLink :href="route('profile.edit')" class="text-light">
            Profile
          </ResponsiveNavLink>
        </div>
        <div class="ms-2">
          <ResponsiveNavLink :href="route('logout')" method="post" as="button" class="btn btn-light">
            Log Out
          </ResponsiveNavLink>
        </div>
      </div>
    </header>

    <main class="container mt-4">
      <slot />
    </main>
  </div>
</template>