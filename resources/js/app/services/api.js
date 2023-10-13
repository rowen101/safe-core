import axios from "axios";
import miniToastr from "mini-toastr";
miniToastr.init();

const baseURL = "api/";

const instance = axios.create({
  baseURL: baseURL,
});

// Function to set the Authorization header
function setAuthorizationHeader(token) {
  if (token) {
    instance.defaults.headers.common["Authorization"] = `Bearer ${token}`;
  }
}

// Function to fetch CSRF cookie
function fetchCsrfCookie() {
  return instance.get('/sanctum/csrf-cookie');
}

// Function to handle HTTP messages
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
  setAuthorizationHeader,
  fetchCsrfCookie,
  httpMsg,
};
