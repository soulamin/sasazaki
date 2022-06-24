/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaGrupo = null;

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
    Busca_Grupo();
	});

//Botão para Editar Cliente
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	$('#ModalEditarGrupo').modal('show');
	BuscaGrupoFormulario($(this).attr("codigo"));
});

//Botão para Rseset Senha
$(document).off("click", "#btnResetarSenha");
$(document).on("click", "#btnResetarSenha", function() {
    if (confirm("Tem certeza que deseja Resetar a Senha? ")) {
       ResetarSenha($(this).attr("C"));
    }
});

//Botão para Excluir Grupo
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
			Desativa_Grupo($(this).attr("codigo"))
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
	Salva_Grupo();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	Altera_Grupo();
});

//Botão para  formulario incluir Empresa
$(document).off("click", "#btnGrupo");
$(document).on("click", "#btnGrupo", function() {
	$('#ModalIncluirGrupo').modal('show');
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

	if (tabelaBuscaGrupo != null) {
		tabelaBuscaGrupo.destroy();
		tabelaBuscaGrupo = null;
	} else {
		tabelaBuscaGrupo = $('#TabelaGrupos').DataTable({
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


function Formulario_Grupo(idGrupo) {

	$.post("../../model/Grupos.php", {
		acao : 'Formulario_Grupo',
		idGrupo: idGrupo
	}, function(data) {
	$('#ModalAlterarGrupo').modal("show");
    $("#btnResetarSenha").attr("C",data['Html']['Codigo']);
	$('#atxt_codigo').val(data['Html']['Codigo']);
    $('#atxt_login').val(data['Html']['Login']);
	$('#atxt_email').val(data['Html']['Email']);

	}, "json");

}

//busca para colocar na tabela de Grupos
function Busca_Grupo() {

	$.post("../../model/Grupos.php", {
		acao : 'Busca_Grupo',

	}, function(data) {
        tabelaBuscaGrupo.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaGrupo.row.add([data['Html'][i]['Login'],data['Html'][i]['Email'],data['Html'][i]['Nivel'],
			data['Html'][i]['Status'],data['Html'][i]['Html_Acao']]);
        }
        tabelaBuscaGrupo.draw();
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

//função para cadastrar Grupo
function Salva_Grupo() {

	$('#FrmSalvarGrupo').ajaxForm({
		url : '../../model/Grupos.php',
		data : {
			acao : 'Salva_Grupo'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				$('#ModalIncluirGrupo').modal('hide');
				Busca_Grupo();
			}
			$('.msg').html(data['Html']);
		}
	});

}

function ResetarSenha(idGrupo){

    $.post("../../model/Grupos.php", {
        acao : 'Resetar_Senha',
        idGrupo : idGrupo
    }, function(data) {
        if(data['Cod_error']==0){
          alert("Senha Redefinida para 12345");
        }
    }, "json");

}

//função para Alterar Grupo
function Altera_Grupo(){

	$.post("../../model/Grupos.php", {
		acao : 'Altera_Grupo',
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
			$('#ModalAlterarGrupo').modal("hide");
			limpacampos();
			Busca_Grupo();
		}
	}, "json");

}

function Desativa_Grupo(idGrupo){

	$.post("../../model/Grupos.php", {
		acao : 'Desativa_Grupo',
        idGrupo : idGrupo
	}, function(data) {
			if(data['cod_error']==0){
				Busca_Grupo();
			}
	}, "json");

}
