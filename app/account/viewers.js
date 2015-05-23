var AccountViewers = React.createClass({

  render: function() {
    return <div className="tab-pane" id="viewers">
{/*
      <div className="row">
        <div className="col-md-9 pull-left"><h2 className="mt0">Groups (X/Y)</h2></div>
        <div className="col-md-3 pull-right mt10"><a href="#" className="btn btn-success btn-block btn-create-msg">Create Group</a></div>
      </div>
      <div className="form-group">
        <div className="checkbox block"><label><input type="checkbox" /> Administration</label></div>
        <div className="checkbox block"><label><input type="checkbox" /> Employees</label></div>
        <div className="checkbox block"><label><input type="checkbox" /> Alumni</label></div>
        <div className="checkbox block"><label><input type="checkbox" /> Donors</label></div>
      </div>
      <hr/>
*/}
      <div className="row">
        <div className="col-md-9 pull-left"><h2 className="mt0">Viewers</h2></div>
        <div className="col-md-3 pull-right mt10">
          <a href="#" onClick={AccountStore.promptToAddViewer} className="btn btn-success btn-block btn-create-msg">Add Viewer</a>
        </div>
      </div>
      <div className="row dataTable">
        <div className="col-md-12">
          <div className="table-responsive">

            <table id="dataTable" className="table table-bordred table-striped">
              <thead>
                <th></th>
                <th>Name</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Delete</th>
              </thead>
              <tbody>
                {this.props.viewers.map(this.renderViewer)}
              </tbody>
            </table>

            <div className="clearfix"></div>
{/*
        <ul className="pagination pagination-split pagination-circled nomargin pull-right">
            <li className="disabled"><a href="#"><i className="fa fa-angle-left"></i></a></li>
            <li><a href="#">1</a></li>
            <li className="active"><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#"><i className="fa fa-angle-right"></i></a></li>
        </ul>
        </div>
      </div>
      </div>
      <hr/>
*/}
          </div>
        </div>
      </div>
    </div>
  },

  renderViewer: function(viewer) {
    return <tr key={viewer.id}>
      <td><input type="checkbox" className="checkthis" /></td>
      <td>{viewer.firstName} {viewer.lastName}</td>
      <td>{viewer.email}</td>
      <td><p><button className="btn btn-primary btn-xs" data-title="Edit" onClick={function() { AccountStore.promptToEditViewer(viewer); }} ><span className="glyphicon glyphicon-pencil"></span></button></p></td>
      <td><p><button className="btn btn-danger btn-xs" data-title="Delete" onClick={function() { AccountStore.promptToRemoveViewer(viewer); }} ><span className="glyphicon glyphicon-trash"></span></button></p></td>
    </tr>;
  },

});
