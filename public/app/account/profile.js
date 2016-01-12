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
                  <button className="btn btn-primary btn-bordered">Create GiveToken</button>
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

  renderAbout: function(about, expanded) {
    if(about.length < 180) {
      return <p className="mb30 small-txt">{about}</p>;
    } else if(expanded) {
      return <p className="mb30 small-txt">{about} <a href="#" onClick={this.toggleExpanded}>Show Less</a></p>;
    } else {
      return <p className="mb30 small-txt">{about.substr(0, 172)}... <a href="#" onClick={this.toggleExpanded}>Show More</a></p>;
    }
  },

  renderSocial: function(social) {
    return <li key={social.name}><i className={'fa ' + social.icon}></i> <a href= {"https://" + social.url} >{social.url}</a></li>
  }

});
