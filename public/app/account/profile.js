var AccountProfile = React.createClass({

  getInitialState: function() {
    return {expanded: false}
  },

  toggleExpanded: function() {
    this.setState({expanded: !this.state.expanded});
  },

  render: function() {
    return <div className="col-sm-4 col-md-3">
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
              <a href="/upgrade">
                <button type="button" className="btn btn-success" id="upgrade-button">Upgrade</button>
              </a>
          </div>

          <div className="mb20"></div>
      </div>
    </div>;
  },

  getAvatar: function(user) {
    return (user.email && user.email !== '') ? 'http://www.gravatar.com/avatar/' + CryptoJS.MD5(user.email) : '/assets/img/user.png';
  },
});
