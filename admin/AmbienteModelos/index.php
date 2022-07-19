<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"> Ambiente_Modelo</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-md btn-primary" id="btnGrupoToten">
                                    <i class="fa fa-plus"></i> Cadastro de Ambiente_Modelo</button>
                            </div>
                            <div class="col-md-12 table-responsive text-sm"><br>

                                <table class="table table-bordered table-striped dataTable  text-sm" id="TabelaGrupoAmbiente_Modelo">
                                    <thead class="bg-primary-gradient text-sm">
                                        <th>Código Ambiente</th>
                                        <th>Nome Ambiente</th>
                                        <th>Código Modelo</th>
                                        <th>Nome Modelo</th>
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

            <div class="modal fade" id="ModalIncluirGrupoAmbiente_Modelo" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title">Cadastro de Grupo de Ambiente_Modelo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="FrmSalvarGrupoAmbiente_Modelo" method="post" action="" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Nome Grupo de Ambiente_Modelo</label>
                                        <input class="form-control" type="text" name='txt_nomegrupoAmbiente_Modelo'><br>
                                    </div>

                                    <div class="col-md-12 row" style="border: 1px solid #dddddd">
                                        <div class="col-md-12">
                                            <label class="text-lg">Adicionar Ambiente_Modelo</label><br>
                                            <select class="selectmultiplo listaAmbiente_Modelo" style="width:100%" name="txt_listatotem[]" multiple="multiple"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-md btn-success" type="submit" id="btnSalvar"><i class="fa fa-save"></i> Salvar </button>
                                </div>
                                <form>
                        </div>
                    </div>
                </div>
            </div>
            <!-------------------------------MODAL------------------------------------------------------------------->
            <div class="modal fade" id="ModalEditarGrupoToten" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel56" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title" id="exampleModalLabel56">Alterar Grupo Ambiente_Modelo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="FrmAlterarGrupoAmbiente_Modelo" method="post" action="" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Nome Grupo de Ambiente_Modelo</label>
                                        <input class="form-control" type="text" name='atxt_nomegrupoAmbiente_Modelo' id='atxt_nomegrupoAmbiente_Modelo'><br>
                                    </div>

                                    <div class="col-md-12 row" style="border: 1px solid #dddddd">
                                        <div class="col-md-12">
                                            <label class="text-lg">Adicionar Ambiente_Modelo</label><br>
                                            <select class="listaAmbiente_Modelo selectmultiplo" style="width:100%" name="txt_listatotem[]" multiple="multiple"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer text-center">
                                 
                                    <button class="btn btn-lg btn-success" type="submit" id="btnAlterar"><i class="fa fa-save"></i> Alterar </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-----------------------------------FIM FORMULARIO EDITAR------------------------------------------------------>
            <?php
            $hr = time();
            include '../layout/footer.php';
            echo '<script src="../../controller/GrupoTotenController.js?' . $hr . '"></script>';
            ?>