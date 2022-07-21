<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title ">Atualiza Dados</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-md btn-primary" id="btnAtualizaApi">
                                    <i class="fa fa-refresh"></i> Atualiza Dados</button>
                            </div>
                            <div class="col-md-12 table-responsive text-sm"><br>

                                <table class="table table-bordered table-striped dataTable  text-sm" id="TabelaAtualizacao">
                                    <thead class="bg-primary-gradient text-sm">

                                        <th>Login</th>
                                        <th>Data/Hora Atualização</th>
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

            <div class="modal fade "  id="ModalCarregandoAtualizacao" tabindex="-1" role="dialog" data-backdrop="static">
                <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title">Mensagem</h5>
                          
                        </div>
                        <div class="modal-body">
                            <div class="row"> 
                                <div class="col-md-12 text-center text-lg blink" >
                                <b class="blink">AGUARDE, ATUALIZANDO DADOS ...</b>
                                </div>
                                 
                            </div>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-------------------------------MODAL------------------------------------------------------------------->
            <div class="modal fade" id="ModalEditarAtualizacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel56" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title" id="exampleModalLabel56">Alterar Atualizacao </h5>
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
            echo '<script src="../../controller/AtualizaController.js?' . $hr . '"></script>';
            ?>