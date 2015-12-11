var AccountTokenAnalytics = React.createClass({

  render: function() {
    return <div className="tab-pane" id="tokenanalytics">
      	<div className="contentpanel">
	      	<div className="row">
	      		<div className="col-sm-3">
	      			<button href="#givetokens" data-toggle="tab" className="btn btn-primary btn-sm btn-bordered"><span className="glyphicon glyphicon-chevron-left"></span>Back To My Tokens</button>
	      		</div>
	      	</div>
	      	<div className="row">
	      		<div className="col-sm-6">
	      			<h2>Title of the Token</h2>
	      			<img src={'assets/img/token-varied-01.png'} width="415"></img>
	      		</div>
	      		<div className="col-sm-6">
	      			<h3>Total Views</h3>
	      			<h3>Unique Views</h3>
	      			<h3>Average Time on the Page</h3>
	      			<h3>Bounces</h3>
	      		</div>
	      	</div>
      	</div>
      	</div>;
  }
});