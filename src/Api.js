import axios from "axios";
import { removeAuth, getAuth } from "./session/Auth";

const Api = () => {
  const options = {
    baseURL: "http://localhost:8080/api",
  };

  let instance = axios.create(options);

  instance.interceptors.request.use((config) => {
    config.headers.Authorization = getAuth();

    return config;
  });

  instance.interceptors.response.use(
    (response) => response,
    (error) => {
      if (error && !error.response) {
        throw new Error("Tempo Excedido");
      }

      if ([401, 403].indexOf(error.response.status) === -1) {
        return Promise.reject(error);
      }

      removeAuth();

      window.location = "/";

      return Promise.reject({
        response: {
          data: {},
        },
      });
    }
  );

  return instance;
};

export default Api();
