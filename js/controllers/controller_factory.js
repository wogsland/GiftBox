(function(Sizzle) {
    'use strict';

    var ID_CONTROLLERS = {};

    Sizzle.Controllers.create = function(id, cb) {
        ID_CONTROLLERS[id] = ID_CONTROLLERS[id] || [];
        ID_CONTROLLERS[id].push(cb);
    };

    function _initialize_controllers() {
        for (var id in ID_CONTROLLERS) {
            _initialize_by_id(id);
        }
    }

    function _initialize_by_id(id) {
        var element = document.getElementById(id);
        if (element && ID_CONTROLLERS[id]) {
            ID_CONTROLLERS[id].forEach(function(cb) {
                cb(element);
            });
        }
    }

    Sizzle.on('bootstrap.controllers', _initialize_controllers);

}(Sizzle));