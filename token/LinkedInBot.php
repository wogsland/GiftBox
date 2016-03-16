<?php
use \Sizzle\{
    City,
    RecruitingCompany,
    RecruitingCompanyImage,
    RecruitingToken
};

/**
 * This is simple HTML to show the right info on LinkedIn
 */

$long_id = escape_string($long_id);
$token = new RecruitingToken($long_id, 'long_id');
$company = new RecruitingCompany($token->recruiting_company_id ?? '');
$city = new City($token->city_id ?? '');
$image = $token->screenshot();
if ($image !== false) {
    $image = APP_URL.'uploads/'.str_replace(' ', '%20',$image);
} else {
    $images = (new RecruitingCompanyImage())->getByRecruitingTokenLongId($long_id);
    if (!empty($images)) {
        $image = APP_URL.'uploads/'.str_replace(' ', '%20',$images[0]);
    }
}

if (isset($token->id)) {
    ?>
    <!doctype html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="description" content="S!zzle Recruiting Token">
      <meta name="keywords" content="">
      <meta name="author" content="S!zzle">
    </head>
    <body>
      <h1>
        <?= $token->job_title?>
        <?= isset($company->name) ? '- '.$company->name : '' ?>
        - <?= $city->job_title?>
      </h1>
      <img src="<?= $image?>" title="Token screenshot or company image"/>
      <h2>Job Description</h2>
      <h2>Skills Required</h2>
      <h2>Responsibilities</h2>
      <h2>Company Values</h2>
      <h2>Perks</h2>
    </body>
    </html>
<?php }?>
