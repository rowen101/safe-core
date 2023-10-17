import api from "../app/services/api";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useStorage } from '@vueuse/core'

export const useSettingStore = defineStore('SettingStore', () => {
    const setting = ref({
        app_name: '',
    });

    const theme = useStorage('SettingStore:theme', ref('light'));

    const changeTheme = () => {
        theme.value = theme.value === 'light' ? 'dark' : 'light';
    };

    const getSetting = async () => {
        await api.instance.get('/settings')
            .then((response) => {
                setting.value = response.data;
            });
    };

    return { setting, getSetting, theme, changeTheme };
});
