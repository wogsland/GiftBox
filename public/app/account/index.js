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
    return <div className="contentpanel">
      <div className="row">
        <div className="col-sm-4 col-md-3">
          <div className="text-center">
            <img src={this.getAvatar(this.props.model.profile)} className="img-circle img-offline img-responsive img-profile" alt={this.props.model.profile.name} />
            <h4 className="profile-name mb5">{this.props.model.profile.name}</h4>
            <div className="mb20"></div>

            <div className="btn-group">
                <a href="/create_recruiting">
                    <button className="btn btn-primary btn-bordered">Create Token</button>
                </a>
                <br /><br />
                <a href="/token_responses">
                    <button className="btn btn-primary btn-bordered">See Responses</button>
                </a>
                <br /><br />
                <a href="/iframe_code">
                    <button className="btn btn-primary btn-bordered">Embeddable Job Listing</button>
                </a>
                <br /><br />
                <a href="/pricing">
                  <button type="button" className="btn btn-success" id="upgrade-button">Upgrade</button>
                </a>
            </div>

            <div className="mb20"></div>
          </div>
        </div>
        <div className="col-sm-8 col-md-9">
          <div className="tab-content nopadding noborder">
            <AccountInfo profile={this.props.model.profile} />
          </div>
        </div>
      </div>
    </div>;
  },

  _onChange: function() {
    this.setState(Model);
  },

  getAvatar: function(user) {
    return (user.email && user.email !== '') ? 'http://www.gravatar.com/avatar/' + CryptoJS.MD5(user.email) : '/assets/img/user.png';
  },

});
