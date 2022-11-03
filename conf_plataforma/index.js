$('input[name*=nome_grupo]').rules('add', 'required');
$('input[name*=key]').rules('add', 'maxlength: 16');
$('input[name*=key]').rules('add', 'minlength: 16');

//selecionar todos
$(document).ready(function () {
    $(".selectionarCheckboxes").click(function () {
        var checkBoxes = $(".paraSelecionar");
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));
    });
});
