import axios from 'axios';
import { defineStore } from 'pinia';
import { ref } from 'vue';
import api from "../services/api.js"
export const useAuthUserStore = defineStore('AuthUserStore', () => {
    const user = ref({
        id: '',
        name: '',
        email: '',
        role: '',
        avatar: '',
        first_name: '',
        last_name: '',
        gender: ''
    });

    const token = ref(localStorage.getItem("token") || "");

    const setToken = (newToken) => {
        token.value = localStorage.setItem('token', newToken)
    };

    const getToken = () => {
        token.value = localStorage.getItem('token');
    };


    const getAuthUser = async () => {
        try {
            await api.instance.get('profile')
                .then((response) => {
                    user.value = response.data;
                });
        }
        catch (error) {
            console.error(error);
        }

    };

    return {
        user, getAuthUser, setToken, token, getToken,// Add your getters here
        get isLoggedIn() {
            return !!this.token;
        },
    };
});
