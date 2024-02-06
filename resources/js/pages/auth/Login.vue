<script setup>
import axios from 'axios';
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthUserStore } from '../../stores/AuthUserStore';
import { useToastr } from '../../toastr.js';


const toastr = useToastr();
const authUserStore = useAuthUserStore();
const router = useRouter();
const form = reactive({
    email: '',
    password: '',
});

const loading = ref(false);

const errorMessage = ref('');
const handleSubmit = () => {
    loading.value = true;
    errorMessage.value = '';
    axios.post('/login', form)
        .then(() => {
            router.push('/admin/dashboard');
            toastr.success("Login Success");
        })
        .catch((error) => {
            //errorMessage.value = error.response.data.message;
            toastr.error(error.response.data.message);
        })
        .finally(() => {
            loading.value = false;
        });
};


</script>

<template>
    <div class="login-box">

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h5">Sign in</a>
            </div>
            <div class="card-body">

                <div v-if="errorMessage" class="alert alert-danger" role="alert">
                    {{ errorMessage }}
                </div>
                <form @submit.prevent="handleSubmit">
                    <div class="input-group mb-3">
                        <input v-model="form.email" type="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input v-model="form.password" type="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">


                        <div class="col-12 mb-2">
                            <button type="submit" class="btn btn-primary btn-block" :disabled="loading">
                                <div v-if="loading" class="spinner-border spinner-border-sm" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <span v-else>Sign In</span>
                            </button>
                        </div>

                    </div>
                </form>
<div class="row">
    <div class="col-12">

        <a  class="btn btn-success btn-block" href="#" target="_blank">
<span ><b>Request Account</b></span>
</a>

    </div>
</div>

            </div>

        </div>
    </div>
</template>
