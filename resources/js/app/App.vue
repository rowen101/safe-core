<template>

    <notifications position="top right"/>
    <!-- Use dynamic layout based on the route -->
    <component :is="currentLayout">
      <router-view />
    </component>

</template>

<script>

import LoginLayout from "./layouts/AuthLayout.vue";
import DefaultLayout from "./layouts/DefaultLayout.vue";
export default {
  name: "App",
  data() {
    return {
      isLoggedIn: false,
    };
  },
  created() {
    if (this.$store.getters.isLoggedIn) {
      this.isLoggedIn = true;
    }
  },
  computed: {
    // Determine the current layout component based on the route
    currentLayout() {
      // Check the route's meta property to decide the layout
      const route = this.$route;
      if (route.meta.requiresAuth) {
        // Use the DefaultLayout for authenticated routes
        return DefaultLayout;
      } else if (route.meta.requiresVisitor) {
        // Use the LoginLayout for visitor (non-authenticated) routes
        return LoginLayout;
      } else {
        // Default layout if no specific layout is defined
        return DefaultLayout;
      }
    },
  },
  methods: {

  },
};
</script>
