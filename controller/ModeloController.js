/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaModelo = null;

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
    Busca_Modelo();
	});

//Botão para Editar Cliente
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	
	$('#ModalEditarModelo').modal('show');
	Formulario_Modelo($(this).attr("codigo"));
});

//Botão para Rseset Senha
$(document).off("click", "#btnResetarSenha");
$(document).on("click", "#btnResetarSenha", function() {
    if (confirm("Tem certeza que deseja Resetar a Senha? ")) {
       ResetarSenha($(this).attr("C"));
    }
});

//Botão para Excluir Modelo
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
			Desativa_Modelo($(this).attr("codigo"))
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
	Salva_Modelo();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	Altera_Modelo();
});

//Botão para  formulario incluir Empresa
$(document).off("click", "#btnModelo");
$(document).on("click", "#btnModelo", function() {
	$('#ModalIncluirModelo').modal('show');
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

	if (tabelaBuscaModelo != null) {
		tabelaBuscaModelo.destroy();
		tabelaBuscaModelo = null;
	} else {
		tabelaBuscaModelo = $('#TabelaModelos').DataTable({
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


function Formulario_Modelo(idModelo) {

	$.post("../../model/Modelos.php", {
		acao : 'Formulario_Modelo',
		idModelo: idModelo
	}, function(data) {
	$('#ModalEditarModelo').modal("show");
	$('#atxt_codigo').val(data['Html']['Codigo']);
    $('#atxt_nome').val(data['Html']['Nome']);
	$('#atxt_funcao').val(data['Html']['Funcao']);

	}, "json");

}

//busca para colocar na tabela de Modelos
function Busca_Modelo() {

	$.post("../../model/Modelos.php", {
		acao : 'Busca_Modelo',

	}, function(data) {
        tabelaBuscaModelo.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaModelo.row.add([data['Html'][i]['Nome'],data['Html'][i]['Codigo'],
			data['Html'][i]['Descricao'],data['Html'][i]['Diferencial'],data['Html'][i]['Categoria']]);
        }
        tabelaBuscaModelo.draw();
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

//função para cadastrar Modelo
function Salva_Modelo() {

	$('#FrmSalvarModelo').ajaxForm({
		url : '../../model/Modelos.php',
		data : {
			acao : 'Salva_Modelo'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				msgalerta("",data['msg'],"success");
				$('#ModalIncluirModelo').modal('hide');
				Busca_Modelo();
			}else{
				msgalerta("Atenção",data['msg'],"warning");
			}
			
		}
	});

}

function ResetarSenha(idModelo){

    $.post("../../model/Modelos.php", {
        acao : 'Resetar_Senha',
        idModelo : idModelo
    }, function(data) {
        if(data['Cod_error']==0){
          alert("Senha Redefinida para 12345");
        }
    }, "json");

}

//função para Alterar Modelo
function Altera_Modelo(){
	$('#FrmAlterarModelo').ajaxForm({
		url : '../../model/Modelos.php',
		data : {
			acao : 'Altera_Modelo'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				msgalerta("",data['msg'],"success");
				$('#ModalEditarModelo').modal('hide');
				Busca_Modelo();
			}else{
				msgalerta("Atenção",data['msg'],"warning");
			}	
		}
	});
}

function Desativa_Modelo(idModelo){

	$.post("../../model/Modelos.php", {
		acao : 'Desativa_Modelo',
        idModelo : idModelo
	}, function(data) {
			if(data['cod_error']==0){
				Busca_Modelo();
			}
	}, "json");

}
