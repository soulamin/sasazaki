import { createAction, createReducer } from "@reduxjs/toolkit";
import { getAuth } from "../../session/Auth";

const INITIAL_STATE = getAuth();

export const refreshUserAuth = createAction("REFRESH_USER_AUTH");

export default createReducer(INITIAL_STATE, {
  [refreshUserAuth.type]: () => getAuth(),
});
