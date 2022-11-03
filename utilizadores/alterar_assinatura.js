var wrapper = document.getElementById("signature-pad");
var canvas = wrapper.querySelector("canvas");

var signaturePad = new SignaturePad(canvas, {
    backgroundColor: 'rgb(249,249,249)',
    penColor: 'rgb(16, 40, 137)'
});


var cancelButton = document.getElementById('clear');
cancelButton.addEventListener('click', function (event) {
    signaturePad.clear();
});

function resizeCanvas() {
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
    signaturePad.clear();
}
//window.onresize = resizeCanvas;
resizeCanvas();

function validarAssinatura(){

    $("#assinatura").val(signaturePad.toDataURL("image/jpeg"));
    if(signaturePad.isEmpty()){
        $("#assinatura-error").show("fast");
    }else{
        $("#assinatura-error").hide("fast");
        $("#botao_loading_original").click();
    }
}
