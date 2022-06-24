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
    Busca_GrupoToten();
    Combobox_Totem();
	});

//Botão para Editar Cliente
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	$('#ModalEditarGrupoToten').modal('show');
	Formulario_GrupoToten($(this).attr("codigo"));
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
			Desativa_GrupoToten($(this).attr("codigo"))
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
	Salva_GrupoTotens();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	Altera_GrupoTotens();
});

//Botão para  formulario incluir Empresa
$(document).off("click", "#btnGrupoToten");
$(document).on("click", "#btnGrupoToten", function() {
	arrtotem=[];
	$('#ModalIncluirGrupoTotens').modal('show');
});

//Botão para Retornar
$(document).off("click", "#btnRetornar");
$(document).on("click", "#btnRetornar", function() {
	retornarpagina();
});
//Botão para Adicionaer no totem 
$(document).off("click", "#btnaddtotem");
$(document).on("click", "#btnaddtotem", function() {
	AddArrtotem($('.listatotens').val(),$('.listatotens').find(":selected").text());
});

//Botão para Salvar Cadastro
$(document).off("click", ".btnexcluirselecionado");
$(document).on("click", ".btnexcluirselecionado", function() {
	removeArrTotem($(this).attr('cod'));
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
		tabelaBuscaToten = $('#TabelaGrupoTotens').DataTable({
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


function Combobox_Totem() {
	$.post('../../model/Totens.php', {
		acao : 'Combobox_Totem'
	}, function(data) {
		$('.listatotens').html(data['Html']);
	}, "json");
}

function Formulario_GrupoToten(idgrupototen) {

	$.post("../../model/GrupoTotens.php", {
		acao : 'Formulario_GrupoToten',
		idgrupototen: idgrupototen
	}, function(data) {
	$('#ModalEditarGrupoToten').modal("show");
	$('#atxt_codigo').val(data['Html']['Codigo']);
    $('#atxt_login').val(data['Html']['nome']);
	$('#atxt_email').val(data['Html']['Email']);

	}, "json");

}

//busca para colocar na tabela de Totens
function Busca_GrupoToten() {

	$.post("../../model/GrupoTotens.php", {
		acao : 'Busca_GrupoToten',

	}, function(data) {
        tabelaBuscaToten.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaToten.row.add([data['Html'][i]['NomeGrupo'],data['Html'][i]['Totens'],
			data['Html'][i]['Status'],data['Html'][i]['Html_Acao']]);
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
function Salva_GrupoTotens() {

	$('#FrmSalvarGrupoTotens').ajaxForm({
		url : '../../model/GrupoTotens.php',
		data : {
			acao : 'Salva_GrupoTotens'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				$('#ModalIncluirGrupoTotens').modal('hide');
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

function Desativa_GrupoToten(idgrupototen){

	$.post("../../model/GrupoTotens.php", {
		acao : 'Desativa_GrupoToten',
        idgrupototen : idgrupototen
	}, function(data) {
			if(data['cod_error']==0){
				Busca_GrupoToten();
			}
	}, "json");

}

function AddArrtotem(vltipopessoa ,texto){
	if(arrtotem.includes(vltipopessoa)== false ){
		arrtotem.push(vltipopessoa);
		console.log(arrtotem)
		 let indice = arrtotem.indexOf(vltipopessoa) ;
		var etiqueta = '<div class="row" id="to'+indice+'" ><span class="col-md-8 form-control bg-gray">'+texto+'</span>'+
						'<span class="col-md-2 btn btn-sm btn-danger btnexcluirselecionado" cod="'+indice+'"><i class="fa fa-trash"></i>Excluir</span> </div>'
		
		$('.visualselec').append(etiqueta);

	}

}

function removeArrTotem(indice){
	arrtotem.splice(indice,1);
		$('#to'+indice).remove();
		console.log(indice);

}
