<?php
use \GiveToken\RecruitingTokenResponse;

if (!logged_in() || !is_admin()) {
    header('Location: '.$app_root);
}

define('TITLE', 'GiveToken.com - Top Ten Tokens');
require __DIR__.'/../header.php';
?>
<style>
body {
  background-color: white;
}
#top-ten-table {
  margin-top: 100px;
  color: black;
}
</style>
</head>
<body id="visitors">
  <div>
    <?php require __DIR__.'/../navbar.php';?>
  </div>
  <div class="row">
    <div class="col-sm-offset-3 col-sm-6" id="top-ten-table">
      <h2>TOP TEN TOKENS</h2>
      <table class="table table-striped table-hover">
        <thead>
          <th>Responses</th>
          <th>Hits</th>
          <th>Token</th>
          <th>Author</th>
          <th>Created</th>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT count(*) as hits,
                  (SELECT count(*)
                  FROM recruiting_token_response
                  WHERE recruiting_token_response.recruiting_token_id = recruiting_token.id
                  ) AS responses,
                  recruiting_token.job_title, recruiting_token.long_id, recruiting_token.created,
                  user.email_address, user.first_name, user.last_name
                  FROM web_request, recruiting_token, user
                  WHERE uri LIKE '/ajax/recruiting_token/get/%'
                  AND SUBSTR(uri, LOCATE('get/', uri)+4) = recruiting_token.long_id
                  AND user.id = recruiting_token.user_id
                  GROUP BY uri
                  ORDER BY responses DESC, hits DESC
                  LIMIT 10";
          $results = execute_query($sql);
          $rows = array();
          while ($row = $results->fetch_assoc()) { ?>
              <tr>
                <td><?php echo $row['responses'];?></td>
                <td><?php echo $row['hits'];?></td>
                <td><a href="/token/recruiting/<?php echo $row['long_id'];?>" target=_blank>
                  <?php echo $row['job_title'];?>
                </a></td>
                <td><?php echo "{$row['first_name']} {$row['last_name']} ({$row['email_address']})";?></td>
                <td><?php echo $row['created'];?></td>
              </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
  </div>
  <?php require __DIR__.'/../footer.php';?>
</body>
</html>
