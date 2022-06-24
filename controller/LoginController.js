/*=======================================================================================
*
*
* VARIABLE
*
*
=======================================================================================*/
var mensagem =$("#msg");


/*=======================================================================================
*
*
* CALL INITIALIZE
*
*
=======================================================================================*/
$(document).ready(function(){
   
});


/*=======================================================================================
*
*
* ACTIONS
*
*
=======================================================================================*/

//Botão para Entrar no sistema
$(document).off("click","#btnEntrar");
$(document).on("click","#btnEntrar", function() {
    logar();
});

//Botão para Entrar no sistema
$(document).off("click","#btnSalvar");
$(document).on("click","#btnSalvar", function() {
    SalvaUsuario();
});

//Botão para Entrar no sistema
$(document).off("keypress","#btnEntrar");
$(document).on("keypress", function(event) {
	if(event.keyCode==13){
		logar();
	}
});


//Botão para Retornar
$(document).off("click","#btnretorno");
$(document).on("click","#btnretorno", function() {
 retornarpagina();
});


//Botão para Retornar
$(document).off("click",".olho");
$(document).on("click",".olho", function() {
    $(this).toggleClass('fa-eye fa-eye-slash');
    if ($(this).hasClass('fa-eye')){
     $(".Senha").attr("type", "text");
   }else {
       $(".Senha").attr("type", "password");
  }
         
});

  

/*=======================================================================================
*
*
* FUNCTIONS
*
*
=======================================================================================*/

//Entrar no sistema
function logar(){

    $('#FrmLogar').ajaxForm({
        url: 'model/Login.php',
        data: {
            acao: 'Logar',
            login: $("#Txt_Login").val(),
            senha: $("#Txt_Senha").val()
        },
        dataType : 'json',
        success : function(data) {

            if (data['Cod_Error'] == 0) {

                switch (data['Tipo']){

                    case '1' :
                            window.location.href = "admin/usuarios/";
                        break;
                    case '2' :
                        window.location.href = "admin/usuarios/";
                        break;
                    case '3' :
                        window.location.href = "admin/usuarios/";
                        break;
                    case '4' :
                        window.location.href = "admin/usuarios/";
                        break;
                   
                }


            }  else{
                limpacampos();
               msgalert("Atenção",data['html'],"warning");
            }
        }
        });
}




//função para cadastrar Usuario
function SalvaUsuario() {

	$('#FrmSalvarUsuario').ajaxForm({
		url : 'model/Usuarios.php',
		data : {
			acao : 'Salva_UsuarioCadastro'
		},
		dataType : 'json',
		success : function(data) {
			if (data['Cod_Error'] == 0) {
			
                $('#IncluirUsuario').modal('hide');
                alert("Cadastro efetuado com Sucesso");
				window.history.go(0);
			}else if(data['Cod_Error'] == 1){
                alert("Por favor preencher todos os campos");
            }else{

                alert("CPF já cadastrado.");
            }
			
		}
	});

}


//limpa os campos
function limpacampos() {
    $(":text").val("");
    $(":password").val("");
    $(":radio").prop({checked: false});
    $("input[type=text]").val("");
    $("input[type=email]").val("");
    $("input[type=password]").val("");
    $("input[type=number]").val("");
    $("input[type=date]").val("");

}

function EsqueciSenha(email){
    $.post("model/Usuarios.php", {
		acao : 'EsqueciaSenha',
		Email : email
	}, function(data) {
       
           if(data['Cod_Error']=='1'){
            $('#EsqueciaSenha').modal('hide'); 
              alert("Não Encontramos esse Email cadastrado.");
              
           }else{
            $('#EsqueciaSenha').modal('hide'); 
             alert("Foi enviado um Email com seu Usuário e Senha Cadastrado");
           }
           window.history.go(0);
           limpacampos();
	}, "json");

}


//validar CPF
function ValidaCPF(strCPF) {
    var Soma;
    var Resto;
    Soma = 0;
    //strCPF  = RetiraCaracteresInvalidos(strCPF,11);
    if (strCPF == "00000000000" || strCPF == "11111111111" )
        return false;
    for (i=1; i<=9; i++)
        Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;
    if ((Resto == 10) || (Resto == 11))
        Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) )
        return false;
    Soma = 0;
    for (i = 1; i <= 10; i++)
        Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;
    if ((Resto == 10) || (Resto == 11))
        Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) )
        return false;
    return true;
}

function msgalert(titulo, msg,icone){
    Swal.fire({
        position: 'top-center',
        icon: icone,
        title: titulo ,
        text : msg,
        showConfirmButton: false,
        timer: 2000
      })
}