<template>
    <div class="container d-flex flex-column">
          <div class="col-md-8">
        <div class="alert alert-danger" role="alert" v-if="error !== null">
          {{ error }}
        </div>
          </div>
        <div class="row vh-100">
            <div
                class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100"
            >
                <div class="d-table-cell align-middle">
                    <div class="text-center mt-4">
                        <h1 class="h2">Welcome back!</h1>
                        <p class="lead">Sign in to your account to continue</p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-3">
                                <form @submit.prevent="handleSubmit">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input
                                            class="form-control form-control-lg"
                                            id="email"
                                            type="email"
                                            v-model="credentials.email"
                                            name="email"
                                            placeholder="Enter your email"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"
                                            >Password</label
                                        >
                                        <input
                                            class="form-control form-control-lg"
                                            v-model="credentials.password"
                                            required
                                            autocomplete="off"
                                            type="password"
                                            name="password"
                                            placeholder="Enter your password"
                                        />
                                    </div>
                                    <div>
                                        <div
                                            class="form-check align-items-center"
                                        >
                                            <input
                                                id="customControlInline"
                                                type="checkbox"
                                                class="form-check-input"
                                                value="remember-me"
                                                name="remember-me"
                                                checked
                                            />
                                            <label
                                                class="form-check-label text-small"
                                                for="customControlInline"
                                                >Remember me</label
                                            >
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        <button
                                            type="submit"
                                            class="btn btn-lg btn-primary"
                                        >
                                            Sign in
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-3">
                        Don't have an account?

                         <router-link to="/register">
                         Sign up
                         </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            credentials: {
                email: "",
                password: "",
            },

            error: null,
        };
    },
    methods: {
        handleSubmit: function () {
            this.$store
                .dispatch("login", this.credentials)
                .then((resp) => {


                    // window.location.href = "/dashboard";
                    window.location.replace("/dashboard");
                })
                .catch((err) => {
                    console.log(err);
                });
        },

    },
    beforeRouteEnter(to, from, next) {
        if (window.Laravel.isLoggedin) {
            next("/dashboard"); // Redirect to dashboard
        } else {
            next(); // Continue with the route
        }
    },
};
</script>
