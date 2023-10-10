<template>
    <div>Welcome {{ name }}</div>
</template>

<script>
export default {
    name: "Dashboard",
    data() {
        return {
            name: null,
        };
    },
    created() {
        if (this.$store.getters.isLoggedIn) {
            this.name = this.$store.getters.user.name;
           
        }
    },
};
</script>
