$('input[name*=nome_grupo]').rules('add', 'required');

//selecionar todos
$(".selectionarCheckboxes").click(function () {
    var checkBoxes = $(".paraSelecionar");
    checkBoxes.prop("checked", !checkBoxes.prop("checked"));
});
