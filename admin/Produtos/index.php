<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="modal fade" id="AlterarProduto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel56" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title" id="exampleModalLabel56">Alterar Produto </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12"> 
                                        <input type="hidden" class="form-control" id='ATxt_Codigo' name='ATxt_Codigo'>
                                        <label>Nome</label>
                                        <input type="text" class="form-control" id='ATxt_Nome' name='ATxt_Nome'>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Email</label>
                                        <input class="form-control " type="email" id='ATxt_Email' name='ATxt_Email'>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Telefone</label>
                                        <input class="form-control Telefone" type="text" id='ATxt_Telefone' name='ATxt_Telefone'>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Celular </label>
                                        <input class="form-control Celular" type="text" id='ATxt_Celular' name='ATxt_Celular'>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Login </label>
                                        <input class="form-control" type="text" id='ATxt_Login' name='ATxt_Login'>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-lg btn-info" id="btnResetarSenha"><i class="fa fa-lock"></i> Resetar Senha </button>
                                <button class="btn btn-lg btn-success" type="submit" id="btnAlterar"><i class="fa fa-save"></i> Alterar </button>

                            </div>
                        </div>
                    </div>
                </div>

            <!--...................................Modal.......................................-->

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Produtos</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                           <!--  <div class="col-md-12 text-right">
                                <button class="btn btn-md btn-primary" id="btnProduto">
                                    <i class="fa fa-plus"></i> Cadastro de Produto</button>
                            </div> -->
                            <div class="col-md-12">
                                <br>
                                <table class="table table-bordered table-striped dataTable  text-sm" id="TabelaProdutos">
                                    <thead class="bg-primary-gradient text-sm">
                                        <th> C??digo Produto</th>
                                        <th>C??digo Sasazaki</th>
                                        <th>Descri????o</th>
                                        <th>C??digo SKU Pai</th>
                                        <th>C??digo Linha</th>
                                        <th>Nome Linha</th>
                                        <th>Largura</th>
                                        <th>Altura</th>
                                        <th>Fotos</th>
                                    </thead>
                                    <tbody id="conteudotabela">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!--...................................Modal.......................................-->

            <div class="modal fade" id="IncluirProduto" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title">Cadastro de Produto </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form id="FrmSalvarProduto" method="post" action="" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Nome</label>
                                            <input class="form-control" type="text" name='Txt_Nome' required>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Email</label>
                                            <input class="form-control" type="email" name='Txt_Email' required>
                                        </div>

                                       
                                        <div class="col-md-4">
                                            <label>Login</label>
                                            <input class="form-control" name='Txt_Login' required>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Senha</label>
                                            <input class="form-control" type="password" name='Txt_Senha' required>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Tipo </label>
                                            <select class="form-control TipoProduto text-uppercase" name="Txt_Tipo">
                                                <option value="A" selected>Administrador</option>
                                                <option value="U">Produto</option>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-md btn-success" type="submit" id="btnSalvar"><i class="fa fa-save"></i> Salvar </button>
                            </div>
                            </form>


                        </div>

                    </div>
                </div>
                <!-- Modal -->
                <!-----------------------------------FIM FORMULARIO EDITAR------------------------------------------------------>
                <?php
                $hr = time();
                include '../layout/footer.php';
                echo '<script src="../../controller/ProdutoController.js?'.$hr.'"></script>';
                ?>