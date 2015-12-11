// <div class="modal-backdrop fade in"></div>

var AccountViewerEdit = React.createClass({

  getInitialState: function() {
    return this.getState(this.props);
  },

  componentWillReceiveProps: function(nextProps) {
    var props = jQuery.extend({}, this.props, nextProps);
    this.setState(this.getState(props));
  },

  getState: function(props) {
    var state = {};
    if(props.viewer) {
      state.isNew = isNaN(props.viewer.id);
      state.firstName = props.viewer.firstName;
      state.lastName = props.viewer.lastName;
      state.email = props.viewer.email;
    }
    return state;
  },

  handleChange: function(event) {
    var state = {};
    state[event.target.name] = event.target.value;
    this.setState(state);
  },

  editViewer: function() {
    var viewer = jQuery.extend({}, this.props.viewer, this.state);
    AccountStore.editViewer(viewer);
  },

  render: function() {
    if(!this.props.viewer) { return null; }
    return <div className="modal" id="edit" tabIndex="-1" role="dialog" style={{display: (this.props.viewer && this.props.viewer.type === 'viewer') ? 'block' : 'none'}}>
      <div className="modal-dialog">
        <div className="modal-content">
          <div className="modal-header">
            <button type="button" className="close" onClick={AccountStore.cancelPrompt} >×</button>
            <h4 className="modal-title custom_align" id="Heading">{this.state.isNew ? 'Add' : 'Edit'} Your Detail</h4>
          </div>
          <div className="modal-body">
            <div className="form-group">
              <input className="form-control" type="text" placeholder="First Name" name="firstName" value={this.state.firstName} onChange={this.handleChange} />
            </div>
            <div className="form-group">
              <input className="form-control" type="text" placeholder="Last Name" name="lastName" value={this.state.lastName} onChange={this.handleChange} />
            </div>
            <div className="form-group">
              <input className="form-control" type="text" placeholder="email" name="email" value={this.state.email} onChange={this.handleChange} />
            </div>
{/*}
            <h4>Assign to Group</h4>
            <div className="form-group">
              <div className="checkbox block"><label><input type="checkbox" /> Administration</label></div>
              <div className="checkbox block"><label><input type="checkbox" /> Employees</label></div>
              <div className="checkbox block"><label><input type="checkbox" /> Alumni</label></div>
              <div className="checkbox block"><label><input type="checkbox" /> Donors</label></div>
            </div>
*/}
          </div>
          <div className="modal-footer ">
            <button type="button" onClick={this.editViewer} className="btn btn-lg standard-button2" style={{width: '100%'}}>
              <span className="glyphicon glyphicon-ok-sign"></span> {this.state.isNew ? 'Add' : 'Update'}
            </button>
          </div>
        </div>
      </div>
    </div>;
  }

});
