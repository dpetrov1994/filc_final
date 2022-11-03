
/**
 * ******************** jQuery vaidation **************************
 *
 * Remove espaços e enters desnecesários

 */
(function ($) {

    $.each($.validator.methods, function (key, value) {
        $.validator.methods[key] = function () {
            if(arguments.length > 0) {
                var el = $(arguments[1]);
                if(el.prop('type') != 'select-multiple' && el.prop('type') != 'file'){
                    el.val($.trim(el.val()));
                }
            }
            return value.apply(this, arguments);
        };
    });
} (jQuery));

jQuery.validator.setDefaults({ onkeyup: false  });

/**
 * ******************** traduçaõ dos date picjers **************************
 */

$.fn.datepicker.dates['en'] = {
    days: ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"],
    daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
    daysMin: ["Do", "Se", "Te", "Qu", "Qu", "Se", "Sá"],
    months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
    today: "Hoje",
    clear: "Limpar",
    format: "dd/mm/yyyy",
    titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
    weekStart: 0
};

/**
 * ******************** REDIRECIONA PARA LOCK **************************
 */