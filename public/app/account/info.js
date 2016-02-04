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
    return state;
  },

  handleChange: function(event) {
    var state = {};
    state[event.target.name] = event.target.value;
    this.setState(state);
  },

  editProfile: function() {
    var profile = jQuery.extend({}, this.props.profile, this.state);
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

 findByName: function(array, name) {
   return array.filter(function(item) {
     return item.name === name;
   })[0];
 },

});
