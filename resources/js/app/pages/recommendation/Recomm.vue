<template>
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Tech Recommendation</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <br />
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Author</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(book, index) in items"
                                    :key="book.id"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ book.name }}</td>
                                    <td>{{ book.author }}</td>
                                    <td>{{ book.created_at }}</td>
                                    <td>{{ book.updated_at }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <router-link
                                                :to="{
                                                    name: 'edit-recommendation',
                                                    params: { id: book.id },
                                                }"
                                                class="btn btn-primary"
                                            >
                                                <i
                                                    v-html="
                                                        $feather.icons[
                                                            'edit'
                                                        ].toSvg({
                                                            width: 24,
                                                            height: 24,
                                                        })
                                                    "
                                                ></i>
                                            </router-link>
                                            <router-link
                                                :to="{
                                                    name: 'edit-recommendation',
                                                    params: { id: book.id },
                                                }"
                                                class="btn btn-success"
                                            >
                                                <i
                                                    v-html="
                                                        $feather.icons[
                                                            'eye'
                                                        ].toSvg({
                                                            width: 24,
                                                            height: 24,
                                                        })
                                                    "
                                                ></i>
                                            </router-link>
                                            <button
                                                class="btn btn-danger"
                                                @click="deleteBook(book.id)"
                                            >
                                                <i
                                                    v-html="
                                                        $feather.icons[
                                                            'trash'
                                                        ].toSvg({
                                                            width: 24,
                                                            height: 24,
                                                        })
                                                    "
                                                ></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <button
                            type="button"
                            class="btn btn-info"
                            @click="onClickNewTechRecomm()"
                        >
                            <i
                                v-html="
                                    $feather.icons['file-plus'].toSvg({
                                        width: 24,
                                        height: 24,
                                    })
                                "
                            ></i>
                            Recommendation
                        </button>
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
            items: [],
        };
    },
    created() {
        this.$axios
            .get("/sanctum/csrf-cookie")
            .then(() => {
                const token = localStorage.getItem("token");
                if (token) {
                    this.$axios.defaults.headers.common[
                        "Authorization"
                    ] = `Bearer ${token}`;
                }

                this.$axios
                    .get("api/tech/recomm")
                    .then((response) => {
                        this.items = response.data;
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
            .catch(function (error) {
                console.error(error);
            });
    },
    methods: {
        deleteBook(id) {
            this.$axios.get("/sanctum/csrf-cookie").then((response) => {
                this.$axios
                    .delete(`/api/tech/recomm/${id}`)
                    .then((response) => {
                        let i = this.items.map((item) => item.id).indexOf(id); // find index of your object
                        this.items.splice(i, 1);
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            });
        },
        onClickNewTechRecomm: function () {
            this.$router.push("/recommendation/add");
        },
    },
};
</script>
