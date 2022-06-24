/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaFuncionalidade = null;

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
    Busca_Funcionalidade();
	});

//Botão para Editar Cliente
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	
	$('#ModalEditarFuncionalidade').modal('show');
	Formulario_Funcionalidade($(this).attr("codigo"));
});

//Botão para Rseset Senha
$(document).off("click", "#btnResetarSenha");
$(document).on("click", "#btnResetarSenha", function() {
    if (confirm("Tem certeza que deseja Resetar a Senha? ")) {
       ResetarSenha($(this).attr("C"));
    }
});

//Botão para Excluir Funcionalidade
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
			Desativa_Funcionalidade($(this).attr("codigo"))
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
	Salva_Funcionalidade();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	Altera_Funcionalidade();
});

//Botão para  formulario incluir Empresa
$(document).off("click", "#btnFuncionalidade");
$(document).on("click", "#btnFuncionalidade", function() {
	$('#ModalIncluirFuncionalidade').modal('show');
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

	if (tabelaBuscaFuncionalidade != null) {
		tabelaBuscaFuncionalidade.destroy();
		tabelaBuscaFuncionalidade = null;
	} else {
		tabelaBuscaFuncionalidade = $('#TabelaFuncionalidades').DataTable({
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


function Formulario_Funcionalidade(idfuncionalidade) {

	$.post("../../model/Funcionalidades.php", {
		acao : 'Formulario_Funcionalidade',
		idfuncionalidade: idfuncionalidade
	}, function(data) {
	$('#ModalEditarFuncionalidade').modal("show");
	$('#atxt_codigo').val(data['Html']['Codigo']);
    $('#atxt_nome').val(data['Html']['Nome']);
	$('#atxt_funcao').val(data['Html']['Funcao']);

	}, "json");

}

//busca para colocar na tabela de Funcionalidades
function Busca_Funcionalidade() {

	$.post("../../model/Funcionalidades.php", {
		acao : 'Busca_Funcionalidade',

	}, function(data) {
        tabelaBuscaFuncionalidade.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaFuncionalidade.row.add([data['Html'][i]['Nome'],data['Html'][i]['Funcao'],
			data['Html'][i]['Status'],data['Html'][i]['Html_Acao']]);
        }
        tabelaBuscaFuncionalidade.draw();
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

//função para cadastrar Funcionalidade
function Salva_Funcionalidade() {

	$('#FrmSalvarFuncionalidade').ajaxForm({
		url : '../../model/Funcionalidades.php',
		data : {
			acao : 'Salva_Funcionalidade'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				msgalerta("",data['msg'],"success");
				$('#ModalIncluirFuncionalidade').modal('hide');
				Busca_Funcionalidade();
			}else{
				msgalerta("Atenção",data['msg'],"warning");
			}
			
		}
	});

}

function ResetarSenha(idFuncionalidade){

    $.post("../../model/Funcionalidades.php", {
        acao : 'Resetar_Senha',
        idFuncionalidade : idFuncionalidade
    }, function(data) {
        if(data['Cod_error']==0){
          alert("Senha Redefinida para 12345");
        }
    }, "json");

}

//função para Alterar Funcionalidade
function Altera_Funcionalidade(){
	$('#FrmAlterarFuncionalidade').ajaxForm({
		url : '../../model/Funcionalidades.php',
		data : {
			acao : 'Altera_Funcionalidade'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				msgalerta("",data['msg'],"success");
				$('#ModalEditarFuncionalidade').modal('hide');
				Busca_Funcionalidade();
			}else{
				msgalerta("Atenção",data['msg'],"warning");
			}	
		}
	});
}

function Desativa_Funcionalidade(idFuncionalidade){

	$.post("../../model/Funcionalidades.php", {
		acao : 'Desativa_Funcionalidade',
        idFuncionalidade : idFuncionalidade
	}, function(data) {
			if(data['cod_error']==0){
				Busca_Funcionalidade();
			}
	}, "json");

}
