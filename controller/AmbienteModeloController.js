/*=======================================================================================
 *
 *
 * VARIABLE
 *
 *
 =======================================================================================*/
var tabelaBuscaAmbiente_Modelo = null;

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
    Busca_AmbienteModelo();
    Combobox_Ambiente();
    Combobox_Modelo();
	});

//Botão para Editar Cliente
$(document).off("click", "#btnEditar");
$(document).on("click", "#btnEditar", function() {
	$(".msg").empty();
	$('#ModalEditarAmbiente_Modelo').modal('show');
	Formulario_Ambiente_Modelo($(this).attr("codigo"));
});

//Botão para Rseset Senha
$(document).off("click", "#btnResetarSenha");
$(document).on("click", "#btnResetarSenha", function() {
    if (confirm("Tem certeza que deseja Resetar a Senha? ")) {
       ResetarSenha($(this).attr("C"));
    }
});

//Botão para Excluir Ambiente_Modelo
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
			Desativa_Ambiente_Modelo($(this).attr("codigo"))
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
	Salva_AmbienteModelo();
});

//Botão para Alterar Cadastro
$(document).off("click", "#btnAlterar");
$(document).on("click", "#btnAlterar", function() {
	Altera_Ambiente_Modelos();
});

//Botão para  formulario incluir Empresa
$(document).off("click", "#btnAmbiente_Modelo");
$(document).on("click", "#btnAmbiente_Modelo", function() {
	arrtotem=[];
	$('#ModalIncluirAmbiente_Modelos').modal('show');
    Combobox_Ambiente();
    Combobox_Modelo();
});

//Botão para Retornar
$(document).off("click", "#btnRetornar");
$(document).on("click", "#btnRetornar", function() {
	retornarpagina();
});
//Botão para Adicionaer no totem 
$(document).off("click", "#btnaddtotem");
$(document).on("click", "#btnaddtotem", function() {
	AddArrtotem($('.listaAmbiente_Modelos').val(),$('.listaAmbiente_Modelos').find(":selected").text());
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

	if (tabelaBuscaAmbiente_Modelo != null) {
		tabelaBuscaAmbiente_Modelo.destroy();
		tabelaBuscaAmbiente_Modelo = null;
	} else {
		tabelaBuscaAmbiente_Modelo = $('#TabelaAmbiente_Modelo').DataTable({
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


function Combobox_Ambiente() {
	$.post('../../model/AmbientesModelos.php', {
		acao : 'Combobox_Ambiente'
	}, function(data) {
		$('.comboambiente').html(data['Html']);
	}, "json");
}

function Combobox_Modelo() {
	$.post('../../model/AmbientesModelos.php', {
		acao : 'Combobox_Modelo'
	}, function(data) {
		$('.listamodelo').html(data['Html']);
	}, "json");
}

function Formulario_Ambiente_Modelo(idAmbiente_Modelo) {

	$.post("../../model/Ambiente_Modelos.php", {
		acao : 'Formulario_Ambiente_Modelo',
		idAmbiente_Modelo: idAmbiente_Modelo
	}, function(data) {
	$('#ModalEditarAmbiente_Modelo').modal("show");
	$('#atxt_codigo').val(data['Html']['Codigo']);
    $('#atxt_login').val(data['Html']['nome']);
	$('#atxt_email').val(data['Html']['Email']);

	}, "json");

}

//busca para colocar na tabela de Ambiente_Modelos
function Busca_AmbienteModelo() {

	$.post("../../model/AmbientesModelos.php", {
		acao : 'Busca_AmbienteModelo',

	}, function(data) {
        tabelaBuscaAmbiente_Modelo.clear();
        for (var i = 0; i < data['Html'].length; i++) {
            tabelaBuscaAmbiente_Modelo.row.add([data['Html'][i]['NomeAmbiente'],data['Html'][i]['CodigoAmbiente'],
            data['Html'][i]['NomeModelo'],data['Html'][i]['CodigoModelo'],
			data['Html'][i]['Html_Acao']]);
        }
        tabelaBuscaAmbiente_Modelo.draw();
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

//função para cadastrar Ambiente_Modelo
function Salva_AmbienteModelo() {

	$('#FrmSalvar_AmbienteModelo').ajaxForm({
		url : '../../model/AmbientesModelos.php',
		data : {
			acao : 'Salva_AmbienteModelo'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				$('#ModalIncluirAmbiente_Modelos').modal('hide');
				Busca_AmbienteModelo();
				msgalerta("",data['msg'],"success")
			}else{
				msgalerta("Atenção",data['msg'],"warning")
			}
			
		}
	});

}



//função para Alterar Ambiente_Modelo
function Altera_Ambiente_Modelo(){
	$('#FrmAlterarAmbiente_Modelo').ajaxForm({
		url : '../../model/Ambiente_Modelos.php',
		data : {
			acao : 'Altera_Ambiente_Modelo'
		},
		dataType : 'json',
		success : function(data) {
			if (data['cod_error'] == 0) {
				limpacampos();
				$('#ModalIncluirAmbiente_Modelo').modal('hide');
				Busca_Ambiente_Modelo();
				msgalerta("",data['msg'],"success")
			}else{
				msgalerta("Atenção",data['msg'],"warning")
			}
			
		}
	});

}

function Desativa_Ambiente_Modelo(idAmbiente_Modelo){

	$.post("../../model/Ambiente_Modelos.php", {
		acao : 'Desativa_Ambiente_Modelo',
        idAmbiente_Modelo : idAmbiente_Modelo
	}, function(data) {
			if(data['cod_error']==0){
				Busca_Ambiente_Modelo();
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
