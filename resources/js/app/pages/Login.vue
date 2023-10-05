<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="alert alert-danger" role="alert" v-if="error !== null">
          {{ error }}
        </div>

        <div class="card card-default">
          <div class="card-header">Login</div>
          <div class="card-body">
            <form @submit.prevent="handleSubmit">
              <div class="form-group row">
                <label
                  for="email"
                  class="col-sm-4 col-form-label text-md-right"
                >E-Mail Address</label>
                <div class="col-md-6">
                  <input
                    id="email"
                    type="email"
                    class="form-control"
                    v-model="credentials.email"
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
                >Password</label>
                <div class="col-md-6">
                  <input
                    id="password"
                    type="password"
                    class="form-control"
                    v-model="credentials.password"
                    required
                    autocomplete="off"
                  />
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">Login</button>
                </div>
              </div>
            </form>
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
                    // miniToastr.success("Login " + resp.data.success);

                    // window.location.href = "/dashboard";
                    window.location.replace("/dashboard")
                })
                .catch((err) => {
                    console.log(err)
                });
        },
    // async handleSubmit() {
    //   if (this.password.length > 0) {
    //     try {
    //       const response = await this.$axios.post("api/login", {
    //         email: this.email,
    //         password: this.password,
    //       });
    //       console.log(response.data);

    //       this.$axios.defaults.headers.common["Authorization"] =
    //         "Basic " + response.data.token;
    //       const token = response.data.token;

    //       localStorage.setItem("token", token);

    //       if (response.data.success) {
    //         this.$router.push({ name: "dashboard" });
    //       } else {
    //         this.error = response.data.message;
    //       }
    //     } catch (error) {
    //       console.error(error);
    //     }
    //   }
    // },
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
