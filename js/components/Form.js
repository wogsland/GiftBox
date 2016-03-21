(function(Sizzle){
    'use strict';

    function Form(el)
    {
        this.$el = $(el);
        this.$el.data('Form', this);
        this._$submit = this.$el.find('[type="submit"]');
        this._$feedback = this.$el.find('.Form__feedback');
        this._$title = this.$el.find('.Form__title');
        this._registerEvents();
    }

    Form.prototype = {
        _registerEvents: function ()
        {
            this.$el
                .on('change.Form', '.Form__input', function (data) {
                    this._updateLabel(data.currentTarget);
                }.bind(this));

            this.$el.find('.Form__input').change();
        },

        _updateLabel: function (input)
        {
            var $label = $(input).siblings('.Form__label');

            if (input.value) {
                $label.addClass('Form__label--hidden');
            } else {
                $label.removeClass('Form__label--hidden');
            }
        },

        validate: function()
        {
            if (this.$el.find('[data-validation~="required"]').filter(
                    function (i, input) {
                        return input.value === '';
                    }
                ).length) {
                this.error('All fields required');
                return false;
            }

            if (this.$el.find('[data-validation~="email"]').filter(
                    function (i, input) {
                        return !input.value.match(/^[^\@]+@[^\@]+\.[^\@\.]+$/);
                    }
                ).length) {
                this.error('Email appears invalid');
                return false;
            }
            return true;
        },

        disableSubmit: function ()
        {
            this._$submit.attr('disabled', true);
        },

        enableSubmit: function ()
        {
            this._$submit.removeAttr('disabled');
        },

        title: function (newval)
        {
            if (typeof newval === 'string') {
                this._$title.html(newval);
            }
            return this._$title.html();
        },

        get: function (name)
        {
            return this.$el.find('#' + name + ', [name="' + name + '"]')[0];
        },

        set: function (name, value)
        {
            this.get(name).value = value;
        },

        error: function (message)
        {
            this._$feedback.text(message);
            this.$el.addClass('Form--error');
        },

        clearError: function ()
        {
            this._$feedback.text('');
            this.$el.removeClass('Form--error');
        }
    };

    Sizzle.Components.Form = Form;
}(Sizzle));