(function(global, $) {
    'use strict';

    global.Sizzle = {

        /**
         * Components are individual pieces of functionality that manipulate
         * markup and emit events. They generally take an html element as a
         * parameter in their construction.
         */
        Components: {},

        /**
         * Controllers handle converting user input and event data into commands
         * that are then passed to delegate in either a Component or a Domain object.
         * There is generally one of these per page.
         *
         * These should generally just be concerned with delegating event
         * data to components. Any Data manipulation should probably happen
         * in the component.
         */
        Controllers: {},

        /**
         * Domain objects are responsible for manipulating and maintaining
         * application data.
         */
        Domain: {},

        /**
         * The current state of the application.
         */
        Data: {},

        /**
         * Utility functions.
         */
        Util: {}
    };

    var $sizzle = $(Sizzle);

    Sizzle.on = $sizzle.on.bind($sizzle);
    Sizzle.off = $sizzle.off.bind($sizzle);
    Sizzle.trigger = $sizzle.trigger.bind($sizzle);

    $(function() {
        Sizzle.trigger({
            type: 'bootstrap'
        });
    });

}(this, jQuery));
