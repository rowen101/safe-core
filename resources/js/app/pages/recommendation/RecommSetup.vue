<template>
    <section class="content">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">{{ appendtext }} Tech Recommendation</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <form @submit="onSubmit">
                            <div class="form-group">
                                <label>Branch</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.branch"
                                />
                            </div>
                            <div class="form-group">
                                <label>Department</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.department"
                                />
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Add Tech Recommendation
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import api from "../../services/api";
export default {
    data() {
        return {
            appendtext:
                this.$route.params.id == undefined ? "Create" : "Update",
            form: {
                id:
                    this.$route.params.id == undefined
                        ? ""
                        : this.$route.params.id,
                techno: "",
                company: "",
                branch: "",
                department: "",
                warehouse: "",
                user: "",
                report: "",
                udetails: "",
                ass_conducted: "",
                recommendation: "",
                createdby: "",
            },
        };
    },
    methods: {
        onSubmit: function (evt) {
            evt.preventDefault();
            api.instance
                .post("tech/recomm", this.form)

                .then((response) => {
                    // this.$router.push({ name: "recommendation" });
                    console.log(response);
                })
                .catch(function (error) {
                    console.error(error);
                      api.httpMsg(self, error.status, error.data);
                });
        },
        getdata: function () {
            let self = this;

            if (self.$route.params.id !== undefined) {
                api.instance
                    .get("tech/recomm/" + self.$route.params.id)

                    .then((response) => {
                        self.form = response.data;
                        // if (self.form.status === "A") {
                        // self.checked = true;
                        // } else {
                        // self.checked = false;
                        // }
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.error(error);
                       api.httpMsg(self, error.status, error.data);
                    });
            }
        },
    },
    created: function () {
      this.getdata();
    },
};
</script>
