/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaPapel = null;

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
    Busca_Papel();
	});

//Botão para Editar Cliente
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	
	$('#ModalEditarPapel').modal('show');
	Formulario_Papel($(this).attr("codigo"));
});

//Botão para Rseset Senha
$(document).off("click", "#btnResetarSenha");
$(document).on("click", "#btnResetarSenha", function() {
    if (confirm("Tem certeza que deseja Resetar a Senha? ")) {
       ResetarSenha($(this).attr("C"));
    }
});

//Botão para Excluir Papel
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
			Desativa_Papel($(this).attr("codigo"))
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
	Salva_Papel();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	Altera_Papel();
});

//Botão para  formulario incluir Empresa
$(document).off("click", "#btnPapeis");
$(document).on("click", "#btnPapeis", function() {
	$('#ModalIncluirPapel').modal('show');
	Combobox_Funcionalidade();
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

	if (tabelaBuscaPapel != null) {
		tabelaBuscaPapel.destroy();
		tabelaBuscaPapel = null;
	} else {
		tabelaBuscaPapel = $('#TabelaPapeis').DataTable({
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


function Formulario_Papel(idPapel) {

	$.post("../../model/Papeis.php", {
		acao : 'Formulario_Papel',
		idPapel: idPapel
	}, function(data) {
	$('#ModalEditarPapel').modal("show");
	$('#atxt_codigo').val(data['Html']['Codigo']);
    $('#atxt_nome').val(data['Html']['Nome']);
	$('#atxt_funcao').val(data['Html']['Funcao']);

	}, "json");

}

//busca para colocar na tabela de Papeis
function Busca_Papel() {

	$.post("../../model/Papeis.php", {
		acao : 'Busca_Papel',

	}, function(data) {
        tabelaBuscaPapel.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaPapel.row.add([data['Html'][i]['Nome'],data['Html'][i]['Funcao'],
			data['Html'][i]['Status'],data['Html'][i]['Html_Acao']]);
        }
        tabelaBuscaPapel.draw();
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

//função para cadastrar Papel
function Salva_Papel() {

	$('#FrmSalvarPapel').ajaxForm({
		url : '../../model/Papeis.php',
		data : {
			acao : 'Salva_Papel'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				msgalerta("",data['msg'],"success");
				$('#ModalIncluirPapel').modal('hide');
				Busca_Papel();
			}else{
				msgalerta("Atenção",data['msg'],"warning");
			}
			
		}
	});

}

function ResetarSenha(idPapel){

    $.post("../../model/Papeis.php", {
        acao : 'Resetar_Senha',
        idPapel : idPapel
    }, function(data) {
        if(data['Cod_error']==0){
          alert("Senha Redefinida para 12345");
        }
    }, "json");

}

//função para Alterar Papel
function Altera_Papel(){
	$('#FrmAlterarPapel').ajaxForm({
		url : '../../model/Papeis.php',
		data : {
			acao : 'Altera_Papel'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				msgalerta("",data['msg'],"success");
				$('#ModalEditarPapel').modal('hide');
				Busca_Papel();
			}else{
				msgalerta("Atenção",data['msg'],"warning");
			}	
		}
	});
}

function Desativa_Papel(idPapel){

	$.post("../../model/Papeis.php", {
		acao : 'Desativa_Papel',
        idPapel : idPapel
	}, function(data) {
			if(data['cod_error']==0){
				Busca_Papel();
			}
	}, "json");

}

function Combobox_Funcionalidade() {
	$.post('../../model/Funcionalidades.php', {
		acao : 'Combobox_Funcionalidade'
	}, function(data) {
		$('.funcionalidade').html(data['Html']);
	}, "json");
}