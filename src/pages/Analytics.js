import * as React from "react";
import Api from "../Api";
import { CSVLink } from "react-csv";
import Grid from "@mui/material/Grid";
import Box from "@mui/material/Box";
import { TablePagination } from "@mui/material";
import Table from "@mui/material/Table";
import TableBody from "@mui/material/TableBody";
import TableCell from "@mui/material/TableCell";
import TableContainer from "@mui/material/TableContainer";
import TableHead from "@mui/material/TableHead";
import TableFooter from "@mui/material/TableFooter";
import Paper from "@mui/material/Paper";
import TableRow from "@mui/material/TableRow";
import Typography from "@mui/material/Typography";
import FormControl from "@mui/material/FormControl";
import InputLabel from "@mui/material/InputLabel";
import MenuItem from "@mui/material/MenuItem";
import Select from "@mui/material/Select";
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  BarElement,
  Title,
  Tooltip,
  Legend,
} from "chart.js";
import { Bar } from "react-chartjs-2";
import Card from "@mui/material/Card";
import CardContent from "@mui/material/CardContent";
import Stack from "@mui/material/Stack";
import TextField from "@mui/material/TextField";
import moment from "moment";
import { DatePicker } from "@mui/x-date-pickers/DatePicker";
import { AdapterDateFns } from "@mui/x-date-pickers/AdapterDateFns";
import { LocalizationProvider } from "@mui/x-date-pickers/LocalizationProvider";
import { Button } from "@mui/material";
import * as momenttz from "moment-timezone";
import "moment/locale/pt-br";

ChartJS.register(
  CategoryScale,
  LinearScale,
  BarElement,
  Title,
  Tooltip,
  Legend
);

export const options = {
  indexAxis: "y",
  maintainAspectRatio: false,
  barThickness: 20,
  elements: {
    bar: {
      borderWidth: 2,
    },
  },
  responsive: true,
  plugins: {
    legend: {
      position: "bottom",
    },
  },
};

export default function Analytics() {
  momenttz.tz.setDefault("America/Sao_Paulo");
  moment.locale("pt-br");

  const [page, setPage] = React.useState(0);
  const [rowsPerPage, setRowsPerPage] = React.useState(5);
  const [totens, setTotens] = React.useState([]);
  const [selectedTotem, setSelectedTotem] = React.useState(0);
  const [dataInicial, setDataInicial] = React.useState(
    moment().startOf("month").toDate()
  );
  const [dataFinal, setDataFinal] = React.useState(
    moment().endOf("month").toDate()
  );
  const [analyticsData, setAnalyticsData] = React.useState({
    quantidadeDeAcessos: null,
    quantidadeDeQrCode: null,
    tempoMedio: null,
    taxaDesistencia: null,
    taxaConversao: null,
    qrCodeRows: [],
    graphData: null,
    produtosAnalytics: [],
  });

  const handleChangePage = (event, newPage) => {
    setPage(newPage);
  };

  const handleChangeRowsPerPage = (event) => {
    setRowsPerPage(parseInt(event.target.value, 10));
    setPage(0);
  };

  const getAnalytics = (selectedTotem, dataInicial, dataFinal) => {
    Api.get(
      "/analytics?totemId=" +
        selectedTotem +
        "&dataInicial=" +
        moment(dataInicial).utc().toISOString().substring(0, 10) +
        "&dataFinal=" +
        moment(dataFinal).startOf("day").utc().toISOString().substring(0, 10)
    )
      .then((res) => {
        setAnalyticsData(res.data.data);
      })
      .catch((err) => {
        alert("Ops! ocorreu um erro: " + err.response.data.message);
      });
  };

  React.useEffect(() => {
    Api.get("/cadastro-totem")
      .then((res) => {
        setTotens(res.data);
        getAnalytics(
          0,
          moment().startOf("month").toDate(),
          moment().endOf("month").toDate()
        );
      })
      .catch((err) => {
        alert("ops! ocorreu um erro" + err);
      });
  }, []);

  return (
    <Box sx={{ width: "100%", mb: 5 }}>
      <Stack direction="row" spacing={2}>
        <Stack direction="column" sx={{ width: "100%" }}>
          <Typography variant="h5">Filtros</Typography>
          <Grid
            container
            spacing={2}
            sx={{ margin: "10px 0", alignItems: "center" }}
          >
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
                  <MenuItem value={0}>
                    <em>Geral</em>
                  </MenuItem>
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
            <Grid item xs={2}>
              <FormControl sx={{ width: "100%" }}>
                <LocalizationProvider dateAdapter={AdapterDateFns}>
                  <DatePicker
                    label="Data Início"
                    value={dataInicial}
                    onChange={(newValue) => {
                      setDataInicial(newValue);
                    }}
                    renderInput={(params) => <TextField {...params} />}
                    inputFormat="dd/MM/yyyy"
                  />
                </LocalizationProvider>
              </FormControl>
            </Grid>
            <Grid item xs={2}>
              <FormControl sx={{ width: "100%" }}>
                <LocalizationProvider dateAdapter={AdapterDateFns}>
                  <DatePicker
                    label="Data Fim"
                    value={dataFinal}
                    onChange={(newValue) => {
                      setDataFinal(newValue);
                    }}
                    renderInput={(params) => <TextField {...params} />}
                    inputFormat="dd/MM/yyyy"
                  />
                </LocalizationProvider>
              </FormControl>
            </Grid>
            <Grid item xs={2}>
              <Button
                onClick={() =>
                  getAnalytics(selectedTotem, dataInicial, dataFinal)
                }
                variant="contained"
                color="info"
                size="medium"
              >
                Filtrar
              </Button>
            </Grid>
          </Grid>
          <Grid
            container
            sx={{
              flexDirection: "row",
              justifyContent: "space-between",
              mb: 2,
            }}
          >
            <Grid item>
              <Typography variant="h5">Produtos Mais Acessados</Typography>
            </Grid>
            <Grid item>
              <CSVLink
                data={analyticsData.produtosAnalytics}
                style={{
                  textDecoration: "none",
                  marginTop: "5px",
                }}
              >
                <Button variant="contained" color="info" size="medium">
                  Exportar Dados
                </Button>
              </CSVLink>
            </Grid>
          </Grid>

          <Stack direction="row" sx={{ height: "300px" }}>
            {analyticsData.graphData ? (
              <Bar options={options} data={analyticsData.graphData} />
            ) : null}
          </Stack>

          <Stack>
            <Grid
              container
              sx={{
                flexDirection: "row",
                justifyContent: "space-between",
                mb: 2,
              }}
            >
              <Grid item>
                <Typography variant="h5">Sessões x QR Code</Typography>
              </Grid>
              <Grid item>
                <CSVLink
                  data={analyticsData.qrCodeRows}
                  style={{
                    textDecoration: "none",
                    marginTop: "5px",
                  }}
                >
                  <Button variant="contained" color="info" size="medium">
                    Exportar Dados
                  </Button>
                </CSVLink>
              </Grid>
            </Grid>
            <TableContainer component={Paper}>
              <Table
                sx={{ minWidth: 650 }}
                size="small"
                aria-label="a dense table"
              >
                <TableHead>
                  <TableRow>
                    <TableCell
                      sx={{ backgroundColor: "#eaeaea", fontWeight: "bold" }}
                    >
                      Id
                    </TableCell>
                    <TableCell
                      sx={{ backgroundColor: "#eaeaea", fontWeight: "bold" }}
                      align="right"
                    >
                      Id Totem
                    </TableCell>
                    <TableCell
                      sx={{ backgroundColor: "#eaeaea", fontWeight: "bold" }}
                      align="right"
                    >
                      QR Code
                    </TableCell>
                    <TableCell
                      sx={{ backgroundColor: "#eaeaea", fontWeight: "bold" }}
                      align="right"
                    >
                      Data Inicial
                    </TableCell>
                    <TableCell
                      sx={{ backgroundColor: "#eaeaea", fontWeight: "bold" }}
                      align="right"
                    >
                      Data Final
                    </TableCell>
                  </TableRow>
                </TableHead>
                <TableBody>
                  {analyticsData.qrCodeRows
                    .slice(
                      page * rowsPerPage,
                      page * rowsPerPage +
                        (rowsPerPage !== -1
                          ? rowsPerPage
                          : analyticsData.qrCodeRows.length)
                    )
                    .map((row, index) => {
                      return (
                        <TableRow
                          key={"QRCodeTableRow" + index}
                          sx={{
                            "&:last-child td, &:last-child th": { border: 0 },
                          }}
                        >
                          <TableCell component="th" scope="row">
                            {row.id}
                          </TableCell>
                          <TableCell align="right"> {row.idtotem}</TableCell>
                          <TableCell title={row.qrcode} align="right">
                            {row.qrcode.substring(0, 40)}...
                          </TableCell>
                          <TableCell align="right">
                            {moment(row.datainicio).format("llll")}
                          </TableCell>
                          <TableCell align="right">
                            {moment(row.datatermino).format("llll")}
                          </TableCell>
                        </TableRow>
                      );
                    })}
                </TableBody>
                <TableFooter>
                  <TableRow>
                    <TablePagination
                      sx={{ borderTop: "1px solid #ccc" }}
                      rowsPerPageOptions={[
                        5,
                        10,
                        25,
                        { label: "All", value: -1 },
                      ]}
                      colSpan={5}
                      onPageChange={handleChangePage}
                      count={analyticsData.qrCodeRows.length}
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
          </Stack>
        </Stack>

        <Stack direction="column" spacing={3}>
          <Card sx={{ width: "300px" }}>
            <CardContent>
              <Typography
                sx={{ fontSize: 18, textAlign: "center" }}
                color="rgb(13, 83, 153)"
                gutterBottom
              >
                Quantidade de Acessos
              </Typography>
              <Typography
                sx={{ fontSize: 35, textAlign: "center" }}
                color="rgb(13, 83, 153)"
              >
                {analyticsData.quantidadeDeAcessos}
              </Typography>
            </CardContent>
          </Card>
          <Card>
            <CardContent>
              <Typography
                sx={{ fontSize: 18, textAlign: "center" }}
                color="rgb(13, 83, 153)"
                gutterBottom
              >
                Quantidade de QRCode gerados
              </Typography>
              <Typography
                sx={{ mt: 2, fontSize: 35, textAlign: "center" }}
                color="rgb(13, 83, 153)"
              >
                {analyticsData.quantidadeDeQrCode}
              </Typography>
            </CardContent>
          </Card>
          <Card>
            <CardContent>
              <Typography
                sx={{ fontSize: 18, textAlign: "center" }}
                color="rgb(13, 83, 153)"
                gutterBottom
              >
                Tempo médio de atenção
              </Typography>
              <Typography
                sx={{ mt: 2, fontSize: 35, textAlign: "center" }}
                color="rgb(13, 83, 153)"
              >
                {Math.floor(analyticsData.tempoMedio / 60) +
                  "m" +
                  (analyticsData.tempoMedio % 60) +
                  "s"}
              </Typography>
            </CardContent>
          </Card>
          <Card>
            <CardContent>
              <Typography
                sx={{ fontSize: 18, textAlign: "center" }}
                color="rgb(13, 83, 153)"
                gutterBottom
              >
                Taxa de desistência
              </Typography>
              <Typography
                sx={{ mt: 2, fontSize: 35, textAlign: "center" }}
                color="rgb(13, 83, 153)"
              >
                {analyticsData.taxaDesistencia}%
              </Typography>
            </CardContent>
          </Card>
          <Card>
            <CardContent>
              <Typography
                sx={{ fontSize: 18, textAlign: "center" }}
                color="rgb(13, 83, 153)"
                gutterBottom
              >
                Taxa de conversão
              </Typography>
              <Typography
                sx={{ mt: 2, fontSize: 35, textAlign: "center" }}
                color="rgb(13, 83, 153)"
              >
                {analyticsData.taxaConversao}%
              </Typography>
            </CardContent>
          </Card>
        </Stack>
      </Stack>
    </Box>
  );
}
