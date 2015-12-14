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
            <ul className="nav nav-tabs nav-line">
                {/* <!--<li className="active"><a href="#activities" data-toggle="tab"><strong>Activities</strong></a></li>--> */}
                {/* <!--<li className="active"><a href="#givetokens" data-toggle="tab"><strong>My Tokens</strong></a></li>--> */}
                {/* <!--<li className=""><a href="#messages" data-toggle="tab"><strong>Messages</strong></a></li>--> */}
                {/* <li className=""><a href="#viewers" data-toggle="tab"><strong>Viewers</strong></a></li> */}
                {/* <li className="active"><a href="#account" data-toggle="tab"><strong>Account Info</strong></a></li> */}
                {/* <!-- Manage Users will only be for enterprise --> */}
                {/* <!--<li className=""><a href="#users" data-toggle="tab"><strong>Manage Users</strong></a></li>--> */}
                {/* <!--<li className="navbar-right"><a href="/"><strong>Home</strong></a></li>--> */}
            </ul>
            <div className="tab-content nopadding noborder">
              {/* <!--<AccountActivities />--> */}
              <AccountTokenAnalytics />
              <AccountTokens tokens={this.props.model.tokens} />
              {/* <!-- Messages --> */}
              <AccountViewers viewers={this.props.model.viewers} />
              <AccountInfo profile={this.props.model.profile} />
              <AccountUsers users={this.props.model.users} />
            </div>

            <AccountViewerEdit viewer={this.props.model.editing} />
            <AccountUserEdit user={this.props.model.editing} />
            <AccountUserRemove user={this.props.model.removing} />

          </div>
        </div>
      </div>;
    } else {
      return <div className="contentpanel">
        <div className="row">
          <AccountProfile model={this.props.model} />
          <div className="col-sm-8 col-md-9">
            <ul className="nav nav-tabs nav-line">
                {/* <!--<li className="active"><a href="#activities" data-toggle="tab"><strong>Activities</strong></a></li>--> */}
                {/* <!--<li className="active"><a href="#givetokens" data-toggle="tab"><strong>My Tokens</strong></a></li>--> */}
                {/* <!--<li className=""><a href="#messages" data-toggle="tab"><strong>Messages</strong></a></li>--> */}
                {/* <li className=""><a href="#viewers" data-toggle="tab"><strong>Viewers</strong></a></li> */}
                {/* <li className="active"><a href="#account" data-toggle="tab"><strong>Account Info</strong></a></li> */}
                {/* <!-- Manage Users will only be for enterprise --> */}
                {/* <!--<li className="navbar-right"><a href="/"><strong>Home</strong></a></li>--> */}
            </ul>
            <div className="tab-content nopadding noborder">
              {/* <!--<AccountActivities />--> */}
              {/* <!--<AccountTokenAnalytics />--> */}
              {/* <!--<AccountTokens tokens={this.props.model.tokens} />--> */}
              {/* <!-- Messages --> */}
              <AccountViewers viewers={this.props.model.viewers} />
              <AccountInfo profile={this.props.model.profile} />
              <AccountUsers users={this.props.model.users} />
            </div>

            <AccountViewerEdit viewer={this.props.model.editing} />
            <AccountUserEdit user={this.props.model.editing} />
            <AccountUserRemove user={this.props.model.removing} />

          </div>
        </div>
      </div>;
    }
  },

  _onChange: function() {
    this.setState(Model);
  }

});
