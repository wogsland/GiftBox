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

function getSocial(){
  var social = null;
  $.ajax({
    url: "get_social_ajax.php",
    async: false
  }).done(function(data, textStatus, jqXHR){
    social = data;
  });
  return social;
}

var user = getUser()[0];
var tokens = getTokens();
var social = getSocial();
for(i = 0; i < social.length; i++){
  social[i].name = social[i].network;
  if(social[i].name == "Facebook"){
    social[i].icon = "fa-facebook";
  } else if (social[i].name == "Twitter"){
    social[i].icon = "fa-twitter";
  }
}
console.log(user);

//get user information


var Model = {

  profile: {
    user_id: user.id,
    first_name: user.first_name,
    last_name: user.last_name,
    level: user.level,
    email: user.email_address,
    username: user.username ? user.username : "",
    name: user.first_name + " " + user.last_name,
    views: 'XX',
    location: user.location,
    position: user.position,
    company: user.company,
    about: user.about,
    social: social
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
    console.log(this.profile.social);
    $.ajax({
      type: "POST",
      data: this.profile,
      url: "update_user_ajax.php",
      async: false
    }).done(function(data, textStatus, jqXHR){
      response = textStatus;
    });
  }

};
