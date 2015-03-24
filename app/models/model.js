// this is a shared clientside data model
// it's just populated with mock data for now

var Model = {

  profile: {
    email: 'benstucki@gmail.com',
    username: 'mock',
    name: 'Mock User',
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

  tokens: [
    {id: 0, name: 'GiveToken1', for: 'Angela L.', variant: '01'},
    {id: 1, name: 'GiveToken2', for: 'Angela L.', variant: '02'},
    {id: 2, name: 'GiveToken3', for: 'Angela L.', variant: '03'},
    {id: 3, name: 'GiveToken4', for: 'Angela L.', variant: '04'}
  ],

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
  }

};
