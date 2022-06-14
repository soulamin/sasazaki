import * as React from "react";
import Button from "@mui/material/Button";
import TextField from "@mui/material/TextField";
import Grid from "@mui/material/Grid";
import Box from "@mui/material/Box";
import Typography from "@mui/material/Typography";
import Paper from "@mui/material/Paper";
import FormControl from "@mui/material/FormControl";
import InputLabel from "@mui/material/InputLabel";
import MenuItem from "@mui/material/MenuItem";
import Select from "@mui/material/Select";
import AlertError from "../components/AlertError";
import { useParams } from "react-router-dom";
import Api from "../Api";

export default function FormTotem() {
  const estados = [
    { value: "AC", label: "Acre" },
    { value: "AL", label: "Alagoas" },
    { value: "AP", label: "Amapá" },
    { value: "AM", label: "Amazonas" },
    { value: "BA", label: "Bahia" },
    { value: "CE", label: "Ceará" },
    { value: "DF", label: "Distrito Federal" },
    { value: "ES", label: "Espírito Santo" },
    { value: "GO", label: "Goías" },
    { value: "MA", label: "Maranhão" },
    { value: "MT", label: "Mato Grosso" },
    { value: "MS", label: "Mato Grosso do Sul" },
    { value: "MG", label: "Minas Gerais" },
    { value: "PA", label: "Pará" },
    { value: "PB", label: "Paraíba" },
    { value: "PR", label: "Paraná" },
    { value: "PE", label: "Pernambuco" },
    { value: "PI", label: "Piauí" },
    { value: "RJ", label: "Rio de Janeiro" },
    { value: "RN", label: "Rio Grande do Norte" },
    { value: "RS", label: "Rio Grande do Sul" },
    { value: "RO", label: "Rondônia" },
    { value: "RR", label: "Roraíma" },
    { value: "SC", label: "Santa Catarina" },
    { value: "SP", label: "São Paulo" },
    { value: "SE", label: "Sergipe" },
    { value: "TO", label: "Tocantins" },
  ];

  let [lojas, setLojas] = React.useState([]);

  const getLojas = () => {
    Api.get("/cadastro-loja")
      .then((res) => {
        setLojas(res.data);
      })
      .catch((err) => {
        alert("ops! ocorreu um erro" + err);
      });
  };

  let { id } = useParams();

  let [codigo, setCodigo] = React.useState("");
  let [nome, setNome] = React.useState("");
  let [loja, setLoja] = React.useState("");
  let [logradouro, setLograoduro] = React.useState("");
  let [bairro, setBairro] = React.useState("");
  let [cidade, setCidade] = React.useState("");
  let [estado, setEstado] = React.useState("");
  let [cep, setCep] = React.useState("");
  let [errorResponse, setErrorResponse] = React.useState(null);

  let [acao, setAcao] = React.useState("add");

  React.useEffect(() => {
    if (id !== undefined && id !== "") {
      Api.get("/cadastro-totem/" + id)
        .then((res) => {
          setCodigo(res.data.codigototem);
          setNome(res.data.nome);
          setLoja(res.data.idloja);
          setLograoduro(res.data.logradouro);
          setBairro(res.data.bairro);
          setCidade(res.data.cidade);
          setEstado(res.data.uf);
          setCep(res.data.cep);
          setAcao("edit");
        })
        .catch((err) => {
          console.error("ops! ocorreu um erro" + err);
        });
    }

    getLojas();
  }, [id]);

  const fetchData = (dados) => {
    Api.post("/cadastro-totem", {
      nome: dados.get("nome"),
      idloja: "1",
      codigototem: dados.get("codigo"),
      situacao: 1,
      cep: dados.get("cep"),
      logradouro: dados.get("logradouro"),
      bairro: dados.get("bairro"),
      cidade: dados.get("cidade"),
      uf: dados.get("estado"),
    })
      .then((response) => {
        alert(response.data.message);
        window.location.href = "/totens";
      })
      .catch((err) => {
        setErrorResponse(err.response.data);
        console.log("er", err);
      });
  };

  const updateDate = (dados) => {
    Api.put("/cadastro-totem/" + id, {
      id: id,
      nome: dados.get("nome"),
      idloja: "1",
      codigototem: dados.get("codigo"),
      situacao: 1,
      cep: dados.get("cep"),
      logradouro: dados.get("logradouro"),
      bairro: dados.get("bairro"),
      cidade: dados.get("cidade"),
      uf: dados.get("estado"),
    })
      .then((response) => {
        alert(response.data.message);
        window.location.href = "/totens";
      })
      .catch((err) => {
        alert("ops! ocorreu um erro" + err);
      });
  };

  const handleSubmit = (event) => {
    event.preventDefault();

    const data = new FormData(event.currentTarget);
    if (acao === "add") {
      fetchData(data);
    } else {
      updateDate(data);
    }
  };

  const handleChange = (event) => {
    setEstado(event.target.value);
  };

  const handleChangeCodigo = (event) => {
    setCodigo(event.target.value);
  };
  const handleChangeNome = (event) => {
    setNome(event.target.value);
  };
  const handleChangeLoja = (event) => {
    setLoja(event.target.value);
  };
  const handleChangeLog = (event) => {
    setLograoduro(event.target.value);
  };
  const handleChangeBairro = (event) => {
    setBairro(event.target.value);
  };
  const handleChangeCidade = (event) => {
    setCidade(event.target.value);
  };
  const handleChangeCep = (event) => {
    setCep(event.target.value);
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
          Cadastro Totem
        </Typography>
        <Box
          component="form"
          noValidate
          autoComplete="off"
          onSubmit={handleSubmit}
        >
          <AlertError errorMessages={errorResponse} />
          <Grid container spacing={2}>
            <Grid item xs={2}>
              <TextField
                id="codigo"
                label="Código"
                name="codigo"
                variant="standard"
                value={codigo}
                onChange={handleChangeCodigo}
                fullWidth
                required
              />
            </Grid>
            <Grid item xs={10}>
              <TextField
                id="nome"
                label="Nome"
                name="nome"
                variant="standard"
                value={nome}
                onChange={handleChangeNome}
                fullWidth
                required
              />
            </Grid>
            <Grid item xs={8}>
              <FormControl sx={{ width: "100%" }} variant="standard">
                <InputLabel id="loja">Loja</InputLabel>
                <Select
                  id="loja"
                  labelId="loja"
                  label="Loja"
                  name="loja"
                  value={loja}
                  onChange={handleChangeLoja}
                >
                  <MenuItem value="">
                    <em>None</em>
                  </MenuItem>
                  {lojas.map((loja, index) => {
                    return (
                      <MenuItem key={index} value={loja.id}>
                        {loja.nome}
                      </MenuItem>
                    );
                  })}
                </Select>
              </FormControl>
            </Grid>
            <Grid item xs={8}>
              <TextField
                id="logradouro"
                name="logradouro"
                label="Logradouro"
                variant="standard"
                value={logradouro}
                onChange={handleChangeLog}
                fullWidth
                required
              />
            </Grid>
            <Grid item xs={4}>
              <TextField
                id="bairro"
                name="bairro"
                label="Bairro"
                variant="standard"
                value={bairro}
                onChange={handleChangeBairro}
                fullWidth
                required
              />
            </Grid>
            <Grid item xs={4}>
              <TextField
                id="cidade"
                name="cidade"
                label="Cidade"
                variant="standard"
                value={cidade}
                onChange={handleChangeCidade}
                fullWidth
                required
              />
            </Grid>

            <Grid item xs={4}>
              <FormControl sx={{ width: "100%" }} variant="standard">
                <InputLabel id="estado">Estado</InputLabel>
                <Select
                  id="estado"
                  labelId="estado"
                  label="Estado"
                  name="estado"
                  value={estado}
                  onChange={handleChange}
                >
                  <MenuItem value="">
                    <em>None</em>
                  </MenuItem>
                  {estados.map((state, index) => {
                    return (
                      <MenuItem key={index} value={state.value}>
                        {state.label}
                      </MenuItem>
                    );
                  })}
                </Select>
              </FormControl>
            </Grid>
            <Grid item xs={3}>
              <TextField
                id="cep"
                name="cep"
                label="Cep"
                variant="standard"
                value={cep}
                onChange={handleChangeCep}
                fullWidth
                required
              />
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
