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

  handleChangeAllowTokenResponses: function(event) {
    // flip 'Y' to 'N' and vice versa
    event.target.value = event.target.value === 'Y' ? 'N' : 'Y';
    this.handleChange(event);
  },

  handleChangeReceiveTokenNotifications: function(event) {
    // flip 'Y' to 'N' and vice versa
    event.target.value = event.target.value === 'Y' ? 'N' : 'Y';
    this.handleChange(event);
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

    var wantsToReceiveTokenResponseNotifications = this.state.receive_token_notifications === 'Y';
    var allowTokenResponses = this.state.allow_token_responses === 'Y';

    return <div className="tab-pane active" id="account">
      <h2>Profile Settings</h2>
      <form className="form-horizontal form-bordered">
        <div className="form-group">
          <label className="col-sm-1 control-label">Name</label>
          <div className="col-sm-10">
            <input type="text" placeholder="Name" className="form-control tooltips" name="name" value={this.state.name} onChange={this.handleChange} />
          </div>
        </div>
        <div className="form-group">
          <label className="col-sm-1 control-label">Email</label>
          <div className="col-sm-10">
            <input type="text" placeholder="Email" className="form-control tooltips" name="email" value={this.state.email} onChange={this.handleChange} />
          </div>
        </div>
        <div className="form-group">
          <label className="col-sm-1 control-label">Password</label>
          <div className="col-sm-10">
            <input type="password" placeholder="*******************" className="form-control tooltips" name="new_password" value={this.state.new_password} onChange={this.handleChange} />
          </div>
        </div>
        <div className="form-group">
          <div className="checkbox col-sm-offset-1 col-sm-10">
            <label>
              <input type="checkbox" name="allow_token_responses" checked={allowTokenResponses} onChange={this.handleChangeAllowTokenResponses} />
              Allow Token Responses?
            </label>
          </div>
        </div>
        <div className="form-group">
          <div className="checkbox col-sm-offset-1 col-sm-10">
            <label>
              <input type="checkbox" name="receive_token_notifications" checked={wantsToReceiveTokenResponseNotifications} onChange={this.handleChangeReceiveTokenNotifications} />
              Receive Token Response Notifications by Email?
            </label>
          </div>
        </div>
        <label className="col-sm-offset-7 col-sm-5 control-label"><a onClick={this.editProfile}>Save</a></label>
      </form>
   </div>;
 },

 findByName: function(array, name) {
   return array.filter(function(item) {
     return item.name === name;
   })[0];
 },

});
