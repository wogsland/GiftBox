// this is a very basic dispatcher+store combo until we can get module loading in (as part of a build)
var AccountStore = {

  promptToAddViewer: function() {
    Model.editing = {type: 'viewer'};
    AccountStore.emitChange();
  },

  promptToEditViewer: function(viewer) {
    Model.editing = viewer;
    AccountStore.emitChange();
  },

  editViewer: function(viewer) { // will use api eventually
    var ref = Model.findById(Model.viewers, viewer.id);
    if(ref) {
      jQuery.extend(ref, viewer);
    } else {
      viewer.id = Math.random();
      Model.viewers.push(viewer);
    }
    AccountStore.cancelPrompt();
  },

  promptToRemoveViewer: function(viewer) {
    Model.removing = viewer;
    AccountStore.emitChange();
  },

  removeViewer: function(viewer) {
    var index = Model.viewers.indexOf(viewer);
    Model.viewers.splice(index, 1);
    AccountStore.cancelPrompt();
  },

  promptToEditUser: function(user) {
    Model.editing = user;
    AccountStore.emitChange();
  },

  editUser: function(user) {
    var ref = Model.findById(Model.users, user.id);
    jQuery.extend(ref, user);
    AccountStore.cancelPrompt();
  },

  promptToRemoveUser: function(user) {
    Model.removing = user;
    AccountStore.emitChange();
  },

  removeUser: function(user) {
    var index = Model.users.indexOf(user);
    Model.users.splice(index, 1);
    AccountStore.cancelPrompt();
  },

  editProfile: function(profile) {
    jQuery.extend(Model.profile, profile);
    AccountStore.emitChange();
  },

  cancelPrompt: function() {
    Model.editing = null;
    Model.removing = null;
    AccountStore.emitChange();
  },

  // barebones dispatcher stuff

  _listeners: [],

  emitChange: function() {
    this._listeners.forEach(function(callback) {
      callback();
    });
  },

  addChangeListener: function(callback) {
    this._listeners.push(callback);
  },

  removeChangeListener: function(callback) {
    var index = this._listeners.indexOf(callback);
    this._listeners.splice(index, 1);
  }

};
