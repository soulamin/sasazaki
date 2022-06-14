import * as React from "react";
import Button from "@mui/material/Button";
import TextField from "@mui/material/TextField";
import FormControlLabel from "@mui/material/FormControlLabel";
import Checkbox from "@mui/material/Checkbox";
import Grid from "@mui/material/Grid";
import Box from "@mui/material/Box";
import Typography from "@mui/material/Typography";
import Paper from "@mui/material/Paper";
import FormControl from "@mui/material/FormControl";
import InputLabel from "@mui/material/InputLabel";
import MenuItem from "@mui/material/MenuItem";
import Select from "@mui/material/Select";
import { useParams } from "react-router-dom";
import Api from "../Api";
import AlertError from "../components/AlertError";

import FormGroup from "@mui/material/FormGroup";

export default function FormUser() {
  let { id } = useParams();

  let [nome, setNome] = React.useState("");
  let [tipo, setTipo] = React.useState("");
  let [email, setEmail] = React.useState("");
  let [password, setPassword] = React.useState("");
  let [situacao, setSituacao] = React.useState("on");
  let [errorResponse, setErrorResponse] = React.useState(null);

  let [acao, setAcao] = React.useState("add");

  React.useEffect(() => {
    if (id !== undefined && id !== "") {
      Api.get("/cadastro-usuario/" + id)
        .then((res) => {
          setNome(res.data.nome);
          setTipo(1);
          setEmail(res.data.email);
          setSituacao(res.data.situacao === "1" ? "on" : "off");
          setAcao("edit");
        })
        .catch((err) => {
          console.error("ops! ocorreu um erro" + err);
        });
    }
  }, [id]);

  const fetchData = (dados) => {
    Api.post("/cadastro-usuario", {
      nome: dados.get("nome"),
      situacao: dados.get("situacao") ? dados.get("situacao") : "off",
      password: dados.get("password"),
      email: dados.get("email"),
    })
      .then((response) => {
        window.location.href = "/users";
      })
      .catch((err) => {
        setErrorResponse(err.response.data.message);
        console.log("err", err);
      });
  };

  const updateDate = (dados) => {
    Api.put("/cadastro-usuario/" + id, {
      id: id,
      nome: dados.get("nome"),
      situacao: dados.get("situacao") ? dados.get("situacao") : "off",
      password: dados.get("password"),
      email: dados.get("email"),
    })
      .then((response) => {
        alert(response.data.message);
        window.location.href = "/users";
      })
      .catch((err) => {
        alert("ops! ocorreu um erro" + err);
      });
  };

  const handleSubmit = (event) => {
    event.preventDefault();
    /* debugger; */
    const data = new FormData(event.currentTarget);

    if (acao === "add") {
      fetchData(data);
    } else {
      updateDate(data);
    }
  };

  const handleChange = (event) => {
    setTipo(event.target.value);
  };

  const handleChangeNome = (event) => {
    setNome(event.target.value);
  };
  const handleChangeEmail = (event) => {
    setEmail(event.target.value);
  };
  const handleChangePassword = (event) => {
    setPassword(event.target.value);
  };

  return (
    <Box
      sx={{
        marginTop: 8,
        width: "80%",
        ml: 20,
      }}
    >
      <Paper sx={{ width: "100%", mb: 2, p: 5 }}>
        <Typography component="h1" variant="h5">
          Cadastro Usuários
        </Typography>
        <Box
          component="form"
          noValidate
          autoComplete="off"
          onSubmit={handleSubmit}
        >
          <AlertError errorMessages={errorResponse} />
          <Grid container spacing={2}>
            <Grid item xs={8}>
              <TextField
                id="name"
                label="Nome"
                name="nome"
                variant="standard"
                value={nome}
                onChange={handleChangeNome}
                fullWidth
                required
              />
            </Grid>
            <Grid item xs={4}>
              <FormControl sx={{ width: "100%" }} variant="standard">
                <InputLabel id="tipo_login">Tipo Login</InputLabel>
                <Select
                  id="tipo_login"
                  labelId="tipo_login"
                  label="Tipo Login"
                  name="tipo_login"
                  value={tipo}
                  onChange={handleChange}
                >
                  <MenuItem value="">
                    <em>None</em>
                  </MenuItem>
                  <MenuItem value={1}>Tipo 1</MenuItem>
                  <MenuItem value={2}>Tipo 2</MenuItem>
                  <MenuItem value={3}>Tipo 3</MenuItem>
                </Select>
              </FormControl>
            </Grid>
            <Grid item xs={8}>
              <TextField
                id="email"
                name="email"
                label="E-mail"
                variant="standard"
                value={email}
                onChange={handleChangeEmail}
                fullWidth
                required
              />
            </Grid>
            <Grid item xs={4}>
              <TextField
                id="password"
                name="password"
                label="Password"
                variant="standard"
                type="password"
                value={password}
                onChange={handleChangePassword}
                fullWidth
                required
              />
            </Grid>
            <Grid item xs={4}>
              <FormGroup>
                <FormControlLabel
                  control={
                    <Checkbox
                      onChange={() => {
                        setSituacao(situacao === "on" ? "off" : "on");
                      }}
                      checked={situacao === "on"}
                    />
                  }
                  label="Ativo"
                  id="situacao"
                  name="situacao"
                />
              </FormGroup>
            </Grid>
            <Grid
              container
              direction="row"
              justifyContent="flex-end"
              alignItems="flex-end"
              sx={{ mt: 5 }}
            >
              <Grid item xs={1.5}>
                <Button type="submit" variant="contained">
                  Enviar
                </Button>
              </Grid>
              <Grid item xs={2}>
                <Button
                  variant="outlined"
                  onClick={() => {
                    window.history.back();
                  }}
                >
                  Cancelar
                </Button>
              </Grid>
            </Grid>
          </Grid>
        </Box>
      </Paper>
    </Box>
  );
}
