/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaProduto = null;

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
    Busca_Produto();
	});

//Botão para Editar Cliente
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	$('#ModalEditarProduto').modal('show');
	BuscaProdutoFormulario($(this).attr("codigo"));
});

//Botão para Rseset Senha
$(document).off("click", "#btnResetarSenha");
$(document).on("click", "#btnResetarSenha", function() {
    if (confirm("Tem certeza que deseja Resetar a Senha? ")) {
       ResetarSenha($(this).attr("C"));
    }
});

//Botão para Excluir Produto
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
			Desativa_Produto($(this).attr("codigo"))
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
	Salva_Produto();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	Altera_Produto();
});

//Botão para  formulario incluir Empresa
$(document).off("click", "#btnProduto");
$(document).on("click", "#btnProduto", function() {
	$('#ModalIncluirProduto').modal('show');
	Combobox_GrupoTotens();
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

	if (tabelaBuscaProduto != null) {
		tabelaBuscaProduto.destroy();
		tabelaBuscaProduto = null;
	} else {
		tabelaBuscaProduto = $('#TabelaProdutos').DataTable({
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


function Formulario_Produto(idProduto) {

	$.post("../../model/Produtos.php", {
		acao : 'Formulario_Produto',
		idProduto: idProduto
	}, function(data) {
	$('#ModalAlterarProduto').modal("show");
    $("#btnResetarSenha").attr("C",data['Html']['Codigo']);
	$('#atxt_codigo').val(data['Html']['Codigo']);
    $('#atxt_login').val(data['Html']['Login']);
	$('#atxt_email').val(data['Html']['Email']);

	}, "json");

}

//busca para colocar na tabela de Produtos
function Busca_Produto() {

	$.post("../../model/Produtos.php", {
		acao : 'Busca_Produto',

	}, function(data) {
        tabelaBuscaProduto.clear();
        for (var i = 0; i < data['Html'].length; i++) {

            



            tabelaBuscaProduto.row.add([data['Html'][i]['CodigoProduto'],data['Html'][i]['CodigoSasazaki'],
            data['Html'][i]['CodigoSKUPai'],data['Html'][i]['Descricao'],data['Html'][i]['CodigoLinha'],
            data['Html'][i]['NomeLinha'],data['Html'][i]['Largura'],data['Html'][i]['Altura'],data['Html'][i]['Fotos']]);
        }
        tabelaBuscaProduto.draw();
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

//função para cadastrar Produto
function Salva_Produto() {

	$('#FrmSalvarProduto').ajaxForm({
		url : '../../model/Produtos.php',
		data : {
			acao : 'Salva_Produto'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				$('#ModalIncluirProduto').modal('hide');
				Busca_Produto();
			}
			$('.msg').html(data['Html']);
		}
	});

}

function ResetarSenha(idProduto){

    $.post("../../model/Produtos.php", {
        acao : 'Resetar_Senha',
        idProduto : idProduto
    }, function(data) {
        if(data['Cod_error']==0){
          alert("Senha Redefinida para 12345");
        }
    }, "json");

}

//função para Alterar Produto
function Altera_Produto(){

	$.post("../../model/Produtos.php", {
		acao : 'Altera_Produto',
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
			$('#ModalAlterarProduto').modal("hide");
			limpacampos();
			Busca_Produto();
		}
	}, "json");

}

function Desativa_Produto(idProduto){

	$.post("../../model/Produtos.php", {
		acao : 'Desativa_Produto',
        idProduto : idProduto
	}, function(data) {
			if(data['cod_error']==0){
				Busca_Produto();
			}
	}, "json");

}

function Combobox_GrupoTotens() {
	$.post('../../model/GrupoTotens.php', {
		acao : 'Combobox_GrupoTotens'
	}, function(data) {
		$('.grupototens').html(data['Html']);
	}, "json");
}