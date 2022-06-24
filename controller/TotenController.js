/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaToten = null;

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
    Busca_Toten();
	Combobox_Municipio();
	});

//Botão para Editar Cliente
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	$('#ModalEditarToten').modal('show');
	BuscaTotenFormulario($(this).attr("codigo"));
});

//Botão para Rseset Senha
$(document).off("click", "#btnResetarSenha");
$(document).on("click", "#btnResetarSenha", function() {
    if (confirm("Tem certeza que deseja Resetar a Senha? ")) {
       ResetarSenha($(this).attr("C"));
    }
});

//Botão para Excluir Toten
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
			Desativa_Toten($(this).attr("codigo"))
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
	Salva_Toten();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	Altera_Toten();
});

//Botão para  formulario incluir Empresa
$(document).off("click", "#btnToten");
$(document).on("click", "#btnToten", function() {
	$('#ModalIncluirToten').modal('show');
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

	if (tabelaBuscaToten != null) {
		tabelaBuscaToten.destroy();
		tabelaBuscaToten = null;
	} else {
		tabelaBuscaToten = $('#TabelaTotens').DataTable({
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


function Combobox_Municipio() {
	$.post('../../model/Totens.php', {
		acao : 'Combobox_Municipio'
	}, function(data) {
		$('.municipio').select2();
		$('.municipio').html(data['Html']);
		

	}, "json");
}

function Formulario_Toten(idToten) {

	$.post("../../model/Totens.php", {
		acao : 'Formulario_Toten',
		idToten: idToten
	}, function(data) {
	$('#ModalAlterarToten').modal("show");
    $("#btnResetarSenha").attr("C",data['Html']['Codigo']);
	$('#atxt_codigo').val(data['Html']['Codigo']);
    $('#atxt_login').val(data['Html']['Login']);
	$('#atxt_email').val(data['Html']['Email']);

	}, "json");

}

//busca para colocar na tabela de Totens
function Busca_Toten() {

	$.post("../../model/Totens.php", {
		acao : 'Busca_Toten',

	}, function(data) {
        tabelaBuscaToten.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaToten.row.add([data['Html'][i]['Id'],data['Html'][i]['Loja'],data['Html'][i]['Responsavel'],data['Html'][i]['Endereco'],
			data['Html'][i]['Municipio'],data['Html'][i]['Status'],data['Html'][i]['Html_Acao']]);
        }
        tabelaBuscaToten.draw();
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

//função para cadastrar Toten
function Salva_Toten() {

	$('#FrmSalvarToten').ajaxForm({
		url : '../../model/Totens.php',
		data : {
			acao : 'Salva_Toten'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				$('#ModalIncluirToten').modal('hide');
				Busca_Toten();
				msgalerta("",data['msg'],"success")
			}else{
				msgalerta("Atenção",data['msg'],"warning")
			}
			
		}
	});

}



//função para Alterar Toten
function Altera_Toten(){
	$('#FrmAlterarToten').ajaxForm({
		url : '../../model/Totens.php',
		data : {
			acao : 'Altera_Toten'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				$('#ModalIncluirToten').modal('hide');
				Busca_Toten();
				msgalerta("",data['msg'],"success")
			}else{
				msgalerta("Atenção",data['msg'],"warning")
			}
			
		}
	});

}

function Desativa_Toten(idToten){

	$.post("../../model/Totens.php", {
		acao : 'Desativa_Toten',
        idToten : idToten
	}, function(data) {
			if(data['cod_error']==0){
				Busca_Toten();
			}
	}, "json");

}
