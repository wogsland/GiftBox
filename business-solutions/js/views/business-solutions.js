$(document).ready(function(){

    //.parallax(xPosition, speedFactor, outerHeight) options:
    //xPosition - Horizontal position of the element
    //inertia - speed to move relative to vertical scroll. Example: 0.1 is one tenth the speed of scrolling, 2 is twice the speed of scrolling
    //outerHeight (true/false) - Whether or not jQuery should use it's outerHeight option to determine when a section is in the viewport

    var $bgSpeed = 0.2;
    var $deviceSpeed = 0.3;
    var $shadowSpeed = -0.2;

    $('section.slide').each(function(){
        $(this).parallax("vertical", $bgSpeed);
    });

    $('.gb-parallax.fg').each(function(){
        $(this).parallax("both", $deviceSpeed);
    });

    $('.gb-parallax.bg').each(function(){
        $(this).parallax("vertical", $shadowSpeed);
    });

});