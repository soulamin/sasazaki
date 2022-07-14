<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Totens</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-md btn-primary" id="btnToten">
                                    <i class="fa fa-plus"></i> Cadastro de Toten</button>
                            </div>
                            <div class="col-md-12 table-responsive text-sm"><br>

                                <table class="table table-bordered table-striped dataTable  text-sm" id="TabelaTotens">
                                    <thead class="bg-primary-gradient text-smYYYTYY">

                                        <th>Id</th>
                                        <th>Loja</th>
                                        <th>Responsavel</th>
                                        <th>Endereço</th>
                                        <th>Município</th>
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

            <div class="modal fade" id="ModalIncluirToten" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title">Cadastro de Toten </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                            <form id="FrmSalvarToten" method="post" action="" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Nome Loja</label>
                                            <input class="form-control" type="text" name='txt_nomeloja' >
                                        </div>

                                        <div class="col-md-12">
                                            <label>Nome Responsável</label>
                                            <input class="form-control" type="text" name='txt_nomeresponsavel' >
                                        </div>

                                        <div class="col-md-12">
                                            <label>Endereço</label>
                                            <textarea class="form-control" name='txt_endereco' ></textarea>
                                        </div>

                                        <div class="col-md-12">
                                            <label>Município</label><br>
                                            <select class="form-control municipio" name="txt_municipio" style="width:100%"> </select>
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
            </div>
            <!-------------------------------MODAL------------------------------------------------------------------->
            <div class="modal fade" id="ModalEditarToten" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel56" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title" id="exampleModalLabel56">Alterar Toten </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <div class="row">
                                        <div class="col-md-12">
                                            <label>Nome Loja</label>
                                            <input class="form-control" type="text" name='atxt_nomeloja' >
                                        </div>

                                        <div class="col-md-12">
                                            <label>Nome Responsável</label>
                                            <input class="form-control" type="text" name='atxt_nomerespoonsavel' >
                                        </div>

                                        <div class="col-md-12">
                                            <label>Endereço</label>
                                            <textarea class="form-control" name='atxt_endereco' ></textarea>
                                        </div>

                                        <div class="col-md-12">
                                            <label>Município</label><br>
                                            <select class="form-control municipio" name="atxt_municipio" style="width:100%"> </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Consultor </label>
                                            <select class="form-control consultor" name="atxt_consultor">
                                                <option value="1" selected>Beeid</option>       
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Segundos Away </label>
                                            <input class="form-control" type="number" min="1"  max="240" name='atxt_segundos' >
                                        </div>

                                        <div class="col-md-4">
                                            <label>Tipo</label>
                                            <select class="form-control" name="atxt_tipo">
                                                <option value="totem" selected>Totem</option>       
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label>CV Revenda </label>
                                            <select class="form-control" name="atxt_revenda">
                                                <option value="Y" >SIM</option>   
                                                <option value="N" selected>NÃO</option>        
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>CV Pbshop </label>
                                            <select class="form-control" name="atxt_pbshop">
                                                <option value="Y" >SIM</option>   
                                                <option value="N" selected>NÃO</option>        
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>CV Engenharia </label>
                                            <select class="form-control" name="atxt_engenharia">
                                                <option value="Y" >SIM</option>   
                                                <option value="N" selected>NÃO</option>        
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>CV Exportação </label>
                                            <select class="form-control" name="atxt_exportacao">
                                                <option value="Y" >SIM</option>   
                                                <option value="N" selected>NÃO</option>        
                                            </select>
                                        </div>
                        </div>
                        <div class="modal-footer">
                           
                            <button class="btn btn-lg btn-success" type="submit" id="btnAlterar"><i class="fa fa-save"></i> Alterar </button>

                        </div>
                    </div>
                </div>
            </div>
            <!-----------------------------------FIM FORMULARIO EDITAR------------------------------------------------------>
            <?php
            $hr = time();
            include '../layout/footer.php';
            echo '<script src="../../controller/TotenController.js?' . $hr . '"></script>';
            ?>