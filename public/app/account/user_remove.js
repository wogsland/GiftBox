var AccountUserRemove = React.createClass({

  removeUser: function() {
    if(this.props.user.username) {
      AccountStore.removeUser(this.props.user);
    } else {
      AccountStore.removeViewer(this.props.user);
    }
  },

  render: function() {
    return <div className="modal" id="delete" tabIndex="-1" role="dialog" style={{display: this.props.user ? 'block' : 'none'}}>
      <div className="modal-dialog">
        <div className="modal-content">
          <div className="modal-header">
            <button type="button" className="close" onClick={AccountStore.cancelPrompt} >×</button>
            <h4 className="modal-title custom_align" id="Heading">Delete this entry</h4>
          </div>
          <div className="modal-body">
            <div className="alert alert-warning">
              <span className="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?
            </div>
          </div>
          <div className="modal-footer ">
            <button type="button" className="btn btn-success" onClick={this.removeUser} ><span className="glyphicon glyphicon-ok-sign"></span> Yes</button>
            <button type="button" className="btn btn-default" onClick={AccountStore.cancelPrompt} ><span className="glyphicon glyphicon-remove"></span> No</button>
          </div>
        </div>
      </div>
    </div>;
  }

});
