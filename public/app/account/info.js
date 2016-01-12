var AccountInfo = React.createClass({

  getInitialState: function() {
    return this.getState(this.props);
  },

  componentWillReceiveProps: function(nextProps) {
    var props = jQuery.extend({}, this.props, nextProps);
    this.setState(this.getState(props));
  },

  getState: function(props) {
    var state = props.profile || {};
    state.selectedSocial = this.findUnusedSocial(state.social)[0].name;
    return state;
  },

  handleChange: function(event) {
    var state = {};
    state[event.target.name] = event.target.value;
    this.setState(state);
  },

  handleSocialChange: function(event) {
    var state = {social: this.state.social};
    var social = this.findByName(state.social, event.target.name);
    if(social) {
      social.url = event.target.value;
      this.setState(state);
    }
  },

  editProfile: function() {
    var profile = jQuery.extend({}, this.props.profile, this.state);
    AccountStore.editProfile(profile);
  },

  addSocial: function() {
    var state = {social: this.state.social};
    var social = this.findByName(this.social, this.state.selectedSocial);
    if(social) {
      state.social.push(jQuery.extend({url:this.state.selectedUrl}, social));
    }
    state.selectedUrl = '';
    state.selectedSocial = this.findUnusedSocial(state.social)[0].name;
    this.setState(state);
    var profile = jQuery.extend({}, this.props.profile, this.state, state);
    AccountStore.editProfile(profile);
  },

  render: function() {
    return <div className="tab-pane active" id="account">
      <h2>Profile Settings</h2>
      <form className="form-horizontal form-bordered">
        <div className="form-group">
          <label className="col-sm-1 control-label">Name</label>
          <div className="col-sm-10">
            <input type="text" placeholder="Name" className="form-control tooltips" name="name" value={this.state.name} onChange={this.handleChange} />
          </div>
          <label className="col-sm-1 control-label"><a onClick={this.editProfile}>Edit</a></label>
        </div>
        <div className="form-group">
          <label className="col-sm-1 control-label">Email</label>
          <div className="col-sm-10">
            <input type="text" placeholder="Email" className="form-control tooltips" name="email" value={this.state.email} onChange={this.handleChange} />
          </div>
          <label className="col-sm-1 control-label"><a onClick={this.editProfile}>Edit</a></label>
        </div>
        <div className="form-group">
          <label className="col-sm-1 control-label">Password</label>
          <div className="col-sm-10">
            <input type="password" placeholder="*******************" className="form-control tooltips" name="new_password" value={this.state.new_password} onChange={this.handleChange} />
          </div>
          <label className="col-sm-1 control-label"><a onClick={this.editProfile}>Edit</a></label>
        </div>
      </form>
   </div>;
 },

 renderSocial: function(social) {
   return <div className="form-group" key={social.name}>
     <label className="col-sm-1 control-label">{social.name}</label>
     <div className="col-sm-10">
       <input type="text" placeholder={social.name + ' Web Address'} className="form-control tooltips" name={social.name} value={social.url} onChange={this.handleSocialChange} />
     </div>
     <label className="col-sm-1 control-label"><a onClick={this.editProfile}>Edit</a></label>
   </div>;
 },

 renderSocialOption: function(social) {
   return <option key={social.name} value={social.name}>{social.name}</option>;
 },

 social: [
   {name:'Twitter', icon:'fa-twitter'},
   {name:'Facebook', icon:'fa-facebook'},
   {name:'YouTube', icon: 'fa-youtube'},
   {name:'Pinterest', icon:'fa-pinterest'},
   {name:'Google+', icon:'fa-google-plus'},
   {name:'Instagram', icon:'fa-instagram'},
   {name:'Flickr', icon:'fa-flickr'},
   {name:'LinkedIn', icon:'fa-linkedin'},
   {name:'Reddit', icon:'fa-reddit'},
   {name:'Tumblr', icon:'fa-tumblr'}
 ],

 findUnusedSocial: function(used) {
   var self = this;
   return this.social.filter(function(social) {
     return !self.findByName(used, social.name);
   });
 },

 findByName: function(array, name) {
   return array.filter(function(item) {
     return item.name === name;
   })[0];
 },

});
