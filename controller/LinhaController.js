/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaLinha = null;

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
    Busca_Linha();
	});

//Botão para Editar Cliente
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	
	$('#ModalEditarLinha').modal('show');
	Formulario_Linha($(this).attr("codigo"));
});

//Botão para Rseset Senha
$(document).off("click", "#btnResetarSenha");
$(document).on("click", "#btnResetarSenha", function() {
    if (confirm("Tem certeza que deseja Resetar a Senha? ")) {
       ResetarSenha($(this).attr("C"));
    }
});

//Botão para Excluir Linha
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
			Desativa_Linha($(this).attr("codigo"))
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
	Salva_Linha();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	Altera_Linha();
});

//Botão para  formulario incluir Empresa
$(document).off("click", "#btnLinha");
$(document).on("click", "#btnLinha", function() {
	$('#ModalIncluirLinha').modal('show');
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

	if (tabelaBuscaLinha != null) {
		tabelaBuscaLinha.destroy();
		tabelaBuscaLinha = null;
	} else {
		tabelaBuscaLinha = $('#TabelaLinhas').DataTable({
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


function Formulario_Linha(idLinha) {

	$.post("../../model/Linhas.php", {
		acao : 'Formulario_Linha',
		idLinha: idLinha
	}, function(data) {
	$('#ModalEditarLinha').modal("show");
	$('#atxt_codigo').val(data['Html']['Codigo']);
    $('#atxt_nome').val(data['Html']['Nome']);
	$('#atxt_funcao').val(data['Html']['Funcao']);

	}, "json");

}

//busca para colocar na tabela de Linhas
function Busca_Linha() {

	$.post("../../model/Linhas.php", {
		acao : 'Busca_Linha',

	}, function(data) {
        tabelaBuscaLinha.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaLinha.row.add([data['Html'][i]['Codigo'],data['Html'][i]['Nome'],
			data['Html'][i]['Conceito']]);
        }
        tabelaBuscaLinha.draw();
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

//função para cadastrar Linha
function Salva_Linha() {

	$('#FrmSalvarLinha').ajaxForm({
		url : '../../model/Linhas.php',
		data : {
			acao : 'Salva_Linha'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				msgalerta("",data['msg'],"success");
				$('#ModalIncluirLinha').modal('hide');
				Busca_Linha();
			}else{
				msgalerta("Atenção",data['msg'],"warning");
			}
			
		}
	});

}

function ResetarSenha(idLinha){

    $.post("../../model/Linhas.php", {
        acao : 'Resetar_Senha',
        idLinha : idLinha
    }, function(data) {
        if(data['Cod_error']==0){
          alert("Senha Redefinida para 12345");
        }
    }, "json");

}

//função para Alterar Linha
function Altera_Linha(){
	$('#FrmAlterarLinha').ajaxForm({
		url : '../../model/Linhas.php',
		data : {
			acao : 'Altera_Linha'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				msgalerta("",data['msg'],"success");
				$('#ModalEditarLinha').modal('hide');
				Busca_Linha();
			}else{
				msgalerta("Atenção",data['msg'],"warning");
			}	
		}
	});
}

function Desativa_Linha(idLinha){

	$.post("../../model/Linhas.php", {
		acao : 'Desativa_Linha',
        idLinha : idLinha
	}, function(data) {
			if(data['cod_error']==0){
				Busca_Linha();
			}
	}, "json");

}
