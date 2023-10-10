<template>
    <div class="wrapper">
        <DefaulSidebar/>
        <div class="main">
            <DefaultHeaderVue/>
            <main class="content">
        <router-view />
            </main>
              <DefaultFooter/>
        </div>

    </div>

</template>
<script>
import DefaultHeaderVue from '../containers/DefaultHeader.vue';
import DefaulSidebar from "../containers/DefaulSidebar.vue";
import DefaultFooter from "../containers/DefaultFooter.vue";
export default {
    name: "Dashboard",
     components: {
    DefaulSidebar,
    DefaultHeaderVue,
    DefaultFooter
  },
  data() {
  },
  created() {
    //  this.$notify({
    //             title: "Login Successful",
    //             type: 'dan',
    //             text: this.$store.getters.user.name,
    //         });
  }

}
</script>
