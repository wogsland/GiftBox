// this is a shared clientside data model
// it's just populated with mock data for now
function getSession() {
   var session = null;
   $.ajax({
     url: "get_session_ajax.php",
     async: false
   }).done(function(data, textStatus, jqXHR){
     session = data;
   });
   return session;
}

function getUser(){
  var user = null;
  $.ajax({
     url: "get_current_user_ajax.php",
     async: false
   }).done(function(data, textStatus, jqXHR){
     user = data;
   });
   return user;
}

function getTokens(){
  var tokens = null;
  $.ajax({
    url: "get_user_tokens_ajax.php",
    async: false
  }).done(function(data, textStatus, jqXHR){
    tokens = data;
  });
  return tokens;
}

var user = getUser()[0];
var tokens = getTokens();
console.log(tokens);

//get user information


var Model = {

  profile: {
    email: user.email_address,
    username: user.username ? user.username : "",
    name: user.first_name + " " + user.last_name,
    views: 'XX',
    location: 'Nashville, TN, United States',
    position: 'Marketing Director',
    company: 'Company, Inc.',
    about: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus eu commodo leo. Ut ac mollis nulla, et imperdiet tortor. Donec ornare accumsan ipsum, placerat consectetur odio suscipit nec. Praesent tempor dignissim semper. In sapien lectus, pellentesque in risus id, tincidunt faucibus lacus. Donec venenatis lectus elementum, hendrerit sem a, luctus nisi. Cras malesuada vestibulum nulla sed laoreet. Curabitur laoreet urna sed facilisis tempus. Sed sodales lobortis nisi commodo fringilla. Praesent et purus vel neque consectetur commodo id ut diam. Fusce sem sapien, tristique vel turpis et, dapibus euismod diam. Vivamus a blandit erat, non bibendum nibh. Suspendisse nisi dui, porttitor ac sagittis vel, egestas ac est. Pellentesque diam enim, dictum ut nisl at, cursus iaculis lorem.',
    social: [
      {name:'Twitter', icon:'fa-twitter', url:'twitter.com/#'},
      {name:'Facebook', icon:'fa-facebook', url:'facebook.com/#'}
    ]
  },

  tokens: tokens,

  viewers: [
    {id: 0, email:'username@yourdomain.com', firstName: 'John', lastName: 'Smith', type: 'viewer'},
    {id: 1, email:'username@yourdomain.com', firstName: 'John', lastName: 'Smith', type: 'viewer'},
    {id: 2, email:'username@yourdomain.com', firstName: 'John', lastName: 'Smith', type: 'viewer'},
    {id: 3, email:'username@yourdomain.com', firstName: 'John', lastName: 'Smith', type: 'viewer'},
    {id: 4, email:'username@yourdomain.com', firstName: 'John', lastName: 'Smith', type: 'viewer'},
  ],

  users: [
    {id: 0, username: 'jsmith25', firstName: 'John', lastName: 'Smith'},
    {id: 1, username: 'jsmith25', firstName: 'John', lastName: 'Smith'},
    {id: 2, username: 'jsmith25', firstName: 'John', lastName: 'Smith'},
    {id: 3, username: 'jsmith25', firstName: 'John', lastName: 'Smith'},
    {id: 4, username: 'jsmith25', firstName: 'John', lastName: 'Smith'},
  ],

  editing: null,
  removing: null,

  findById: function(array, id) {
    var result = null;
    array.forEach(function(item) {
      result = item.id === id ? item : result;
    });
    return result;
  },

  saveChanges: function(){
    console.log("saving new model...");
    
    var response = null;
    $.ajax({
      type: "POST",
      data: ,
      url: "update_user_ajax.php",
      async: false
    }).done(function(data, textStatus, jqXHR){
      response = textStatus;
    });
  }

};
