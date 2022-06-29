/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaCategoria = null;

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
    Busca_Categoria();
	});

//Botão para Editar Cliente
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	
	$('#ModalEditarCategoria').modal('show');
	Formulario_Categoria($(this).attr("codigo"));
});

//Botão para Rseset Senha
$(document).off("click", "#btnResetarSenha");
$(document).on("click", "#btnResetarSenha", function() {
    if (confirm("Tem certeza que deseja Resetar a Senha? ")) {
       ResetarSenha($(this).attr("C"));
    }
});

//Botão para Excluir Categoria
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
			Desativa_Categoria($(this).attr("codigo"))
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
	Salva_Categoria();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	Altera_Categoria();
});

//Botão para  formulario incluir Empresa
$(document).off("click", "#btnCategoria");
$(document).on("click", "#btnCategoria", function() {
	$('#ModalIncluirCategoria').modal('show');
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

	if (tabelaBuscaCategoria != null) {
		tabelaBuscaCategoria.destroy();
		tabelaBuscaCategoria = null;
	} else {
		tabelaBuscaCategoria = $('#TabelaCategorias').DataTable({
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


function Formulario_Categoria(idCategoria) {

	$.post("../../model/Categorias.php", {
		acao : 'Formulario_Categoria',
		idCategoria: idCategoria
	}, function(data) {
	$('#ModalEditarCategoria').modal("show");
	$('#atxt_codigo').val(data['Html']['Codigo']);
    $('#atxt_nome').val(data['Html']['Nome']);
	$('#atxt_funcao').val(data['Html']['Funcao']);

	}, "json");

}

//busca para colocar na tabela de Categorias
function Busca_Categoria() {

	$.post("../../model/Categorias.php", {
		acao : 'Busca_Categoria',

	}, function(data) {
        tabelaBuscaCategoria.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaCategoria.row.add([data['Html'][i]['Codigo'],data['Html'][i]['Nome']]);
        }
        tabelaBuscaCategoria.draw();
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

//função para cadastrar Categoria
function Salva_Categoria() {

	$('#FrmSalvarCategoria').ajaxForm({
		url : '../../model/Categorias.php',
		data : {
			acao : 'Salva_Categoria'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				msgalerta("",data['msg'],"success");
				$('#ModalIncluirCategoria').modal('hide');
				Busca_Categoria();
			}else{
				msgalerta("Atenção",data['msg'],"warning");
			}
			
		}
	});

}

function ResetarSenha(idCategoria){

    $.post("../../model/Categorias.php", {
        acao : 'Resetar_Senha',
        idCategoria : idCategoria
    }, function(data) {
        if(data['Cod_error']==0){
          alert("Senha Redefinida para 12345");
        }
    }, "json");

}

//função para Alterar Categoria
function Altera_Categoria(){
	$('#FrmAlterarCategoria').ajaxForm({
		url : '../../model/Categorias.php',
		data : {
			acao : 'Altera_Categoria'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				msgalerta("",data['msg'],"success");
				$('#ModalEditarCategoria').modal('hide');
				Busca_Categoria();
			}else{
				msgalerta("Atenção",data['msg'],"warning");
			}	
		}
	});
}

function Desativa_Categoria(idCategoria){

	$.post("../../model/Categorias.php", {
		acao : 'Desativa_Categoria',
        idCategoria : idCategoria
	}, function(data) {
			if(data['cod_error']==0){
				Busca_Categoria();
			}
	}, "json");

}
