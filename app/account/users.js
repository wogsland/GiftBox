var AccountUsers = React.createClass({

  render: function() {
    return <div className="tab-pane" id="users">
      <h2>Manage Users</h2>
      <div className="row dataTable">
        <div className="col-md-12">
          <div className="table-responsive">

            <table id="dataTable" className="table table-bordred table-striped">
              <thead>
                {/* <th><input type="checkbox" id="checkall" /></th> */}
                <th>Name</th>
                <th>Username</th>
                <th>Password</th>
                <th>Edit</th>
                <th>Delete</th>
              </thead>
              <tbody>
                {this.props.users.map(this.renderUser)}
              </tbody>
            </table>

            <div className="clearfix"></div>
          {/*
              <ul className="pagination pull-right">
                <li className="disabled"><a href="#"><span className="glyphicon glyphicon-chevron-left"></span></a></li>
                <li className="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#"><span className="glyphicon glyphicon-chevron-right"></span></a></li>
              </ul>
          */}
          </div>
        </div>
      </div>
    </div>;
  },

  renderUser: function(user) {
    return <tr key={user.id}>
      {/* <td><input type="checkbox" className="checkthis" /></td> */}
      <td>{user.firstName} {user.lastName}</td>
      <td>{user.username}</td>
      <td>********</td>
      <td><p><button className="btn btn-primary btn-xs" data-title="Edit" onClick={function() { AccountStore.promptToEditUser(user); }} ><span className="glyphicon glyphicon-pencil"></span></button></p></td>
      <td><p><button className="btn btn-danger btn-xs" data-title="Delete" onClick={function() { AccountStore.promptToRemoveUser(user); }} ><span className="glyphicon glyphicon-trash"></span></button></p></td>
    </tr>;
  },

});
