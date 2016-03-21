(function(Sizzle, $) {
    'use strict';

    function Pricing(el)
    {
        this._$el = $(el);
        this._$plan_dialog = $('#plan-dialog');
        this._$contact_dialog = $('#contact-dialog');
        this._slider = new Sizzle.Components.Slider(this._$el.find('.Slider')[0]);
        this._plans = this._$el.find('.Plan');
        this._recommended = null;
        this._planForm = new Sizzle.Components.Form(this._$plan_dialog.find('.Form')[0]);
        this._contactForm = new Sizzle.Components.Form(this._$contact_dialog.find('.Form')[0]);

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
                            data: this._contactForm.$el.serialize(),
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
                    data: { signup_email: this._planForm.get('email').value },
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

    Sizzle.Controllers.create('pricing-page', function(page) {
        var pricing = new Pricing(page);
    });

}(Sizzle, jQuery));
