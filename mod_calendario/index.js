/*
 *  Document   : compCalendar.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Calendar page
 */


function mostraModalDetalhesEvento(id_evento) {
    $('#modal-detalhes-evento').modal('toggle');
    $('#modal-detalhes-evento-content').html("<div class='modal-body text-center'><i class='fa fa-2x fa-asterisk fa-spin text-primary'></i></div>");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            $('#modal-detalhes-evento-content').html(this.responseText);
            initforms();
        }
    };

    xmlhttp.open("GET", "_calendario_get_detalhes_tarefa.php?id_agenda=" + id_evento, true);


    xmlhttp.send();
}


$('#calendar').fullCalendar({
    header: {
        left: 'month,agendaWeek,agendaDay',
        center: 'title',
        right: 'today, prev,next'
    },
    selectable: true,
    firstDay: 1,
    editable: false,
    droppable: false,
    aspectRatio: 1,
    minTime: "06:00:00",
    maxTime: "24:00:00",
    /*
    dayClick: function(date, jsEvent, view) {

        if($(this).hasClass("bg-info")){
            var data_inicio=date.format('YYYY-MM-DD');
            $('#data_fim').val(data_inicio);
            console.log(date);
            $('#modal-criar-assistencia').modal('toggle');
        }else{

            $(".bg-info").find('small').remove();
            $(".bg-info").removeClass("bg-info");

            $(this).addClass('bg-info');
            $(this).append('<small>&nbsp;&nbsp;<i class="fa fa-calendar-plus-o"></i> Adicionar</small>');
        }
    },
    eventClick: function(calEvent, jsEvent, view) {
        mostraModalDetalhesEvento(calEvent.id);
    },
    */
    eventSources: [
        // your event source
        {
            url: '../mod_calendario/_calendario_get_eventos.php',
            type: 'GET',

            error: function(xhr, ajaxOptions, thrownError) {
                alert('there was an error while fetching events!'+xhr.responseText);
            }
        }
        // any other sources...

    ]
});

function refresh_calendar(){
    $('#calendar').fullCalendar('refetchEvents');
}


function initforms(){
    $('.nav-tabs a').click(function(){
        $(this).tab('show');
    });
    $("#desativar-inputs input").prop("readonly", true);
    $("#desativar-inputs input[type=checkbox]").prop("disabled", true);
    $("#desativar-inputs input[type=file]").prop("disabled", true);
    $("#desativar-inputs select").prop("disabled", true);
    $("#desativar-inputs textarea").prop("readonly", true);
    $("#desativar-inputs .csscheckbox > span").addClass("disabledCheckbox");
    $(".select-select2").select2();

    $('.input-datepicker').datepicker({
        todayHighlight: true
    });

    $('.input-timepicker24').timepicker({
        minueventop: 5,
        showMeridian: false,
        showSecond: false,
        showMillisec: false
    });
    $('.input-colorpicker').colorpicker({format: 'hex'});

    if(document.getElementById("form-editar-este")){
        $('#form-editar-este').validate({
            errorClass: 'help-block animation-slideUp', // You can change the animation class for a different entrance animation - check animations page
            errorElement: 'small',
            errorPlacement: function(error, e) {
                if(e.parent().hasClass("bootstrap-timepicker")){
                    e.parent().parent().append(error);
                }else{
                    e.parent().append(error);
                }    },
            highlight: function(e) {
                $(e).closest('div').removeClass('has-success has-error').addClass('has-error');
                $(e).closest('.help-block').remove();
            },
            success: function(e) {
                e.closest('div').removeClass('has-success has-error');
                e.closest('.help-block').remove();
            }
        });
        $("#form-editar-este").data("validator").settings.submitHandler = function (form) {
            $.ajax({
                type: form.method,
                url: form.action,
                data: $(form).serialize(),
                success: function(response) {
                    $('#modal-detalhes-evento').modal('toggle');
                    refresh_calendar()
                    //location.reload();
                }
            });
            return false; // required to block normal submit since you used ajax
        };
        $("#form-editar-este").on('submit', function() {
            if ($(this).valid()) {
                $("#form-editar-este_botao_loading").button('loading');
                this.submit();
            }
        });
    }

    if(document.getElementById("form-editar-grupo")){
        $('#form-editar-grupo').validate({
            errorClass: 'help-block animation-slideUp', // You can change the animation class for a different entrance animation - check animations page
            errorElement: 'small',
            errorPlacement: function(error, e) {
                if(e.parent().hasClass("bootstrap-timepicker")){
                    e.parent().parent().append(error);
                }else{
                    e.parent().append(error);
                }    },
            highlight: function(e) {
                $(e).closest('div').removeClass('has-success has-error').addClass('has-error');
                $(e).closest('.help-block').remove();
            },
            success: function(e) {
                e.closest('div').removeClass('has-success has-error');
                e.closest('.help-block').remove();
            }
        });
        $("#form-editar-grupo").data("validator").settings.submitHandler = function (form) {
            $.ajax({
                type: form.method,
                url: form.action,
                data: $(form).serialize(),
                success: function(response) {
                    $('#modal-detalhes-evento').modal('toggle');
                    refresh_calendar()
                }
            });
            return false; // required to block normal submit since you used ajax
        };
        $("#form-editar-grupo").on('submit', function() {
            if ($(this).valid()) {
                $("#form-editar-grupo_botao_loading").button('loading');
                this.submit();
            }
        });
    }
}

if(document.getElementById("form-para-validar")){


    $("#form-para-validar").data("validator").settings.submitHandler = function (form) {
        $.ajax({
            type: form.method,
            url: form.action,
            data: $(form).serialize(),
            success: function(response) {
                $('#modal-marcar-evento').modal('toggle');
                refresh_calendar()
            }
        });
        return false; // required to block normal submit since you used ajax
    };

    $('input[name*=nome_evento]').rules('add', 'required');$('input[name*=data_inicio]').rules('add', 'required');$('input[name*=data_inicio]').rules('add', 'dataPortuguesa');$('input[name*=data_fim]').rules('add', 'required');$('input[name*=data_fim]').rules('add', 'dataPortuguesa');$('input[name*=cor]').rules('add', 'required');
}
