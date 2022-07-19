<?php include '../layout/header.php'; ?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Usuário</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-md btn-primary" id="btnUsuario">
                                    <i class="fa fa-plus"></i> Cadastro de Usuário</button>
                            </div>
                            <div class="col-md-12 table-responsive text-sm"><br>

                                <table class="table table-bordered table-striped dataTable  text-sm" id="TabelaUsuarios">
                                    <thead class="bg-primary-gradient text-sm">

                                        <th>Login</th>
                                        <th>Email</th>
                                        <th>Tipo</th>
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

            <div class="modal fade" id="ModalIncluirUsuario" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title">Cadastro de Usuário </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form id="FrmSalvarUsuario" method="post" action="" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Login</label>
                                            <input class="form-control" type="text" name='txt_login' required>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Email</label>
                                            <input class="form-control" type="email" name='txt_email' required>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Senha</label>
                                            <input class="form-control" type="password" name='txt_senha' required>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Tipo </label>
                                            <select class="form-control TipoUsuario text-uppercase" name="txt_tipo">
                                                <option value="4" selected>Administrador</option>
                                                <option value="2">Gerente</option>
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
            </div>
            <!-------------------------------MODAL------------------------------------------------------------------->
            <div class="modal fade" id="ModalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel56" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title" id="exampleModalLabel56">Alterar Usuário </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <label>Login</label>
                                    <input class="form-control" type="text" name='txt_login' required>
                                </div>

                                <div class="col-md-6">
                                    <label>Email</label>
                                    <input class="form-control" type="email" name='txt_email' required>
                                </div>

                                <div class="col-md-6">
                                    <label>Senha</label>
                                    <input class="form-control" type="password" name='txt_senha' required>
                                </div>

                                <div class="col-md-4">
                                    <label>Tipo </label>
                                    <select class="form-control TipoUsuario text-uppercase" name="Txt_Tipo">

                                        <option value="A" selected>Administrador</option>
                                        <option value="U">Gerente</option>
                                    </select>
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
            <!-----------------------------------FIM FORMULARIO EDITAR------------------------------------------------------>
            <?php
            $hr = time();
            include '../layout/footer.php';
            echo '<script src="../../controller/UsuarioController.js?' . $hr . '"></script>';
            ?>