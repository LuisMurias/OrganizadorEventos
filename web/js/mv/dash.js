/* global baseUri, ko */

var eventBlank = {
    "name": "",
    "description": ""
};

//Modelo de KnockOut
function DashViewModel() {

    var self = this;
    self.event = ko.observable();

    var baseUriEvent = baseUri + 'event/';
    var baseUriEventStats = baseUri + 'eventstats/';

    self.loadEvent = function () {
        if ($('#menu-event-select li').length > 0) {
            self.event(JSON.parse(JSON.stringify(eventBlank)));
        } else {
            $.getJSON(baseUriEventStats, self.event)
                .error(function (o) {
                    mostrarMensaje("0", "Se ha producido un error.");
                });
        }


    };

    self.saveEvent = function () {
        $.ajax({ type: "POST", url: baseUriEvent, data: self.event() })
            .done(function (retorno) {
                var variablesretorno = retorno.split(";");
                mostrarMensaje(variablesretorno[0], variablesretorno[1]);
                if (variablesretorno[0] == "1") {

                }
            })
            .error(function (o) {
                mostrarMensaje("0", "Se ha producido un error.");
            });
    };
    
}

$(document).ready(function () {
    //Se inicializa el modelo
    var model = new DashViewModel();
    ko.applyBindings(model);

    model.loadEvent();
    
    
});