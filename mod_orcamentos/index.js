let CheckedFechados=0;
$(".csscheckbox  input[type=checkbox]").change(function() {

    CheckedFechados=0;
    $('.fechado').each(function (){
        if($(this).parent().parent().find('.csscheckbox.csscheckbox-primary input').prop('checked') == true){
            CheckedFechados++;
        }
    });

    if(CheckedFechados==0){
        $( ".dropdown-menu.dropdown-menu-right.text-left li" ).each(function( index ) {
            $( this ).show();
        });
    }else{
        $( ".dropdown-menu.dropdown-menu-right.text-left li" ).each(function( index ) {
            $( this ).hide();
        });
    }

});



function getIdDoc(id){

    $('#id_documento').val(id);

}