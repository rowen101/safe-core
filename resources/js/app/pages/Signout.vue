<script>
import api from "../services/api";
export default {
    created() {
        const token = localStorage.getItem("token"); // Get the token from localStorage

        api.instance
            .post("/logout", null, {
                // Pass null as the request body for logout
                headers: {
                    Authorization: `Bearer ${token}`, // Include the token in the request headers
                },
            })
            .then((resp) => {
                localStorage.removeItem("token");
                // Commit the logout action to clear Vuex state
                this.$store.dispatch("logout");
                // Redirect to the login page
                window.location.href = "/login"; // Replace "/login" with your login page URL
            })
            .catch((error) => {
                console.error(error);
            });
    },
};
</script>
