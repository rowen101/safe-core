import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useStorage } from '@vueuse/core'
import api from "../services/api.js"

// const authUserStore = useAuthUserStore();

export const useSettingStore = defineStore('SettingStore', () => {
    const setting = ref({
        app_name: '',
    });

    const theme = useStorage('SettingStore:theme', ref('light'));

    const changeTheme = () => {
        theme.value = theme.value === 'light' ? 'dark' : 'light';
    };

    const getSetting = async () => {
        try {
            const response = await api.instance.get('settings');
            setting.value = response.data;
          } catch (error) {
            // Handle errors, log, or perform other actions as needed
            console.error(error);
          }
    };

    return { setting, getSetting, theme, changeTheme };
});
