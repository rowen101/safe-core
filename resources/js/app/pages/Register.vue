<template>
    <!-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div
                    class="alert alert-danger"
                    role="alert"
                    v-if="error !== null"
                >
                    {{ error }}
                </div>

                <div class="card card-default">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label
                                    for="name"
                                    class="col-sm-4 col-form-label text-md-right"
                                    >Name</label
                                >
                                <div class="col-md-6">
                                    <input
                                        id="name"
                                        type="text"
                                        class="form-control"
                                        v-model="name"
                                        required
                                        autofocus
                                        autocomplete="off"
                                    />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    for="email"
                                    class="col-sm-4 col-form-label text-md-right"
                                    >E-Mail Address</label
                                >
                                <div class="col-md-6">
                                    <input
                                        id="email"
                                        type="email"
                                        class="form-control"
                                        v-model="email"
                                        required
                                        autofocus
                                        autocomplete="off"
                                    />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    for="password"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Password</label
                                >
                                <div class="col-md-6">
                                    <input
                                        id="password"
                                        type="password"
                                        class="form-control"
                                        v-model="password"
                                        required
                                        autocomplete="off"
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="password"
                                    class="col-md-4 col-form-label text-md-right"
                                    >Confirmed Password</label
                                >
                                <div class="col-md-6">
                                    <input
                                        id="password_confirmation"
                                        type="password"
                                        class="form-control"
                                        v-model="password_confirmation"
                                        required
                                        autocomplete="off"
                                    />
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        @click="handleSubmit"
                                    >
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div
                class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100"
            >
                <div class="d-table-cell align-middle">
                    <div class="text-center mt-4">
                        <h1 class="h2">Safexpress Logistics Inc.</h1>
                        <p class="lead">for SLI monitoring</p>
                    </div>
 <div
                    class="alert alert-danger"
                    role="alert"
                    v-if="error !== null"
                >
                    {{ error }}
                </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-3">
                                <form @submit.prevent="handleSubmit">
                                    <div class="mb-3">
                                        <label class="form-label"
                                            >Full name</label
                                        >
                                        <input
                                            class="form-control form-control-lg"
                                            id="name"
                                               v-model="name"
                                        required
                                        autofocus
                                        autocomplete="off"
                                            type="text"
                                            name="name"
                                            placeholder="Enter your name"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input
                                        id="email"
                                            class="form-control form-control-lg"
                                              v-model="email"
                                        required
                                        autofocus
                                        autocomplete="off"
                                            type="email"
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
                                            id="password"
                                            v-model="password"
                                            required
                                            autocomplete="off"
                                            type="password"
                                            name="password"
                                            placeholder="Password"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"
                                            >Confirmed Password</label
                                        >
                                        <input
                                            class="form-control form-control-lg"
                                            id="password_confirmation"
                                            v-model="password_confirmation"
                                            required
                                            autocomplete="off"
                                            type="password"
                                            name="password"
                                            placeholder="Confirmed Password"
                                        />
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        <button
                                            type="submit"
                                            class="btn btn-lg btn-primary"

                                        >
                                            Sign up
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-3">
                        Already have account?
                        <a href="/login">Log In</a>
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
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            error: null,
        };
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault();
            if (this.password.length > 0) {
                this.$axios.get("/sanctum/csrf-cookie").then((response) => {
                    this.$axios
                        .post("api/register", {
                            name: this.name,
                            email: this.email,
                            password: this.password,
                            password_confirmation: this.password_confirmation,
                        })
                        .then((response) => {
                            if (response.data.success) {
                                window.location.href = "/login";
                            } else {
                                this.error = response.data.message;
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                });
            }
        },
    },
    beforeRouteEnter(to, from, next) {
        if (window.Laravel.isLoggedin) {
            return next("dashboard");
        }
        next();
    },
};
</script>
