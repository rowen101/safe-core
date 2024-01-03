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

    const getAuthUser = async () => {
        try {
            await axios.get('api/profile')
                .then((response) => {
                    user.value = response.data;
                });
        }
        catch (error) {
            console.error(error);
        }

    };

    return {
        user, getAuthUser,
    };
});
