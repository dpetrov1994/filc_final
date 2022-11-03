
$('input[name*=id_utilizador]').rules('add', 'required');
$('input[name*=data_inicio]').rules('add', 'dataPortuguesa');
$('input[name*=data_fim]').rules('add', 'dataPortuguesa');