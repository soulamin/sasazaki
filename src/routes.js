import { Routes, Route } from "react-router-dom";
import { isAuthenticated, removeAuth } from "./session/Auth";

/*Importação das páginas*/
import Home from "./pages/Home";
import Totens from "./pages/Totens";
import Produtos from "./pages/Produtos";
import Users from "./pages/Users";
import FormUser from "./pages/UserForm";
import FormTotem from "./pages/FormTotem";
import Analytics from "./pages/Analytics";

const PrivateRoute = ({ children }) => {
  if (!isAuthenticated()) {
    removeAuth();
    window.location = "/";
  }
  return children;
};

export const Rotas = () => {
  return (
    <Routes>
      <Route exact path="/" element={<Home />} />
      <Route
        exact
        path="/totens"
        element={
          <PrivateRoute>
            <Totens />
          </PrivateRoute>
        }
      />
      <Route
        exact
        path="/produtos"
        element={
          <PrivateRoute>
            <Produtos />
          </PrivateRoute>
        }
      />
      <Route
        exact
        path="/users"
        element={
          <PrivateRoute>
            <Users />
          </PrivateRoute>
        }
      />
      <Route
        exact
        path="/user/new"
        element={
          <PrivateRoute>
            <FormUser />
          </PrivateRoute>
        }
      />
      <Route
        exact
        path="/user/edit/:id"
        element={
          <PrivateRoute>
            <FormUser />
          </PrivateRoute>
        }
      />
      <Route
        exact
        path="/totem/new"
        element={
          <PrivateRoute>
            <FormTotem />
          </PrivateRoute>
        }
      />
      <Route
        exact
        path="/totem/edit/:id"
        element={
          <PrivateRoute>
            <FormTotem />
          </PrivateRoute>
        }
      />
      <Route
        exact
        path="/analytics"
        element={
          <PrivateRoute>
            <Analytics />
          </PrivateRoute>
        }
      />
    </Routes>
  );
};
