export const TOKEN_KEY = "@token";

export const isAuthenticated = () => {
  const authUser = localStorage.getItem(TOKEN_KEY);
  return authUser !== null;
};

export const getToken = () => {
  const authUser = getAuth();
  return authUser && authUser.token ? authUser.token : null;
};

export const getAuth = () =>
  isAuthenticated() ? JSON.parse(localStorage.getItem(TOKEN_KEY)) : null;

export const setAuth = (authUser) => {
  localStorage.setItem(TOKEN_KEY, JSON.stringify(authUser));
};

export const removeAuth = () => {
  localStorage.removeItem(TOKEN_KEY);
  window.location.reload();
};
