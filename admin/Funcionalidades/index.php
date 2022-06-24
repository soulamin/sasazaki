<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Funcionalidades</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-md btn-primary" id="btnFuncionalidade">
                                    <i class="fa fa-plus"></i> Cadastro de Funcionalidades</button>
                            </div>
                            <div class="col-md-12 table-responsive text-sm"><br>

                                <table class="table table-bordered table-striped dataTable  text-sm" id="TabelaFuncionalidades">
                                    <thead class="bg-primary-gradient text-sm">
                                        <th>Nome</th>
                                        <th>Função</th>
                                        <th>Status</th>
                                        <th>Ação</th>
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

            <div class="modal fade" id="ModalIncluirFuncionalidade" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title">Cadastro de Funcionalidades </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <form id="FrmSalvarFuncionalidade" method="post" action="" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Nome</label>
                                            <input class="form-control" type="text" name='txt_nome' required>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Função</label>
                                            <input class="form-control" type="text" name='txt_funcao' required>
                                        </div>
                                    </div>
                            <div class="modal-footer text-center">
                                <button class="btn btn-md btn-success" type="submit" id="btnSalvar"><i class="fa fa-save"></i> Salvar </button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-------------------------------MODAL------------------------------------------------------------------->
            <div class="modal fade" id="ModalEditarFuncionalidade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel56" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title" id="exampleModalLabel56">Alterar Funcionalidades </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <form id="FrmAlterarFuncionalidade" method="post" action="" enctype="multipart/form-data">

                            <div class="row">
                            <input class="form-control" type="hidden" name='atxt_codigo'  id='atxt_codigo' required>

                                <div class="col-md-12">
                                    <label>Nome</label>
                                    <input class="form-control" type="text" name='atxt_nome'  id='atxt_nome'required>
                                </div>

                                <div class="col-md-12">
                                    <label>Função</label>
                                    <input class="form-control" type="text" name='atxt_funcao' id='atxt_funcao' required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button class="btn btn-lg btn-success btn-md" type="submit" id="btnAlterar"><i class="fa fa-save"></i> Alterar </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <!-----------------------------------FIM FORMULARIO EDITAR------------------------------------------------------>
            <?php
            $hr = time();
            include '../layout/footer.php';
            echo '<script src="../../controller/FuncionalidadeController.js?' . $hr . '"></script>';
            ?>