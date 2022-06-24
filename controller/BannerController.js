/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaBanner = null;

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
    Busca_Banner();
	});

//Botão para Editar Cliente
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	$('#ModalEditarBanner').modal('show');
	BuscaBannerFormulario($(this).attr("codigo"));
});

//Botão para Rseset Senha
$(document).off("click", "#btnResetarSenha");
$(document).on("click", "#btnResetarSenha", function() {
    if (confirm("Tem certeza que deseja Resetar a Senha? ")) {
       ResetarSenha($(this).attr("C"));
    }
});

//Botão para Excluir Banner
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
			Desativa_Banner($(this).attr("codigo"))
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
	Salva_Banner();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	Altera_Banner();
});

//Botão para  formulario incluir Empresa
$(document).off("click", "#btnBanner");
$(document).on("click", "#btnBanner", function() {
	$('#ModalIncluirBanner').modal('show');
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

	if (tabelaBuscaBanner != null) {
		tabelaBuscaBanner.destroy();
		tabelaBuscaBanner = null;
	} else {
		tabelaBuscaBanner = $('#TabelaBanners').DataTable({
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


function Formulario_Banner(idBanner) {

	$.post("../../model/Banners.php", {
		acao : 'Formulario_Banner',
		idBanner: idBanner
	}, function(data) {
	$('#ModalAlterarBanner').modal("show");
    $("#btnResetarSenha").attr("C",data['Html']['Codigo']);
	$('#atxt_codigo').val(data['Html']['Codigo']);
    $('#atxt_login').val(data['Html']['Login']);
	$('#atxt_email').val(data['Html']['Email']);

	}, "json");

}

//busca para colocar na tabela de Banners
function Busca_Banner() {

	$.post("../../model/Banners.php", {
		acao : 'Busca_Banner',

	}, function(data) {
        tabelaBuscaBanner.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaBanner.row.add([data['Html'][i]['Titulo'],data['Html'][i]['Texto'],data['Html'][i]['Posicao'],
			data['Html'][i]['Imagem'],data['Html'][i]['Status'],data['Html'][i]['Html_Acao']]);
        }
        tabelaBuscaBanner.draw();
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

//função para cadastrar Banner
function Salva_Banner() {

	$('#FrmSalvarBanner').ajaxForm({
		url : '../../model/Banners.php',
		data : {
			acao : 'Salva_Banner'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				$('#ModalIncluirBanner').modal('hide');
				Busca_Banner();
			}
			$('.msg').html(data['Html']);
		}
	});

}

function ResetarSenha(idBanner){

    $.post("../../model/Banners.php", {
        acao : 'Resetar_Senha',
        idBanner : idBanner
    }, function(data) {
        if(data['Cod_error']==0){
          alert("Senha Redefinida para 12345");
        }
    }, "json");

}

//função para Alterar Banner
function Altera_Banner(){

	$.post("../../model/Banners.php", {
		acao : 'Altera_Banner',
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
			$('#ModalAlterarBanner').modal("hide");
			limpacampos();
			Busca_Banner();
		}
	}, "json");

}

function Desativa_Banner(idbanner){

	$.post("../../model/Banners.php", {
		acao : 'Desativa_Banner',
        idbanner : idbanner
	}, function(data) {
			if(data['cod_error']==0){
				Busca_Banner();
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