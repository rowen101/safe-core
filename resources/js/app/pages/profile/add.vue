<template>
    <div>
        <h4 class="text-center">Add Book</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addBook">
                    <div class="form-group">
                        <label>Name</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="book.name"
                        />
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="book.author"
                        />
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Add Book
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import api from "../../services/api";
export default {
    data() {
        return {
            book: {},
        };
    },
    methods: {
        addBook() {
            // this.$axios.get("/sanctum/csrf-cookie").then((response) => {
            //     api.instance
            //         .post("/api/books/add", this.book)
            //         .then((resp) => {
            //             console.log(resp);
            //         })
            //         .catch((err) => {
            //             api.httpMsg(self, err.status, err.data);
            //         });
            // });
             const token = localStorage.getItem("token"); // Get the token from localStorage
            this.$axios.get("/sanctum/csrf-cookie").then((response) => {
                this.$axios
                    .post("/api/books/add", this.book, {
                        headers: {
                            Authorization: `Bearer ${token}`, // Include the token in the request headers
                        },
                    })
                    .then((response) => {
                        this.$router.push({ name: "books" });
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            });
        },
    },
};
</script>
