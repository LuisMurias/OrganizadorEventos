/* global baseUri, ko */

//Modelo de KnockOut
function TaskViewModel() {

    var self = this;
    self.taskList = ko.observableArray();

    var baseUriPage = baseUri + 'task/';

    //Boton para cambiar los controles
    self.loadTask = function () {
        $.getJSON(baseUriPage, self.taskList)
            .error(function (o) {
                mostrarMensaje("0", "Se ha producido un error.");
            });
    };

}

$(document).ready(function () {
    //Se inicializa el modelo
    var model = new TaskViewModel();
    ko.applyBindings(model);
    
    model.loadTask();
});