var AccountUserEdit = React.createClass({

  getInitialState: function() {
    return this.getState(this.props);
  },

  componentWillReceiveProps: function(nextProps) {
    var props = jQuery.extend({}, this.props, nextProps);
    this.setState(this.getState(props));
  },

  getState: function(props) {
    var state = {};
    if(props.user) {
      state.firstName = props.user.firstName;
      state.lastName = props.user.lastName;
      state.username = props.user.username;
    }
    return state;
  },

  handleChange: function(event) {
    var state = {};
    state[event.target.name] = event.target.value;
    this.setState(state);
  },

  editUser: function() {
    var user = jQuery.extend({}, this.props.user, this.state);
    AccountStore.editUser(user);
  },

  render: function() {
    return <div className="modal" id="edit" tabIndex="-1" role="dialog" style={{display: (this.props.user && this.props.user.username) ? 'block' : 'none'}} >
      <div className="modal-dialog">
        <div className="modal-content">
          <div className="modal-header">
            <button type="button" className="close" onClick={AccountStore.cancelPrompt} >×</button>
            <h4 className="modal-title custom_align" id="Heading">Edit Your Detail</h4>
          </div>
          <div className="modal-body">
            <div className="form-group">
              <input className="form-control " type="text" placeholder="First Name" name="firstName" value={this.state.firstName} onChange={this.handleChange} />
            </div>
            <div className="form-group">
              <input className="form-control " type="text" placeholder="Last Name" name="lastName" value={this.state.lastName} onChange={this.handleChange} />
            </div>
            <div className="form-group">
              <input className="form-control " type="text" placeholder="username" name="username" value={this.state.username} onChange={this.handleChange} />
            </div>
          </div>
          <div className="modal-footer ">
            <button type="button" onClick={this.editUser} className="btn btn-lg standard-button2" style={{width: '100%'}}>
              <span className="glyphicon glyphicon-ok-sign"></span> Update
            </button>
          </div>
        </div>
      </div>
    </div>;
  }

});
