/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaUsuario = null;

$(".Telefone").inputmask("(99)9999-9999");
$(".Cpf").inputmask("999.999.999-99");
$("#txtDataAte").inputmask("99/99/9999");
//$('.SenhaMostrar').hide();
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
//inicializa a tabela
$(document).ready(function() {
	instanciaTabelaBusca();
    Busca_Usuario();
	});

//Botão para Editar Cliente
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	$('#ModalEditarUsuario').modal('show');
	BuscaUsuarioFormulario($(this).attr("codigo"));
});

//Botão para Rseset Senha
$(document).off("click", "#btnResetarSenha");
$(document).on("click", "#btnResetarSenha", function() {
    if (confirm("Tem certeza que deseja Resetar a Senha? ")) {
       ResetarSenha($(this).attr("C"));
    }
});

//Botão para Excluir Usuario
$(document).off("click", "#btnDesativar");
$(document).on("click", "#btnDesativar", function() {
	Swal.fire({
        customClass: {
            confirmButton: 'btn btn-md btn-success',
            cancelButton: 'btn btn-md btn-danger'
          },
        buttonsStyling: false,
        text: "Tem certeza que deseja desativar?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não',
      }).then((result) => {
        if (result.isConfirmed) {
			Desativa_Usuario($(this).attr("codigo"))
        }
      })
			
});

//Mostra e Esconde  a Senha
$("#Txt_Mostra").on("ifToggled",function() {
	$('#Txt_Senha').toggle();
});


//Botão para Salvar Cadastro
$(document).off("click", "#btnSalvar");
$(document).on("click", "#btnSalvar", function() {
	Salva_Usuario();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	Altera_Usuario();
});

//Botão para  formulario incluir Empresa
$(document).off("click", "#btnUsuario");
$(document).on("click", "#btnUsuario", function() {
	$('#ModalIncluirUsuario').modal('show');
});

//Botão para Retornar
$(document).off("click", "#btnRetornar");
$(document).on("click", "#btnRetornar", function() {
	retornarpagina();
});

/*=======================================================================================
 *
 *
 * FUNCTIONS
 *
 *
 =======================================================================================*/
function instanciaTabelaBusca() {

	if (tabelaBuscaUsuario != null) {
		tabelaBuscaUsuario.destroy();
		tabelaBuscaUsuario = null;
	} else {
		tabelaBuscaUsuario = $('#TabelaUsuarios').DataTable({
			"language": {
				"url": "https://cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json"
			},
			"responsive": true,
			"paging" : true,
			"lengthChange" : true,
			"searching" : true,
			"ordering" : true,
			"info" : true,
			"autoWidth" : true
		});
	}
}


function Formulario_Usuario(idusuario) {

	$.post("../../model/Usuarios.php", {
		acao : 'Formulario_Usuario',
		idusuario: idusuario
	}, function(data) {
	$('#ModalAlterarUsuario').modal("show");
    $("#btnResetarSenha").attr("C",data['Html']['Codigo']);
	$('#atxt_codigo').val(data['Html']['Codigo']);
    $('#atxt_login').val(data['Html']['Login']);
	$('#atxt_email').val(data['Html']['Email']);

	}, "json");

}

//busca para colocar na tabela de Usuarios
function Busca_Usuario() {

	$.post("../../model/Usuarios.php", {
		acao : 'Busca_Usuario',

	}, function(data) {
        tabelaBuscaUsuario.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaUsuario.row.add([data['Html'][i]['Login'],data['Html'][i]['Email'],data['Html'][i]['Nivel'],
			data['Html'][i]['Status'],data['Html'][i]['Html_Acao']]);
        }
        tabelaBuscaUsuario.draw();
    }, "json");
	}

//limpa os campos
function limpacampos() {
    $(".TextArea").val("");
    $(":text").val("");
    $(":password").val("");
	$(".Email").val("");
    $(".ordem").val("1");
	$("input[name~='Txt_Email']").val("");
}

//retorna na pagina anterior
function retornarpagina() {
	window.history.go(-1);
}

function CheckRadioPersonalizado(){
	$('.Senha').iCheck({
		checkboxClass: 'icheckbox_minimal-blue',
		radioClass: 'iradio_minimal-blue',
		increaseArea: '20%' // optional
		});
}

//função para cadastrar Usuario
function Salva_Usuario() {

	$('#FrmSalvarUsuario').ajaxForm({
		url : '../../model/Usuarios.php',
		data : {
			acao : 'Salva_Usuario'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				$('#ModalIncluirUsuario').modal('hide');
				Busca_Usuario();
			}
			$('.msg').html(data['Html']);
		}
	});

}

function ResetarSenha(idusuario){

    $.post("../../model/Usuarios.php", {
        acao : 'Resetar_Senha',
        idusuario : idusuario
    }, function(data) {
        if(data['Cod_error']==0){
          alert("Senha Redefinida para 12345");
        }
    }, "json");

}

//função para Alterar Usuario
function Altera_Usuario(){

	$.post("../../model/Usuarios.php", {
		acao : 'Altera_Usuario',
		ATxt_Codigo	    : $('#ATxt_Codigo').val(),
		ATxt_Nome  		: $('#ATxt_Nome').val(),
		ATxt_Login 		: $('#ATxt_Login').val(),
		ATxt_Tipo 		: $('#ATxt_Tipo').val(),
		ATxt_Telefone 	: $('#ATxt_Telefone').val(),
		ATxt_Celular 	: $('#ATxt_Celular').val(),
		ATxt_Cpf     	: $('#ATxt_Cpf').val(),
		ATxt_Email 	    : $('#ATxt_Email').val()
      
	}, function(data) {
		if (data['cod_error'] == 0) {
			$('#ModalAlterarUsuario').modal("hide");
			limpacampos();
			Busca_Usuario();
		}
	}, "json");

}

function Desativa_Usuario(idusuario){

	$.post("../../model/Usuarios.php", {
		acao : 'Desativa_Usuario',
        idusuario : idusuario
	}, function(data) {
			if(data['cod_error']==0){
				Busca_Usuario();
			}
	}, "json");

}
