<template>
        <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{name}}</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                     <li class="breadcrumb-item">
                         <router-link :to="{ name: 'home' }">Home</router-link>
                     </li>
                    <li class="breadcrumb-item active">
                       {{name}}
                    </li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
</template>
<script>
export default {
    name: "Breadcrumb",

    computed: {
        name() {
        return this.$route.name;
        },
        list() {
        return this.$route.matched.filter(
            route => route.name || route.meta.label
        );
        },
    }
}
</script>

