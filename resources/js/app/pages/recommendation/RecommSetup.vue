<template>
    <section class="content">
        <div class="card card-primary card-outline">
            <div class="card-header">

                     <h3 class="card-title">{{appendtext}} Tech Recommendation</h3>
    
            </div>
            <div class="card-body">


        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addtech">
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

export default {
    data() {
        return {
            appendtext: this.$route.params.id == undefined ? "Create" : "Update",
            form: {
                id: this.$route.params.id == undefined ? "" : this.$route.params.id,
                techno:"",
                company:"",
                branch:"",
                department:"",
                warehouse:"",
                user:"",
                report:"",
                udetails:"",
                ass_conducted:"",
                recommendation:"",
                createdby:""
            },
        };
    },
    methods: {
        addtech() {

             const token = localStorage.getItem("token"); // Get the token from localStorage
            this.$axios.get("/sanctum/csrf-cookie").then((response) => {
                this.$axios
                    .post("/api/tech/recomm", this.form, {
                        headers: {
                            Authorization: `Bearer ${token}`, // Include the token in the request headers
                        },
                    })
                    .then((response) => {
                        this.$router.push({ name: "recommendation" });
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            });
        },
    },
};
</script>
