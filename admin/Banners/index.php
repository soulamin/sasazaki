<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Banners</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-md btn-primary" id="btnBanner">
                                    <i class="fa fa-plus"></i> Cadastro de Banner</button>
                            </div>
                            <div class="col-md-12 table-responsive text-sm"><br>

                                <table class="table table-bordered table-striped dataTable  text-sm" id="TabelaBanners">
                                    <thead class="bg-primary-gradient text-sm">

                                        <th>Título</th>
                                        <th>Texto</th>
                                        <th>Posição</th>
                                        <th>Imagem</th>
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

            <div class="modal fade" id="ModalIncluirBanner" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title">Cadastro de Banner </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form id="FrmSalvarBanner" method="post" action="" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Título</label>
                                            <input class="form-control" type="text" name='txt_titulo' required>
                                        </div>

                                        <div class="col-md-12">
                                            <label>Texto</label>
                                            <textarea class="form-control" name='txt_texto' required></textarea>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Posição</label>
                                            <select class="form-control" name="txt_posicao">
                                                <option value="c">Cabeçalho</option>
                                                <option value="r">Rodapé</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Ordem </label>
                                            <input class="form-control" type="number" min="1" value="1" name='txt_ordem' required>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Data Expiração </label>
                                            <input class="form-control" type="date" name='txt_dataexpiracao' required>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Imagem</label>

                                                <div class="custom-file">
                                                    <input type="file" class="form-control"  name ="txt_foto"  accept=".jpeg ,.jpg,.png">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Totem</label>
                                            <select class="selectmultiplo grupototens" name="txt_totem[]" style="width:100%"  multiple="multiple">
                                            </select>
                                        </div>
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
            <div class="modal fade" id="ModalEditarBanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel56" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title" id="exampleModalLabel56">Alterar Banner </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                            <form id="FrmAlterarBanner" method="post" action="" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Título</label>
                                            <input class="form-control" type="text" name='txt_titulo' required>
                                        </div>

                                        <div class="col-md-12">
                                            <label>Texto</label>
                                            <textarea class="form-control" name='txt_texto' required></textarea>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Posição</label>
                                            <select class="form-control" name="txt_posicao">
                                                <option value="cabeçalho">Cabeçalho</option>
                                                <option value="rodapé">Rodapé</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Ordem </label>
                                            <input class="form-control" type="number" min="1" name='text_ordem' required>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Data Expiração </label>
                                            <input class="form-control" type="date" name='text_dataexpiracao' required>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Imagem</label>

                                                <div class="custom-file">
                                                    <input type="file" class="form-control" id="exampleInputFile" accept=".jpeg ,.jpg,.png">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Totem</label>
                                            <select class="selectmultiplo grupototens" name="txt_Totem" multiple style="width:100%">
                                            </select>
                                        </div>
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
            echo '<script src="../../controller/BannerController.js?' . $hr . '"></script>';
            ?>