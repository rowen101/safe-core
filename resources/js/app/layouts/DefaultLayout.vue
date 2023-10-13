<template>
    <div class="wrapper">
        <DefaultHeaderVue />
        <DefaulSidebar />
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <DefaaultBreadcrumb/>
                    <router-view />
                </div>
            </div>
        </div>
        <DefaultFooter />
    </div>
</template>
<script>
import DefaultHeaderVue from "../containers/DefaultHeader.vue";
import DefaulSidebar from "../containers/DefaulSidebar.vue";
import DefaultFooter from "../containers/DefaultFooter.vue";
import DefaaultBreadcrumb from '../containers/Breadcrumb.vue';
export default {
    name: "Dashboard",
    components: {
        DefaulSidebar,
        DefaultHeaderVue,
        DefaultFooter,
        DefaaultBreadcrumb,
    },
    data() {},
    created() {

    },
};
</script>
