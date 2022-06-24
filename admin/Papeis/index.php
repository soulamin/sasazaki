<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Papéis</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-md btn-primary" id="btnPapeis">
                                    <i class="fa fa-plus"></i> Cadastro de Papéis</button>
                            </div>
                            <div class="col-md-12 table-responsive text-sm"><br>

                                <table class="table table-bordered table-striped dataTable  text-sm" id="TabelaPapeis">
                                    <thead class="bg-primary-gradient text-sm">

                                        <th>Nome</th>
                                        <th>Funções</th>
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

            <div class="modal fade" id="ModalIncluirPapel" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title">Cadastro de Papéis </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="FrmSalvarPapel" method="post" action="" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Nome</label>
                                        <input class="form-control" type="text" name='txt_nome' required>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Selecione os Tipos de Funcionalidades </label>
                                        <select class="selectmultiplo funcionalidade" name="txt_funcao[]" style="width:100%" multiple="multiple">
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-md btn-success" type="submit" id="btnSalvar"><i class="fa fa-save"></i> Salvar </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-------------------------------MODAL------------------------------------------------------------------->
            <div class="modal fade" id="ModalEditarPapel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel56" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title" id="exampleModalLabel56">Alterar Papéis </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="FrmAlterarPapel" method="post" action="" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Nome</label>
                                        <input class="form-control" type="text" name='atxt_nome' required>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Selecione os Tipos de Funcionalidades </label>
                                        <select class="selectmultiplo funcionalidade" name="atxt_funcao[]" style="width:100%" multiple="multiple">
                                        </select>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-lg btn-success" type="submit" id="btnAlterar"><i class="fa fa-save"></i> Alterar </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-----------------------------------FIM FORMULARIO EDITAR------------------------------------------------------>
            <?php
            $hr = time();
            include '../layout/footer.php';
            echo '<script src="../../controller/PapelController.js?' . $hr . '"></script>';
            ?>