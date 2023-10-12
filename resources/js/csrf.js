import axios from 'axios';

export function setCsrfCookie() {
  return axios.get('/sanctum/csrf-cookie');
}
