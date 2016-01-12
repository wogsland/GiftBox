var Account = React.createClass({

  getInitialState: function() {
    return Model;
  },

  componentDidMount: function() {
    AccountStore.addChangeListener(this._onChange);
  },

  componentWillUnmount: function() {
    AccountStore.removeChangeListener(this._onChange);
  },

  render: function() {
    if (this.props.model.profile.admin == "Y") {
      return <div className="contentpanel">
        <div className="row">
          <AccountProfile model={this.props.model} />
          <div className="col-sm-8 col-md-9">
            <div className="tab-content nopadding noborder">
              <AccountInfo profile={this.props.model.profile} />
            </div>

            <AccountUserEdit user={this.props.model.editing} />

          </div>
        </div>
      </div>;
    } else {
      return <div className="contentpanel">
        <div className="row">
          <AccountProfile model={this.props.model} />
          <div className="col-sm-8 col-md-9">
            <div className="tab-content nopadding noborder">
              <AccountInfo profile={this.props.model.profile} />
            </div>

            <AccountUserEdit user={this.props.model.editing} />

          </div>
        </div>
      </div>;
    }
  },

  _onChange: function() {
    this.setState(Model);
  }

});
