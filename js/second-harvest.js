/* jshint undef:false */

(function(){
  'use strict';
  var boxCounter = 1;
  var boxLimit;
  var tokenId;
  var unloadType;

  $(document).ready(init);

  function init(){
    $('body').on('click', '.unload-box', unloadBox1);
    $('body').on('click', '.skip', closeDoor);
    $('a.results').click(slideBkg);
    $('a.open-truck').click(slideTruckSmall);

    $('.unload-box').prop("disabled",true);
    $('.results').hide();
    $('.open-truck').hide();
    beginAnimation();
  }
  
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}  

  function beginAnimation(){
    boxLimit = getParameterByName("uc");
    unloadType = getParameterByName("ut");
    tokenId = getParameterByName("tid");
    animateText();
  }

  function animateText(){

    $( "h2.thank-you" ).animate({
      'font-size': '100px'
    }, 1000 );

    $( "h3.thank-you" ).animate({
      'font-size': '55px'
    }, 1200 );


    $('a.results').show();
    $('a.results').tween({
       'opacity':{
          start: 0,
          stop: 100,
          time: 1,
          duration: .5,
          units: 'px',
          effect: 'easeInOut',
          onStop: function(){
            $('.donation-input').remove();
          }
       }
    });
    $.play();
  }

  function slideBkg(event){
    event.preventDefault();
    $('.results').prop("disabled",true);
    $('.thank-you-text').fadeOut();
    $('.green-block').tween({
       'top':{
          start: 0,
          stop: 77.5,
          time: 0,
          duration: 0.7,
          units: 'vh',
          effect: 'easeInOut',
          onStop: function(){
            slideTruckIn();
          }
       }
    });
    $.play();
  }

  function slideTruckSmall(){
    $('.open-truck').fadeOut();
    $('.truck').tween({
       'left':{
          start: 35,
          stop: 50,
          time: 0,
          duration: 1,
          units: 'vw',
          effect: 'easeInOut'
       }
    });

    $('.truck-door').tween({
       'left':{
          start: 35,
          stop: 50,
          time: 0,
          duration: 1,
          units: 'vw',
          effect: 'easeInOut',
          onStop: function(){
            openDoor();
          }
       }
    });
    $.play();
  }

  function slideTruckIn(){
    $('.open-truck').show();
    $('.truck').tween({
       'left':{
          start: -100,
          stop: 35,
          time: 0,
          duration: 1.7,
          units: 'vw',
          effect: 'easeInOut'
       }
    });

    $('.truck-door').tween({
       'left':{
          start: -100,
          stop: 35,
          time: 0,
          duration: 1.7,
          units: 'vw',
          effect: 'easeInOut'
       }
    });

    $('a.open-truck').tween({
       'opacity':{
          start: 0,
          stop: 100,
          time: 1,
          duration: .5,
          units: 'px',
          effect: 'easeInOut'
       }
    });
    $.play();
  }

  function slideTruckOut(){
    $('.truck').tween({
       'left':{
          start: 50,
          stop: 100,
          time: 0,
          duration: .7,
          units: 'vw',
          effect: 'easeInOut'
       }
    });

    $('.truck-door').tween({
       'left':{
          start: 50,
          stop: 100,
          time: 0,
          duration: .7,
          units: 'vw',
          effect: 'easeInOut',
          onStop: function(){
            showFamily();
          }
       }
    });
    $.play();
  }

  function openDoor(){
    $('a.open-truck').before('<a href="#" class="unload-box">UNLOAD FOOD BOXES</a><a href="#" class="skip">Skip this part</a>');
    $('.skip').prop("disabled",true);

    $('a.unload-box').tween({
       'opacity':{
          start: 0,
          stop: 100,
          time: 1,
          duration: .5,
          units: 'px',
          effect: 'easeInOut'
       }
    });

    $('a.skip').tween({
       'opacity':{
          start: 0,
          stop: 100,
          time: 1,
          duration: .5,
          units: 'px',
          effect: 'easeInOut'
       }
    });

    $('.truck-door').tween({
       'rotate':{
          start: 0,
          stop: -98,
          time: 0,
          duration: 1,
          units: 'deg',
          effect: 'easeInOut',
          onStop: function(){
            $('.unload-box').prop("disabled",false);
            unloadBox1();
          }
       }
    });
    $.play();
  }

  function closeDoor(){
    $('.skip').fadeOut();
    $( '.' + unloadType ).animate({
      left: "-=500",
    }, 500);

    $('.truck-door').tween({
       'rotate':{
          start: -98,
          stop: 0,
          time: 0,
          duration: 1,
          units: 'deg',
          effect: 'easeInOut',
          onStop: function(){
            $('.unload-box').fadeOut();
            $('.skip').fadeOut();
            slideTruckOut();
          }
       }
    });
    $.play();
  }

  function unloadBox1(){
    $('.unload-box').prop("disabled",true);
    $('.skip').prop("disabled",true);

    if(boxCounter > boxLimit){
      closeDoor();
    } else {
      $('.boxes').append('<div class="'+unloadType+'" data-id="'+boxCounter+'"></div>');
      $('.'+unloadType+'[data-id="'+boxCounter+'"]').tween({
         'left':{
            start: 52,
            stop: 48,
            time: 0,
            duration: .3,
            units: 'vw',
            effect: 'easeInOut',
            onStop: function(){
              unloadBox2();
            }
         }
      });
      $.play();
    }
  }

  function unloadBox2(){
    $('.'+unloadType+'[data-id="'+boxCounter+'"]').tween({
       'rotate':{
          start: 0,
          stop: -5,
          time: 0,
          duration: .3,
          units: 'deg',
          effect: 'easeInOut'
       },

       'left':{
          start: 48,
          stop: 33,
          time: 0,
          duration: 1,
          units: 'vw',
          effect: 'easeIn'
       },

       'top':{
          start:-138,
          stop: -90,
          time: 0,
          duration: 1,
          units: 'px',
          effect: 'easeIn',
          onStop: function(){
            unloadBox3();
          }
       }
    });
    $.play();
  }

  function unloadBox3(){
    $( '.'+unloadType+':not(.'+unloadType+'[data-id="'+boxCounter+'"])' ).animate({
      left: "-=130",
    }, 500);

    $('.'+unloadType+'[data-id="'+boxCounter+'"]').tween({
      'rotate':{
         start: -5,
         stop: 0,
         time: 0,
         duration: .3,
         units: 'deg',
         effect: 'easeInOut'
      },

      'left':{
          start: 33,
          stop: 20,
          time: 0,
          duration: .7,
          units: 'vw',
          effect: 'easeOut',
          onStop: function(){
            boxCounter++;
            $('.unload-box').prop("disabled",false);
            $('.skip').prop("disabled",false);
          }
       }
    });
    $.play();
  }

  function showFamily(){
    $('.green-block').append('<div class="family"></div>');
    $('.green-block').after('<div class="last-'+unloadType+'"></div>');
    $('.family').tween({
       'top':{
          start: 400,
          stop:-245,
          time: 0,
          duration: 1,
          units: 'px',
          effect: 'easeInOut',
          onStop: function(){
            familyThanks();
          }
       },
    });

    $('.last-'+unloadType).tween({
       'top':{
          start: 95,
          stop: 57,
          time: .5,
          duration: 1,
          units: 'vh',
          effect: 'easeInOut',
          onStop: function(){
          }
       },
    });
    $.play();
  }

  function familyThanks(){
    $('.green-block').after('<div class="thanks-bubble"></div>');
    $('.green-block').after('<div class="raised-text">YOUR DONATION RAISED '+boxLimit+' BOXES OF FOOD!</div>');
    $('.thanks-bubble').tween({
       'opacity':{
          start: 0,
          stop: 100,
          time: 0,
          duration: 1,
          units: 'px',
          effect: 'easeInOut',
          onStop: function(){
          }
       }
    });
    $('.raised-text').tween({
       'opacity':{
          start: 0,
          stop: 100,
          time: 0,
          duration: 1,
          units: 'px',
          effect: 'easeInOut',
          onStop: function(){
          }
       }
    });
    $.play();
    setTimeout(function(){window.location = "preview.php?id="+tokenId}, 3000);
    
  }

})();
