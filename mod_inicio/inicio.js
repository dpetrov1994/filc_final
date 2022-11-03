$.urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)')
        .exec(window.location.search);

    return (results !== null) ? results[1] || 0 : false;
}

if($.urlParam('open-modal-viatura') != false && $.urlParam('open-modal-viatura') == "1"){
    $('.footer-mobile-tecnicos .viaturas').trigger('click');

    var myNewURL = "mod_inicio/dashboard.php";//the new URL
    window.history.pushState({}, document.title, "/" + myNewURL );

}

  //edit

/* SEARCH NO SELECT2 SEARCH
$('body').on('keyup', '.select2-search__field', function() {
    getClientes($(this).val());
});*/

/*
$('.selectjs').select2({
    placeholder:"Pesquisa por cliente...",
    minimumInputLength:2,
    ajax:{
        url:"_getclientes.php",
        dataType:"json",
        type:"GET",
        delay:250,
        data:function (params){
            return{
                like:params.term,
            };
        },
        processResults: function(data){
            return {
                results:data
            };
        },
        cache:true
    }
})*/

