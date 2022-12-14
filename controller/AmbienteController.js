/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaAmbiente = null;

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
    Busca_Ambiente();
	});

//Botão para Editar Cliente
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	
	$('#ModalEditarAmbiente').modal('show');
	Formulario_Ambiente($(this).attr("codigo"));
});

//Botão para Rseset Senha
$(document).off("click", "#btnResetarSenha");
$(document).on("click", "#btnResetarSenha", function() {
    if (confirm("Tem certeza que deseja Resetar a Senha? ")) {
       ResetarSenha($(this).attr("C"));
    }
});

//Botão para Excluir Ambiente
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
			Desativa_Ambiente($(this).attr("codigo"))
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
	Salva_Ambiente();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	Altera_Ambiente();
});

//Botão para  formulario incluir Empresa
$(document).off("click", "#btnAmbiente");
$(document).on("click", "#btnAmbiente", function() {
	$('#ModalIncluirAmbiente').modal('show');
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

	if (tabelaBuscaAmbiente != null) {
		tabelaBuscaAmbiente.destroy();
		tabelaBuscaAmbiente = null;
	} else {
		tabelaBuscaAmbiente = $('#TabelaAmbientes').DataTable({
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


function Formulario_Ambiente(idAmbiente) {

	$.post("../../model/Ambientes.php", {
		acao : 'Formulario_Ambiente',
		idAmbiente: idAmbiente
	}, function(data) {
	$('#ModalEditarAmbiente').modal("show");
	$('#atxt_codigo').val(data['Html']['Codigo']);
    $('#atxt_nome').val(data['Html']['Nome']);
	$('#atxt_funcao').val(data['Html']['Funcao']);

	}, "json");

}

//busca para colocar na tabela de Ambientes
function Busca_Ambiente() {

	$.post("../../model/Ambientes.php", {
		acao : 'Busca_Ambiente',

	}, function(data) {
        tabelaBuscaAmbiente.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaAmbiente.row.add([data['Html'][i]['Codigo'],data['Html'][i]['Nome']]);
        }
        tabelaBuscaAmbiente.draw();
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

//função para cadastrar Ambiente
function Salva_Ambiente() {

	$('#FrmSalvarAmbiente').ajaxForm({
		url : '../../model/Ambientes.php',
		data : {
			acao : 'Salva_Ambiente'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				msgalerta("",data['msg'],"success");
				$('#ModalIncluirAmbiente').modal('hide');
				Busca_Ambiente();
			}else{
				msgalerta("Atenção",data['msg'],"warning");
			}
			
		}
	});

}

function ResetarSenha(idAmbiente){

    $.post("../../model/Ambientes.php", {
        acao : 'Resetar_Senha',
        idAmbiente : idAmbiente
    }, function(data) {
        if(data['Cod_error']==0){
          alert("Senha Redefinida para 12345");
        }
    }, "json");

}

//função para Alterar Ambiente
function Altera_Ambiente(){
	$('#FrmAlterarAmbiente').ajaxForm({
		url : '../../model/Ambientes.php',
		data : {
			acao : 'Altera_Ambiente'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				msgalerta("",data['msg'],"success");
				$('#ModalEditarAmbiente').modal('hide');
				Busca_Ambiente();
			}else{
				msgalerta("Atenção",data['msg'],"warning");
			}	
		}
	});
}

function Desativa_Ambiente(idAmbiente){

	$.post("../../model/Ambientes.php", {
		acao : 'Desativa_Ambiente',
        idAmbiente : idAmbiente
	}, function(data) {
			if(data['cod_error']==0){
				Busca_Ambiente();
			}
	}, "json");

}
