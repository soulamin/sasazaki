/*=======================================================================================
*
*
* VARIABLE
*
*
=======================================================================================*/

/*=======================================================================================
*
*
* CALL INITIALIZE
*
*
=======================================================================================*/

/*=======================================================================================
*
*
* ACTIONS
*
*
=======================================================================================*/
$(document).ready(function(){
   // Cache.delete();
    Valida();
    $( "input[type='search']" ).val("");
    $('.selectmultiplo').select2({theme:"classic"});
 });


//Botão para Menu Principal
$(document).off("click",'.btnMenuPrincipal');
$(document).on("click",'.btnMenuPrincipal', function() {
    location.href ='../Menu';
});

//Botão para Banners
$(document).off("click",'.btnBanners');
$(document).on("click",'.btnBanners', function() {
    location.href ='../Banners';
});

//Botão para Grupo de Totens
$(document).off("click",'.btnGrupoToten');
$(document).on("click",'.btnGrupoToten', function() {
    location.href ='../GrupoTotens/';
});

//Botão para Totens
$(document).off("click",'.btnTotens');
$(document).on("click",'.btnTotens', function() {
    location.href ='../Totens/';
});

//Botão para Modelos
$(document).off("click",'.btnModelos');
$(document).on("click",'.btnModelos', function() {
      location.href ='../Modelos/';
});

//Botão para Ambientes
$(document).off("click",'.btnAmbientes');
$(document).on("click",'.btnAmbientes', function() {
      location.href ='../Ambientes/';
});

//Botão para Cliente
$(document).off("click",'.btnRelatorio');
$(document).on("click",'.btnRelatorio', function() {
    location.href ='../Relatorios/';
});


//Botão para LocalFiscal
$(document).off("click",'.btnLocalFiscal');
$(document).on("click",'.btnLocalFiscal', function() {
    location.href ='../LocalFiscal/';
});

//Botão para Gerenciar Tickts
$(document).off("click",'.btnGerenciar');
$(document).on("click",'.btnGerenciar', function() {
    location.href ='../Gerenciar/';
});

//Botão para Log Digital
$(document).off("click",'.btnTipoCliente');
$(document).on("click",'.btnTipoCliente', function() {
    location.href ='../TipoCliente/';
});



//Botão para Taxas
$(document).off("click",'.btnPapeis');
$(document).on("click",'.btnPapeis', function() {
    location.href ='../Papeis/';
});

//Botão para Funcionalidades
$(document).off("click",'.btnFuncionalidades');
$(document).on("click",'.btnFuncionalidades', function() {
    location.href ='../Funcionalidades/';
});

//Meu Ticket
$(document).off("click",'.btnMeuTicket');
$(document).on("click",'.btnMeuTicket', function() {
    location.href ='../MeuTicket/';
});

//Botão para  Informacao
$(document).off("click",'.btnInformacao');
$(document).on("click",'.btnInformacao', function() {
    location.href ='../Informacao/';
});


//Botão para Perfil
$(document).off("click",'.btnPerfil');
$(document).on("click",'.btnPerfil', function() {
    location.href ='../Perfil/';
});

//Botão para Parametros
$(document).off("click",'.btnAgendaAtualizacao');
$(document).on("click",'.btnAgendaAtualizacao', function() {
    location.href ='../AgendaAtualizacao/';
});

//Botão para btnImportProd
$(document).off("click",'.btnImportProd');
$(document).on("click",'.btnImportProd', function() {
    location.href ='../ImportProd/';
});

//Botão para Notificacao
$(document).off("click",'.btnProdutos');
$(document).on("click",'.btnProdutos', function() {
    location.href ='../Produtos/';
});

//Botão para Tipo de Pessoa
$(document).off("click",'.btnTipoPessoa');
$(document).on("click",'.btnTipoPessoa', function() {
    location.href ='../TipoPessoa/';
});

//Botão para Usuarios
$(document).off("click",'.btnUsuarios');
$(document).on("click",'.btnUsuarios', function() {
    location.href ='../Usuarios/';
});



//Botão para Analytics
$(document).off("click",'.btnAnalytics');
$(document).on("click",'.btnAnalytics', function() {
    location.href ='../Analytics/';
});




//Botão para  Taxas
$(document).off("click",'.btnAlteraSenha');
$(document).on("click",'.btnAlteraSenha', function() {
    $('#AlteraSenha').modal('show');

});
//Botão para  Altera Senha
$(document).off("click",'#BtnAltSenha');
$(document).on("click",'#BtnAltSenha', function() {
    AlteraSenhaUsuario($('#SenhaAtual').val(),$('#SenhaNova').val());

});

//Botão para Sair
$(document).off("click",'#btnSair');
$(document).on("click",'#btnSair', function() {
    Sair();

});


/*=======================================================================================
*
*
* FUNCTIONS
*
*
=======================================================================================*/


function Sair(){
    $.post("../../model/Menu.php",{
            acao : 'Sair'
        }, function(data) {
            if(data['Cod_Error']==1){
                window.location.href = "../../";
            }
        },
        "json"
    );
}

function Valida(){
    $.post("../../model/Menu.php",{
            acao : 'Validar'
        }, function(data) {
            if(data['Cod_Error']==1){
                window.location.href = "../../";
            }else{
                $(".LoginUsuario").append(data['Html']);
                $("#MenuLateral").html(data['MenuLateral']);
                $("#MenuTopoDireita").append(data['MenuTopoDireita']);
                $("#MenuTopo").append(data['MenuTopo']);
            }
        },
        "json"
    );
}

//Botão para Retornar
$(document).off("click",".olho");
$(document).on("click",".olho", function() {
    $(this).toggleClass('fa-eye fa-eye-slash');
    if ($(this).hasClass('fa-eye')){
     $(".Senha").attr("type", "text");
   }else {
       $(".Senha").attr("type", "password");
  }
         
});


function AlteraSenhaUsuario(SenhaAtual,SenhaNova){
    $.post("../model/Login.php",{
            acao : 'AlterarSenha_Usuario',
            SenhaAtual : SenhaAtual,
            SenhaNova  : SenhaNova
        }, function(data) {
            if(data['Cod_Error']==1) {

                   alert("SENHA ALTERADA COM SUCESSO!");
                    $('#SenhaAtual').val('');
                    $('#SenhaNova').val('');
                    $('#AlteraSenha').modal('hide');
            }else if(data['Cod_Error']==3){
                alert("EXISTE CAMPO VAZIO!");
            }else{
                alert("SENHA ATUAL, NÃO CONFERE DIGITADA");
                $('#SenhaAtual').val('');
                $('#SenhaNova').val('');
            }
        },
        "json"
    );
}



function msgalerta(titulo,msg,icone){
    Swal.fire({
        position: 'top-center',
        icon: icone,
        title: titulo ,
        text : msg,
        showConfirmButton: false,
        timer: 2000
      })
}

function msgconfirma(funcao){
    Swal.fire({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
        buttonsStyling: false,
        text: "Tem certeza que deseja desativar?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não',
      }).then((result) => {
        if (result.isConfirmed) {
         funcao
        }
      })
}

