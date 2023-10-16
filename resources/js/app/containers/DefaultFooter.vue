<template>
  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      {{ authUserStore }}
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2023.</strong> All rights reserved.
  </footer>
</template>

<script>
export default {
  computed: {
    authUserStore() {
      if (this.$store.getters.isLoggedIn) {
        return this.$store.getters.user.name;
      }
      return null; // or any default value you prefer
    },
  },
}
</script>
