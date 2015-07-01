var AccountTokens = React.createClass({

  render: function() {
    return <div className="tab-pane" id="givetokens">
      <h2>My Tokens</h2>
      {this.props.tokens.map(this.renderToken)}
    </div>;
  },

  renderToken: function(token) {
    return <div className="col-md-3 col-xs-6 text-center" key={token.id}>
      <img href='token_analytics.php' onClick = {function(){window.open('token_analytics.php?id=' + token.id)}} src={'assets/img/token-varied-' + token.variant + '.png'} alt={token.name} width="78" /><br/>
      <div className="main-color"><a onClick = {function(){window.open('preview.php?id=' + token.id)}}>{token.name}</a></div>
      For: {token.for}
    </div>;
  }

});
