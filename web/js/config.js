//Config Desarrollo
var baseUri = 'http://localhost/OrganizadorEventos/web/app_dev.php/api/';

//Obtiene los parametros que se le pasan a la pagina
function obtenerQueryString(qString) {
    var queryParams = Object();
    var params = qString.split("&");
    params[0] = params[0].substring(1);
    for (var i in params) {
        var temp = params[i].split("=");
        queryParams[temp[0]] = temp[1];
    }
    return queryParams;
}

//Muestra un mensaje
function mostrarMensaje(tipo, mensaje) {
    $('.aviso').show();
    switch (tipo) {
        case "0":
            $('.aviso').removeClass("alert-success");
            $('.aviso').addClass("alert-danger");
            $('.aviso .textoerror').text(mensaje);
            break;
        case "1":
            $('.aviso').removeClass("alert-danger");
            $('.aviso').addClass("alert-success");
            $('.aviso .textoerror').text(mensaje);
            break;
        case "2":
            $('.aviso').removeClass("alert-success");
            $('.aviso').addClass("alert-danger");
            var textoError = "";
            $.map(mensaje, function (item) {
                if (item.Registro) {
                    textoError = textoError + "<strong>" + item.Registro + ": </strong>";
                }
                textoError = textoError + item.Mensaje + "<br />";
            });
            $('.aviso .textoerror').html(textoError);
            break;
    }
    
    window.setTimeout(function () { $('.aviso').hide(); }, 5000);
}

$(document).ready(function () {

    //Binding de KnockOut para tratar las fechas
    ko.bindingHandlers.dateText = {
        update: function (element, valueAccessor, allBindingsAccessor) {
            var value = valueAccessor(), allBindings = allBindingsAccessor();
            var valueUnwrapped = ko.utils.unwrapObservable(value);

            var d = "";
            if (valueUnwrapped) {
                var m = moment(new Date(valueUnwrapped));
                if (m) {
                    d = m.format("DD/MM/YYYY");
                }
            }
            $(element).text(d);
        }
    };

    //Binding de KnockOut para tratar las fechas

    ko.bindingHandlers.dateTimeText = {
        update: function (element, valueAccessor, allBindingsAccessor) {
            var value = valueAccessor(), allBindings = allBindingsAccessor();
            var valueUnwrapped = ko.utils.unwrapObservable(value);

            var d = "";
            if (valueUnwrapped) {
                var m = moment(new Date(valueUnwrapped));
                if (m) {
                    d = m.format("DD/MM/YYYY HH:mm:ss");
                }
            }
            $(element).text(d);
        }
    };

    ko.bindingHandlers.adjuntosHtml = {
        update: function (element, valueAccessor, allBindingsAccessor) {
            var value = valueAccessor(), allBindings = allBindingsAccessor();
            var valueUnwrapped = ko.utils.unwrapObservable(value);

            var d = "";
            if (valueUnwrapped) {
                var ruta = valueUnwrapped.split("/");
                if(ruta){
                    var nombre = ruta[ruta.length - 1];
                    d = d + "<a href='" + urlDocumentos + valueUnwrapped + "' target='_blank'>" + nombre + "</a> ";
                } else {
                    d = "";
                }
            }
            $(element).html(d);
        }
    };

    ko.bindingHandlers.editorHTML = {
        init: function (element, valueAccessor) {
            var options = {
                inlineMode: false,
                alwaysBlank: true,
                buttons: ['undo', 'redo', 'selectAll', 'sep', 'bold', 'italic', 'underline', 'align', 'formatBlock', 'sep', 'createLink', 'insertOrderedList', 'insertUnorderedList', 'insertHorizontalRule', 'table' ],
                autosaveInterval: 10,
                language: 'es',
                contentChangedCallback: function () {
                    var html = $(element).editable("getHTML")[0];
                    observable = valueAccessor();
                    observable(html);
                }
            };
            $(element).editable(options);

            // handle disposal (if KO removed by the template binding)
            ko.utils.domNodeDisposal.addDisposeCallback(element, function () {
                $(element).editable("destroy");
            });
        },
        update: function (element, valueAccessor) {
            var value = ko.utils.unwrapObservable(valueAccessor());
            if ($(element).editable("getHTML")[0] !== value)
                $(element).editable("setHTML", value);
        }
    };

    //Oculta los mensajes de error al darle al boton de cerrar
    $('.aviso .close').on("click", function () {
        $('.aviso').hide();
    });

    //Se inicializan las fechas
    $.fn.datepicker.defaults.format = "dd/mm/yyyy";
    $.fn.datepicker.defaults.language = "es";
    $.fn.datepicker.defaults.autoclose = true;

    //Se inicializan los validadores
    jQuery.validator.setDefaults({
        errorClass: "has-error",
        highlight: function (element, errorClass) {
            $(element).closest('.form-group').addClass(errorClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass(errorClass);
        },
        errorPlacement: function (error, element) { }
    });

    //Eventos para mostrar circulo mientras tengamos conexiones abiertas con el servidor.
    $(document).ajaxStart(function () {
        $("#loading").show();
    });

    $(document).ajaxStop(function() {
        $("#loading").hide();
    });

    //Eventos cuando un registro pide confirmacion
    $('#vModal').on('show.bs.modal', function (e) {
        //Se le asigna la clave a una label oculta
        $('#idRegistro').text($(e.relatedTarget).parent().parent().attr("id"));
        if ($(e.relatedTarget).parent().parent().attr("data-tipo")) {
            $('#idTipo').text($(e.relatedTarget).parent().parent().attr("data-tipo"));
        }
        //Si el boton esta fuera del grid
        if ($(e.relatedTarget).attr("data-tipo")) {
            $('#idTipo').text($(e.relatedTarget).attr("data-tipo"));
        }
    });

});