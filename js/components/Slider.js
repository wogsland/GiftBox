(function (Sizzle) {
    'use strict';

    var MOUSE = {
            left: false
        },
        $doc = $(document),
        $bod = $('body');
    $doc.on('mousedown.left_click', function () { MOUSE.left = true; });
    $doc.on('mouseup.left_click', function () { MOUSE.left = false; });

    /**
     * Basic slider UI component
     * @param {HTMLElement} el The .Slider element.
     * @param {int} min? The bottom limit.
     * @param {int} max? The top limit.
     * @param {int} val? Initial value.
     */
    function Slider (el, min, max, val)
    {
        $(el).data('slider', this);
        this._track = el;
        this._knob = el.children[0];
        this._label = this._knob.children[0];
        this._input = el.children[1];
        this._min = parseFloat(min || el.dataset.min || 0);
        this._max = parseFloat(max || el.dataset.max || 100);
        this.$this = $(this);
        this.value(val || el.dataset.value || min);
        this._is_dragging = false;

        this._register_events();
    }

    Slider.prototype = {
        /**
         * Maps the 0 to 1 value stored to the range and returns it.
         * Sets value (from mapped value) if provided.
         *
         * @param    {number} new_value The new value (optional).
         * @return {number} The current value.
         */
        value: function(new_value)
        {
            if (typeof new_value !== 'undefined') {
                this._value = parseFloat((new_value - this._min) / this.range());
                this._update();
                this.$this.trigger('change', this.value());
            }

            return this.range() * this._value + this._min;
        },

        /**
         * The maximum minus the minimum.
         * @return {int} The range of the slider
         */
        range: function()
        {
            return this._max - this._min;
        },

        drag: function()
        {
            this._is_dragging = true;
            $bod.addClass('App--dragging');
        },

        drop: function()
        {
            this._is_dragging = false;
            $bod.removeClass('App--dragging');
        },

        is_dragging: function()
        {
            return this._is_dragging;
        },

        /**
         * Update DOM state based on object. Needs done regularly.
         * @return void
         * @private
         */
        _update: function()
        {
            this._knob.style.left = this._value * 100 + "%";
            this._input.value = Math.round(this.value());
            this._label.innerHTML = this._input.value;
        },

        /**
         * Update value from mouse position
         * @param mouseX The current horizontal mouse position
         * @private
         */
        _update_value: function (mouseX)
        {
            var track_rect = this._track.getBoundingClientRect(),
                track_left = track_rect.left + document.documentElement.scrollLeft,
                track_width = track_rect.width;

            this.value(this.range() * (Math.min(1, Math.max(0, (mouseX - track_left) / track_width))) + this._min);
            this._update();
        },

        /**
         * Register events with the dom.
         * @return void
         * @private
         */
        _register_events: function()
        {
            $(this._track).on( 'mousedown.drag', function (e) { this.drag(); this._update_value(e.clientX); e.preventDefault(); }.bind(this) );
            $doc.on( 'mouseup.drop', this.drop.bind(this) )
                .on(
                    'mousemove.drag',
                    function (e)
                    {
                        if (this.is_dragging() && MOUSE.left) {
                            this._update_value(e.clientX);
                        }
                    }.bind(this)
                );
        }
    };

    Sizzle.Components.Slider = Slider;
}(Sizzle));