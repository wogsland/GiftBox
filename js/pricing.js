function selectBasic() {
  selectPlan("basic");
  $('#signup-dialog').modal();
}

function selectStandard() {
  selectPlan("standard");
}
function selectPlan(plan) {
  var selectedPlan = $("#"+plan);

  // restore all plans
  $(".plan").each(function(i) {
    $(this).removeClass("plan-hover");
    $(this).addClass("plan-hover");
    $(this).removeClass("plan-selected");
  });

  // set the selected plan
  selectedPlan.removeClass("plan-hover");
  selectedPlan.addClass("plan-selected");
}

// Immediately Invoked Function Expression (IIFE)
// Used to be referred to as a self executing function
// Avoids creating global variables and functions which can interfere with other scripts
(function() {

var plans = {
  basic: {
    pricingChart: false,
    pricingChart2: false,
    basePrice: 0
  },
  standard: {
    pricingChart: false,
    pricingChart2: false,
    basePrice: 9.99
  },
  premium: {
    pricingChart: true,
    pricingChart2: false,
    basePrice: 49.99
  },
  enterprise: {
    pricingChart: true,
    pricingChart2: true,
    basePrice: 120
  }
};

var viewerLevels = {
  500: 10.99,
  2500: 20.99,
  5000: 30.99,
  10000: 40.99
};

var userLevels = {
  1: 100.59,
  2: 200.59,
  3: 300.59,
  4: 400.59
};


var selectedPlan = "basic";
var viewerLevel = null;
var userLevel = null;



    // Find all elements with class plan, then find all elements with class select-button within it
    // Bind to click events on those elements
    $( ".plan .select-btn" ).on( "click", function( event ) {
      $("#premium-dialog").modal();

/*
      // Read the plan type from the data-plan attribute on the div with class plan
      selectedPlan = $( this ).closest( ".plan" ).attr( "data-plan" );
  selectPlan(selectedPlan);

      // Get the plan information from the plans variable, based on the key that we just read from the attribute
      var planInfo = plans[ selectedPlan ];

      if ( planInfo.pricingChart ) {
        $( "#pricingChart" ).removeClass( "not" );
      } else {
        $( "#pricingChart" ).addClass( "not" );
        viewerLevel = null;
        $('.pricingLevelOn').removeClass('pricingLevelOn');
      }

      if ( planInfo.pricingChart2 ) {
        $( "#pricingChart2" ).removeClass( "not" );
      } else {
        $( "#pricingChart2" ).addClass( "not" );
        userLevel = null;
        $('.pricingLevelOn2').removeClass('pricingLevelOn2');
      }

      // Determine which pricing chart to scroll to
      var showPricingChart = "#topPricingChart";
      if ( planInfo.pricingChart ) {
        showPricingChart = "#pricingChart";
      }

      // Scroll to the pricing chart
      // https://github.com/jquery/api.jquery.com/issues/417
      $( "html,body" ).animate({
        scrollTop: $( showPricingChart ).offset().top
      }, "slow" );

      updatePrice();
*/

    });

    $( ".pricingLevel" ).on( "click", function() {
      // Update the "global" viewer level
      viewerLevel = $( this ).attr( "data-viewer" );

      // Update the color/ selected element
      var size = viewerLevel
      $('.pricingLevelOn').removeClass('pricingLevelOn');
      var tab = $('#pricing' + size.toString());
      tab.addClass('pricingLevelOn');

      // update the price
      updatePrice();
    });

    $( ".pricingLevel2" ).on( "click", function() {
      userLevel = $( this ).attr( "data-user" );

      var size2 = userLevel
      $('.pricingLevelOn2').removeClass('pricingLevelOn2');
      var tab = $('#pricingU' + size2.toString());
      tab.addClass('pricingLevelOn2');

      updatePrice();
    });

        function updatePrice() {
          var basePrice = plans[ selectedPlan ].basePrice;

          var viewerPrice = 0;
          if ( viewerLevel ) {
            viewerPrice = viewerLevels[ viewerLevel ];
          }

          var userPrice = 0;
          if ( userLevel ) {
            userPrice = userLevels[ userLevel ];
          }

          var totalPrice = basePrice + viewerPrice + userPrice;
        $( ".pricingLargeAmount" ).text( strip(totalPrice) );
        }

        //MAY NEED TO UPDATE SINCE WE ARE DEALING WITH MONEY... THIS IS NOT THE FULL WORK AROUND
        //http://stackoverflow.com/questions/1458633/elegant-workaround-for-javascript-floating-point-number-problem
        function strip(number) {
          return (parseFloat(number.toPrecision(12)));
        }

      // Set the price based on the defaults defined above
      updatePrice();


      //Handeling the Continue Button
      $( "#continue" ).on( "click", function() {
        if (selectedPlan =="enterprise"){
          //CHANGE TO
          //1st accept credit card info
          //2nd tell the user the service is not yet ready
          $( '#myModal2 .modal-header' ).text( 'Enterprise Plan' )
          $('#myModal2').modal()
        } else if ( selectedPlan  == "premium" ){
          //CHANGE TO
          //1st accept credit card info
          //2nd tell the user the service is not yet ready
          $( '#myModal2 .modal-header' ).text( 'Premium Plan' )
          $('#myModal2').modal()
        } else if ( selectedPlan  == "standard" ){
          //CHANGE TO
          //1st If click Log In have them Log In then go to Stripe Collectio OR if they hit sign up do all in one: sign up and collect credit info
          //2nd lead user to create screen with activated service
          $( '#myModal .modal-header' ).text( 'Standard Plan' )
          $('#myModal').modal()

        } else if ( selectedPlan  == "basic" ){
          //this is the free option... the user should not see the continue button... they should only click sign up
          $( '#myModal .modal-header' ).text( 'Basic Plan' )
          $('#myModal').modal()

        } else {
          alert("How did you get to this option??");
        }

      });

})();
