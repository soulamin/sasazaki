import { configureStore } from "@reduxjs/toolkit";
import AuthReducer from "./auth/AuthReducer.js";

export default configureStore({
  reducer: {
    auth: AuthReducer,
  },
});
