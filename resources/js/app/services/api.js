import axios from "axios";
import miniToastr from "mini-toastr";
miniToastr.init();

const baseURL = "api/";

const instance = axios.create({
    baseURL: baseURL,
});

// Add an interceptor to include the token in the request headers
instance.interceptors.request.use(
    (config) => {
        const userToken = localStorage.getItem("token");

        if (userToken) {
            config.headers["Authorization"] = `Bearer ${userToken}`;
        }

        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

function httpMsg(obj, statuscode, msg) {
    if (statuscode === 401) {
        obj.$store.dispatch("logout").then(() => {
            obj.$router.push("/login");
        });
    } else if (statuscode === 200) {
        miniToastr.success(msg);
    } else if (statuscode === undefined) {
        miniToastr.error("Please contact the administrator!!!");
    } else {
        miniToastr.error(msg);
    }
}

export default {
    instance,
    baseURL,
    httpMsg,
};
