/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaAtualizacao = null;

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
    Busca_Atualizacao();
	});

//Botão para Editar Cliente
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	
	$('#ModalEditarAtualizacao').modal('show');
	Formulario_Atualizacao($(this).attr("codigo"));
});

//Botão para Rseset Senha
$(document).off("click", "#btnResetarSenha");
$(document).on("click", "#btnResetarSenha", function() {
    if (confirm("Tem certeza que deseja Resetar a Senha? ")) {
       ResetarSenha($(this).attr("C"));
    }
});

//Botão para Excluir Atualizacao
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
			Desativa_Atualizacao($(this).attr("codigo"))
        }
      })
			
});

//Mostra e Esconde  a Senha
$("#Txt_Mostra").on("ifToggled",function() {
	$('#Txt_Senha').toggle();
});


//Botão para Salvar Cadastro
$(document).off("click", "#btnAtualizaApi");
$(document).on("click", "#btnAtualizaApi", function() {
	AtualizaDados();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	Altera_Atualizacao();
});

//Botão para  formulario incluir Empresa
$(document).off("click", "#btnAtualizacao");
$(document).on("click", "#btnAtualizacao", function() {
	$('#ModalIncluirAtualizacao').modal('show');
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

	if (tabelaBuscaAtualizacao != null) {
		tabelaBuscaAtualizacao.destroy();
		tabelaBuscaAtualizacao = null;
	} else {
		tabelaBuscaAtualizacao = $('#TabelaAtualizacao').DataTable({
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


function Formulario_Atualizacao(idAtualizacao) {

	$.post("../../model/Atualizacao.php", {
		acao : 'Formulario_Atualizacao',
		idAtualizacao: idAtualizacao
	}, function(data) {
	$('#ModalEditarAtualizacao').modal("show");
	$('#atxt_codigo').val(data['Html']['Codigo']);
    $('#atxt_nome').val(data['Html']['Nome']);
	$('#atxt_funcao').val(data['Html']['Funcao']);

	}, "json");

}

//busca para colocar na tabela de Atualizacao
function Busca_Atualizacao() {

	$.post("../../model/Atualizacao.php", {
		acao : 'Busca_Atualizacao',

	}, function(data) {
        tabelaBuscaAtualizacao.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaAtualizacao.row.add([data['Html'][i]['Login'],data['Html'][i]['DataHora']]);
        }
        tabelaBuscaAtualizacao.draw();
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





//função para Alterar Atualizacao
function AtualizaDados(){
	$('#ModalCarregandoAtualizacao').modal('show');

	$.post("../../model/Atualiza_api.php", {
        acao : 'atualiza_api'
    }, function(data) {
		if(data['cod_error'] == 0){
			Salva_Atualizacao();	
		}
    }, "json");

}

function Salva_Atualizacao(){
	
	$.post("../../model/Atualizacao.php", {
		acao : 'Salva_Atualizacao'
	}, function(data) {
		
			if(data['cod_error']==0){
				
				Busca_Atualizacao();
				const fechaloading = setTimeout(fechamodal, 5000);
			}
	}, "json");

}

function fechamodal(){
	$('#ModalCarregandoAtualizacao').modal('hide');
}
