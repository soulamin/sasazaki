import * as React from "react";
import Table from "@mui/material/Table";
import { TableHead } from "@mui/material";
import TableBody from "@mui/material/TableBody";
import TableCell from "@mui/material/TableCell";
import TableContainer from "@mui/material/TableContainer";
import TableFooter from "@mui/material/TableFooter";
import TablePagination from "@mui/material/TablePagination";
import TableRow from "@mui/material/TableRow";
import { TextField } from "@mui/material";
import Typography from "@mui/material/Typography";
import Paper from "@mui/material/Paper";
import Grid from "@mui/material/Grid";
import FormControl from "@mui/material/FormControl";
import InputLabel from "@mui/material/InputLabel";
import Select from "@mui/material/Select";
import Button from "@mui/material/Button";
import Checkbox from "@mui/material/Checkbox";
import { MenuItem } from "@mui/material";
import cloneDeep from "lodash.clonedeep";
import moment from "moment";
import Api from "../Api";

export default function Produtos() {
  const [page, setPage] = React.useState(0);
  const [rowsPerPage, setRowsPerPage] = React.useState(5);
  const [selectedTotem, setSelectedTotem] = React.useState(0);
  const [products, setProducts] = React.useState([]);
  const [totens, setTotens] = React.useState([]);
  const [nomeBusca, setNomeBusca] = React.useState("");
  const [codigoBusca, setCodigoBusca] = React.useState("");
  const [recall, setRecall] = React.useState(false);
  const [checkAll, setCheckAll] = React.useState(false);
  const [searchFilter, setSearchFilter] = React.useState(0);
  const [productsBackup, setProductsBackup] = React.useState([]);

  const handleChangePage = (event, newPage) => {
    setPage(newPage);
  };

  const handleChangeRowsPerPage = (event) => {
    setRowsPerPage(parseInt(event.target.value, 10));
    setPage(0);
  };

  const updateProduct = async (product, update) => {
    const arrayProduct = [];
    const productObj = {
      codigoproduto: product.codigo_produto,
      idtotem: selectedTotem,
      situacao: update.ativo_produto
        ? update.ativo_produto
        : product.ativo_produto,
      maisvendido: update.mais_vendido_produto
        ? update.mais_vendido_produto
        : product.mais_vendido_produto,
      lancamento: update.lancamento_produto
        ? update.lancamento_produto
        : product.lancamento_produto,
    };

    arrayProduct.push(productObj);
    await Api.post("cadastro-produto/update-produtos-totem", arrayProduct);
    setPage(0);
    setRecall(!recall);
  };

  const updateProducts = async (ativo) => {
    const arrayProduct = [];
    products.map((product) => {
      const productObj = {
        codigoproduto: product.codigo_produto,
        idtotem: selectedTotem,
        situacao: ativo ? "1" : "0",
        maisvendido: product.mais_vendido_produto,
        lancamento: product.lancamento_produto,
      };
      if (product.isSelected) {
        arrayProduct.push(productObj);
      }
    });
    await Api.post("cadastro-produto/update-produtos-totem", arrayProduct);
    setPage(0);
    setRecall(!recall);
  };

  const changeProductsSelect = (checked, product) => {
    const newArray = products.map((obj) => {
      if (obj.codigo_produto === product.codigo_produto) {
        obj.isSelected = checked;
      }
      return obj;
    });
    setProducts(newArray);
  };

  React.useEffect(() => {
    const filterTable = () => {
      if (searchFilter === 0 && nomeBusca !== "") {
        const newProducts = productsBackup.filter((product) => {
          return product.nome_produto
            .toLowerCase()
            .includes(nomeBusca.toLowerCase());
        });
        setProducts(newProducts);
      } else {
        if (searchFilter === 0 && nomeBusca === "") {
          setProducts(productsBackup);
        }
      }

      if (searchFilter === 1 && codigoBusca !== "") {
        const newProducts = productsBackup.filter((product) => {
          return product.codigo_produto
            .toLowerCase()
            .includes(codigoBusca.toLowerCase());
        });
        setProducts(newProducts);
      } else {
        if (searchFilter === 1 && codigoBusca === "") {
          setProducts(productsBackup);
        }
      }
    };
    setCheckAll(false);
    filterTable();
  }, [nomeBusca, codigoBusca, searchFilter]);

  React.useEffect(() => {
    const selectedArray = products
      .slice(
        page * rowsPerPage,
        page * rowsPerPage +
          (rowsPerPage !== -1 ? rowsPerPage : products.length)
      )
      .map((obj) => {
        obj.isSelected = checkAll;

        return obj;
      });
    const newArray = products.map((obj) => {
      const found = selectedArray.find(
        (x) => x.codigo_produto === obj.codigo_produto
      );
      if (found) {
        obj.isSelected = found.isSelected;
      }
      return obj;
    });
    setProducts(newArray);
    console.log("products", products, "backup", productsBackup);
  }, [checkAll]);

  React.useEffect(() => {
    Api.get("/cadastro-totem")
      .then((res) => {
        setTotens(res.data);
      })
      .catch((err) => {
        alert("ops! ocorreu um erro" + err);
      });
  }, []);

  React.useEffect(() => {
    const getProducts = (selectedTotem) => {
      Api.get("produto-totem/" + selectedTotem)
        .then((res) => {
          const productsArray = [];
          res.data.map((x) =>
            productsArray.push({
              ...x,
              isSelected: false,
            })
          );
          const productsArrayBackup = cloneDeep(productsArray);
          setProductsBackup(productsArrayBackup);
          setProducts(productsArray);
        })
        .catch((err) => {
          alert("Ops! ocorreu um erro: " + err.response.data.message);
        });
    };
    if (selectedTotem !== 0) {
      setCheckAll(false);
      getProducts(selectedTotem);
    }
  }, [selectedTotem, recall]);

  React.useEffect(() => {
    setCheckAll(false);
    setProducts(productsBackup);
  }, [page, rowsPerPage]);

  return totens ? (
    <Grid container sx={{ mb: 10 }}>
      <Grid container alignItems="center" sx={{ my: 2.5 }}>
        <Grid item xs={2}>
          <FormControl sx={{ width: "100%" }}>
            <InputLabel id="totem">Totem</InputLabel>
            <Select
              value={selectedTotem}
              onChange={(event) => {
                setSelectedTotem(event.target.value);
              }}
              id="totem"
              labelId="totem"
              label="totem Login"
              name="totem"
            >
              <MenuItem value={0}>Selecionar Totem</MenuItem>
              {totens.map((item) => {
                return (
                  <MenuItem key={item.id} value={item.id}>
                    {item.nome}
                  </MenuItem>
                );
              })}
            </Select>
          </FormControl>
        </Grid>
        <Grid item xs={2} sx={{ ml: 2.5 }}>
          <FormControl sx={{ width: "100%" }}>
            <InputLabel id="filtrar-pesquisa">Filtrar Pesquisa</InputLabel>
            <Select
              name="Filtrar Pesquisa"
              id="filtrar-pesquisa"
              labelId="filtrar-pesquisa"
              label="filtrar pesquisa"
              value={searchFilter}
              onChange={(event) => {
                setSearchFilter(event.target.value);
              }}
            >
              <MenuItem value={0}>Nome do Produto</MenuItem>
              <MenuItem value={1}>Código do Produto</MenuItem>
            </Select>
          </FormControl>
        </Grid>
        <Grid item xs={2}>
          {searchFilter === 0 ? (
            <TextField
              id="outlined-basic"
              label="Buscar por Nome"
              variant="outlined"
              onChange={(event) => {
                setNomeBusca(event.target.value);
              }}
              sx={{ ml: 2 }}
            />
          ) : (
            <TextField
              id="outlined-basic"
              label="Buscar por Código"
              variant="outlined"
              onChange={(event) => {
                setCodigoBusca(event.target.value);
              }}
              sx={{ ml: 2 }}
            />
          )}
        </Grid>
      </Grid>
      <Grid container sx={{ mb: 5 }}>
        <Grid item xs={2}>
          <Grid item xs={12}>
            <Typography variant="h6" sx={{ mb: 2 }}>
              Produto Ativo
            </Typography>
            <Button
              onClick={() => {
                updateProducts(true);
              }}
              variant="contained"
              color="info"
              size="medium"
            >
              Ativar
            </Button>
            <Button
              onClick={() => {
                updateProducts(false);
              }}
              variant="contained"
              color="info"
              size="medium"
              sx={{ ml: 2 }}
            >
              Desativar
            </Button>
          </Grid>
        </Grid>
      </Grid>
      <TableContainer component={Paper}>
        <Table sx={{ minWidth: 650 }} size="small" aria-label="a dense table">
          <TableHead>
            <TableRow>
              <TableCell
                sx={{
                  backgroundColor: "#eaeaea",
                  fontWeight: "bold",
                }}
              >
                <Checkbox
                  checked={checkAll}
                  onChange={() => {
                    setCheckAll(!checkAll);
                  }}
                />
              </TableCell>
              <TableCell
                sx={{
                  backgroundColor: "#eaeaea",
                  fontWeight: "bold",
                }}
              >
                Código do Produto
              </TableCell>
              <TableCell
                sx={{
                  backgroundColor: "#eaeaea",
                  fontWeight: "bold",
                }}
                align="center"
              >
                Nome
              </TableCell>
              <TableCell
                sx={{
                  backgroundColor: "#eaeaea",
                  fontWeight: "bold",
                }}
                align="center"
              >
                Data de Atualização
              </TableCell>
              <TableCell
                sx={{
                  backgroundColor: "#eaeaea",
                  fontWeight: "bold",
                }}
                align="center"
              >
                Ativo
              </TableCell>
              <TableCell
                sx={{
                  backgroundColor: "#eaeaea",
                  fontWeight: "bold",
                }}
                align="center"
              >
                Mais Vendido
              </TableCell>
              <TableCell
                sx={{
                  backgroundColor: "#eaeaea",
                  fontWeight: "bold",
                }}
                align="center"
              >
                Lançamento
              </TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {products
              ? products
                  .slice(
                    page * rowsPerPage,
                    page * rowsPerPage +
                      (rowsPerPage !== -1 ? rowsPerPage : products.length)
                  )
                  .map((product, index) => {
                    return (
                      <TableRow
                        key={"productsTable" + index}
                        sx={{
                          "&:last-child td, &:last-child th": { border: 0 },
                        }}
                      >
                        <TableCell>
                          <Checkbox
                            checked={product.isSelected}
                            onChange={(event) => {
                              changeProductsSelect(
                                event.target.checked,
                                product
                              );
                            }}
                          />
                        </TableCell>
                        <TableCell component="th" scope="row">
                          {product.codigo_produto}
                        </TableCell>
                        <TableCell align="center">
                          {product.nome_produto}
                        </TableCell>
                        <TableCell align="center">
                          {moment(product.data_atualizacao_produto).format(
                            "llll"
                          )}
                        </TableCell>
                        <TableCell align="center" justify="center">
                          <Grid container justifyContent="center">
                            <Grid item>
                              <Checkbox
                                checked={product.ativo_produto === "1"}
                                onChange={() => {
                                  updateProduct(product, {
                                    ativo_produto:
                                      product.ativo_produto === "1" ? "0" : "1",
                                  });
                                }}
                              />
                            </Grid>
                          </Grid>
                        </TableCell>
                        <TableCell align="center">
                          <Grid container justifyContent="center">
                            <Grid item>
                              <Checkbox
                                checked={product.mais_vendido_produto === "1"}
                                onChange={() => {
                                  updateProduct(product, {
                                    mais_vendido_produto:
                                      product.mais_vendido_produto === "1"
                                        ? "0"
                                        : "1",
                                  });
                                }}
                              />
                            </Grid>
                          </Grid>
                        </TableCell>
                        <TableCell align="center">
                          <Grid container justifyContent="center">
                            <Grid item>
                              <Checkbox
                                checked={product.lancamento_produto === "1"}
                                onChange={() => {
                                  updateProduct(product, {
                                    lancamento_produto:
                                      product.lancamento_produto === "1"
                                        ? "0"
                                        : "1",
                                  });
                                }}
                              />
                            </Grid>
                          </Grid>
                        </TableCell>
                      </TableRow>
                    );
                  })
              : null}
          </TableBody>
          <TableFooter>
            <TableRow>
              <TablePagination
                rowsPerPageOptions={[5, 10, 25, { label: "All", value: -1 }]}
                colSpan={3}
                onPageChange={handleChangePage}
                count={products ? products.length : 0}
                rowsPerPage={rowsPerPage}
                onRowsPerPageChange={handleChangeRowsPerPage}
                page={page}
                SelectProps={{
                  inputProps: {
                    "aria-label": "rows per page",
                  },
                  native: true,
                }}
              />
            </TableRow>
          </TableFooter>
        </Table>
      </TableContainer>
    </Grid>
  ) : null;
}
