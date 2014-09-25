(function ($) {
    var $window = $(window);
    var windowHeight = $window.height();
    var $screenMedium = '62em';
    var $screenLarge = '80em';

    $window.resize(function () {
        windowHeight = $window.height();
    });

    $.fn.parallax = function (dir, speedFactor) {
        var $this = $(this);
        var offsetTop;

        $this.each(function () {
            offsetTop = $this.offset().top;
        });

        var getHeight = function (jqo) {
            return jqo.height();
        };

        function update() {
            var scrollTop = $window.scrollTop();

            $this.each(function () {
                var $element = $(this);
                var top = $element.offset().top;
                var height = getHeight($element);

                if (top + height < scrollTop || top > scrollTop + windowHeight) {
                    return;
                }

                var positionChange = Math.round((offsetTop - scrollTop) * speedFactor);
                //var scaleInChange = 1 - (positionChange / 1000);
                var scaleOutChange = 1 + (positionChange / 1000);

                if (dir == "vertical") {
                    if (matchMedia('only screen and (max-width: ' + $screenMedium + ')').matches) {
                        $this.css({
                            'backgroundPosition': "0% " + positionChange + "px"
                        });
                    } else {
                        $this.css({
                            'backgroundPosition': "50% " + positionChange + "px"
                        });
                    }
                }
                if (dir == "both") {
                    if (matchMedia('only screen and (min-width: ' + $screenLarge + ')').matches) {
                        $this.css({
                            'backgroundPosition': "50% " + positionChange + "px",
                            '-webkit-transform': "scale(" + scaleOutChange + ")"
                        });
                    } else if (matchMedia('only screen and (max-width: ' + $screenMedium + ')').matches) {
                        $this.css({
                            'backgroundPosition': "0% " + positionChange + "px"
                        });
                    } else {
                        $this.css({
                            'backgroundPosition': "50% " + positionChange + "px"
                        });
                    }
                }
            });
        }

        $window.bind('scroll', update).resize(update);
        update();
    };
})(jQuery);
