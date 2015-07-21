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
          <div className="small-txt mb5"><i className="fa fa-gift"></i> {this.props.model.tokens.length} Tokens</div>
          <div className="small-txt mb5"><i className="fa fa-star"></i> XXYYZZ Token Views</div>
          {/* 
            <div className="small-txt mb5"><i className="fa fa-map-marker"></i> {this.props.model.profile.location}</div>
            <div className="small-txt mb5"><i className="fa fa-briefcase"></i> {this.props.model.profile.position} at <a href="">{this.props.model.profile.company}</a></div>
          */}
          <div className="mb20"></div>

          <div className="btn-group">
              <a href="create.php"><button className="btn btn-primary btn-bordered">Create GiveToken</button></a>
              {/* <button className="btn btn-primary btn-bordered">Send GiveToken</button> */}
          </div>

          <div className="mb20"></div>
      </div>
      {/* 
          <h5 className="md-title">About</h5>
          {this.renderAbout(this.props.model.profile.about, this.state.expanded)}
          <h5 className="md-title">Connect</h5>
          <ul className="list-unstyled social-list">
          {this.props.model.profile.social.map(this.renderSocial)}
          </ul> 
      */}
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
