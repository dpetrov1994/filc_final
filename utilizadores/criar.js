function mostrarPass(){
    var pass=document.getElementById("pass");
    if(pass.type=="password"){
        pass.type="text";
        document.getElementById("bnt_mostrar_pass").innerHTML=("<i class=\"fa fa-eye-slash\"></i> Esconder");
    }else{
        pass.type="password";
        document.getElementById("bnt_mostrar_pass").innerHTML=("<i class=\"fa fa-eye\"></i> Mostrar");
    }
}

$('input[name*=email]').rules("add",{
    email:true,
    required:true,
    remote : {
        url: '_verifica_email.php',
        type: "post"
    }
});
$('input[name*=nome_utilizador]').rules('add', 'required');
$('input[name*=pass]').rules('add', {
    required: true,
    minlength: 5,
    equalTo: "#pass2"
});
$('input[name*=pass2]').rules( "add", {
    required: true,
    minlength: 5,
    equalTo: "#pass"
});
$('select[id*=grupos]').rules('add', 'required');
$.ajaxSetup ({
    async: false
});


