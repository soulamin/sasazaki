import React, { useState } from "react";
import { isAuthenticated, setAuth } from "../session/Auth";
import { TextField } from "@mui/material";
import Typography from "@mui/material/Typography";
import Grid from "@mui/material/Grid";
import { Button } from "@mui/material";
import Box from "@mui/material/Box";
import Api from "../Api";

function Home() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const handleChangeEmail = (event) => {
    setEmail(event.target.value);
  };

  const handleChangePassword = (event) => {
    setPassword(event.target.value);
  };

  const handleLogin = (event) => {
    event.preventDefault();

    const dadosLogin = new FormData(event.currentTarget);

    fetchData(dadosLogin);
  };

  const fetchData = (dadosLogin) => {
    Api.post("/login-sign-in", {
      email: dadosLogin.get("email"),
      password: dadosLogin.get("password"),
    })
      .then((response) => {
        setAuth(response.data.token);
        window.location.reload();
      })
      .catch(() => {
        alert("Usuário ou senha inválidos!");
      });
  };

  return isAuthenticated() ? (
    <div>
      <h1>Pagina inicial</h1>
    </div>
  ) : (
    <>
      <Typography variant="h4" component="h1" sx={{ m: "10px" }}>
        Login
      </Typography>
      <Grid container sx={{ justifyContent: "center" }} spacing={1}>
        <Box
          component="form"
          autoComplete="off"
          onSubmit={handleLogin}
          sx={{ margin: "25px 0", p: "20px" }}
        >
          <Grid container spacing={2} alignItems="flex-end">
            <Grid item lg={5} md={6} sx={{ width: "100%", marginTop: "10px" }}>
              <TextField
                required
                name="email"
                label="Usuário"
                variant="standard"
                value={email}
                onChange={handleChangeEmail}
                fullWidth
              />
            </Grid>
            <Grid item lg={5} md={6} sx={{ width: "100%", marginTop: "10px" }}>
              <TextField
                required
                name="password"
                label="Password"
                type="password"
                variant="standard"
                value={password}
                onChange={handleChangePassword}
                fullWidth
              />
            </Grid>
            <Grid item xs={2} sx={{ width: "100%", marginTop: "10px" }}>
              <Button
                type="submit"
                variant="contained"
                color="info"
                size="medium"
              >
                Entrar
              </Button>
            </Grid>
          </Grid>
        </Box>
      </Grid>
    </>
  );
}

export default Home;
