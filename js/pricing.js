(function() {
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

    function Pricing(el)
    {
        this._$el = $(el);
        this._$plan_dialog = $('#plan-dialog');
        this._$contact_dialog = $('#contact-dialog');
        this._slider = new Slider(this._$el.find('.Slider')[0]);
        this._plans = this._$el.find('.Plan');
        this._recommended = null;
        this._planForm = new Form(this._$plan_dialog.find('.Form')[0]);
        this._contactForm = new Form(this._$contact_dialog.find('.Form')[0]);

        this.update_recommendation(this._slider.value());
        this._register_events();
    }

    Pricing.prototype = {
        _register_events: function() {
            this._slider.$this.on('change', function(e, value) {
                this.update_recommendation(value);
            }.bind(this));

            // Open forms
            $doc.on('click.pricing', '.Plan__callToAction', function(e) {
                if (e.currentTarget.dataset.plan) {
                    this._planForm.set('plan', e.currentTarget.dataset.plan);
                    this._planForm.set('billing', e.currentTarget.dataset.billing);
                    this._planForm.clearError();
                    this._planForm.title(
                        $(e.currentTarget).parents('.Plan').find('.Plan__name').text()
                        + ' Plan <span class="Form__subtitle">'
                        + e.currentTarget.innerHTML.replace(/<div>.+<\/div>/, '')
                        + '</span>'
                    );
                    this._$plan_dialog.modal();
                } else {
                  this._contactForm.clearError();
                  this._$contact_dialog.modal();
                }
                return false;
            }.bind(this));

            // Submit Pay form
            this._planForm.$el.on('submit.pricing', function () {
                if ( this._planForm.validate()) {
                    this._planForm.disableSubmit();
                    this._planForm.clearError();
                    Stripe.card.createToken(this._planForm.$el, this._onStripeResponse.bind(this));
                }
                return false;
            }.bind(this));

            // Submit Email form
            this._contactForm.$el.on('submit.pricing', function () {
                if (this._contactForm.validate()) {
                    this._contactForm.disableSubmit();
                    this._contactForm.clearError();
                    $.ajax(
                        {
                            url: '/ajax/sendemail',
                            data: this._contactForm.$el.serialize,
                            type: 'post'
                        }
                    )
                        .done(this._redirectToThankYou('enterprise'))
                        .fail(this._onProcessFailure.bind(this));
                }
                return false;
            }.bind(this));
        },

        _validate_form: function(form)
        {
            if (form.$el.find('[data-validation~="required"]').filter(
                    function (i, input) {
                        return input.value === '';
                    }
                ).length) {
                form.error('All fields required');
                return false;
            }

            if (form.$el.find('[data-validation~="email"]').filter(
                    function (i, input) {
                        return !input.value.match(/^[^\@]+@[^\@]+\.[^\@\.]+$/);
                    }
                ).length) {
                form.error('Email appears invalid');
                return false;
            }
            return true;
        },

        update_recommendation: function(number_of_jobs_needed)
        {
            var recommended = this._plans[0];
            this._plans.each(
                function(index, plan) {
                    if (plan.dataset.min <= number_of_jobs_needed) {
                        recommended = plan;
                    }
                }.bind(this)
            );
            this.recommend(recommended);
        },

        recommend: function (plan)
        {
            this._recommended = $(plan);
            this._plans.removeClass('Plan--recommended');
            this._recommended.addClass('Plan--recommended');
        },

        _onStripeResponse: function (status, response)
        {
            if (response.error) {
                this._onProcessFailure(response.error.message);
            } else {
                this._signupUser(status, response);

            }
        },

        _signupUser: function (status, response)
        {
            // Insert the token into the form so it gets submitted to the server
            this._planForm.set('stripeToken', response.id);

            // and send to the signup endpoint
            // TODO These should not be hard coded in the view
            // js. It should be part of the form functionality.
            $.ajax(
                {
                    url: '/ajax/signup',
                    data: { email: this._planForm.get('email').value },
                    type: 'post',
                    dataType: 'json'
                }
            )
                .then(this._upgradePlan.bind(this))
                .then(this._redirectToThankYou('signup'))
                .fail(this._onProcessFailure.bind(this));
        },

        _upgradePlan: function()
        {
            return $.ajax(
                {
                    url: '/ajax/upgrade',
                    data: this._planForm.$el.serialize(),
                    type: 'post',
                    dataType: 'json'
                }
            );
        },

        _redirectToThankYou: function(action)
        {
            return function () {
                window.location = "/thankyou?action=" + action;
            }
        },

        _onProcessFailure: function (message)
        {
            message = typeof message === 'string' ? message : 'There was a problem processing your request. Please try again later.';
            // Show the errors on the form
            this._planForm.error(message);
            this._planForm.enableSubmit();
        }
    };

    var pricing = new Pricing(document.getElementById('pricing-page'));

}());
