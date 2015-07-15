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

for (i=0; i < tokens.length; i++){
  tokens[i].variant = "01";
  tokens[i].name += "-"+tokens[i].id;
}

if(user.level == 1){
  user.user_level = "Free";
} else if (user.level == 2){
  user.user_level = "Standard";
} else if (user.level == 3){
  user.user_level = "Premium";  
} else if (user.level == 4){
  user.user_level = "Enterprise";
}
//get user information

var Model = {

  profile: {
    admin: user.admin,
    user_id: user.id,
    first_name: user.first_name,
    last_name: user.last_name,
    level: user.level,
    level_text: user.user_level,
    email: user.email_address,
    username: user.username ? user.username : "",
    name: user.first_name + " " + user.last_name,
    views: 'XX',
    location: user.location,
    position: user.position,
    company: user.company,
    about: user.about ? user.about : "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus eu commodo leo. Ut ac mollis nulla, et imperdiet tortor. Donec ornare accumsan ipsum, placerat consectetur odio suscipit nec. Praesent tempor dignissim semper. In sapien lectus, pellentesque in risus id, tincidunt faucibus lacus. Donec venenatis lectus elementum, hendrerit sem a, luctus nisi. Cras malesuada vestibulum nulla sed laoreet. Curabitur laoreet urna sed facilisis tempus. Sed sodales lobortis nisi commodo fringilla. Praesent et purus vel neque consectetur commodo id ut diam. Fusce sem sapien, tristique vel turpis et, dapibus euismod diam. Vivamus a blandit erat, non bibendum nibh. Suspendisse nisi dui, porttitor ac sagittis vel, egestas ac est. Pellentesque diam enim, dictum ut nisl at, cursus iaculis lorem",
    levels: [
      {1: "Free"},
      {2: "Standard"},
      {3: "Premium"},
    ],
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

  deleteToken: function(tokenId) {
    console.log("tokenId=" + tokenId);
    $.ajax({
       type: "POST",
       url: "delete_token_ajax.php",
       data: "tokenId=" + tokenId,
       async: false
     }).done(function(data, textStatus, jqXHR){
       console.log("Success!");
     });
  },

  saveChanges: function(){
    console.log("saving new model...");
    var response = null;
    this.profile.first_name = this.profile.name.split(' ')[0];
    this.profile.last_name = this.profile.name.substring(this.profile.name.indexOf(' ') + 1);
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
