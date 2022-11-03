$('input[name*=nome_utilizador]').rules('add', 'required');
$('input[name*=email]').rules('add', 'required');
$('input[name*=email]').rules('add', 'email');
$('input[name*=email]').rules("add",{"remote" :{url: '_verifica_email_editar.php',type: "post"}});
$('input[name*=pass]').rules('add', 'required');
$('select[id*=grupos]').rules('add', 'required');