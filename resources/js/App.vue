<!-- App.vue -->

<template>
  <div>
    <MainLayout/>
    <!-- <MainLayout v-if="!is404" />
    <ErrorLayout v-else /> -->
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useAuthUserStore } from './stores/AuthUserStore';
import { useRoute } from 'vue-router'; // Import useRoute function
const authUserStore = useAuthUserStore();
const route = useRoute(); // Access the current route
import MainLayout from './CustomMainLayout.vue'; // Import the CustomMainLayout component
import ErrorLayout from './404.vue'; // Import the ErrorLayout component

const is404 = computed(() => {
  return route.name === '404 Error Page';
});
</script>

<style scoped>
/* Add your styling for the main App.vue layout if needed */
</style>
