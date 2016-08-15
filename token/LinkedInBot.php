<?php
use \Sizzle\Bacon\Database\{
    City,
    RecruitingCompany,
    RecruitingCompanyImage,
    RecruitingToken
};

/**
 * This is simple HTML to show the right info on LinkedIn
 */
$token = new RecruitingToken($long_id, 'long_id');
$company = new RecruitingCompany($token->recruiting_company_id ?? '');
$city_names = '';
$cities = $token->getCities();
foreach ($cities as $city) {
  $city_names .= $city->name.' - ';
}
$city_names = rtrim($city_names, ' - ');
$images = (new RecruitingCompanyImage())->getByRecruitingTokenLongId($long_id);
if (!empty($images)) {
    $image = APP_URL.'uploads/'.str_replace(' ', '%20', $images[0]['file_name']);
} else {
    $image = $token->screenshot();
    if ($image !== false) {
        $image = APP_URL.'uploads/'.str_replace(' ', '%20', $image);
    }
}

if (isset($token->id)) {
    ?>
    <!doctype html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="description" content="<?=$token->job_title?>">
      <meta name="keywords" content="">
      <meta name="author" content="S!zzle">
    </head>
    <body>
      <h1>
        <?=$token->job_title?>
        <?= isset($company->name) ? '- '.$company->name : '' ?>
        - <?=$city_names?>
      </h1>
        <?php if ('' != $image) { ?>
          <img src="<?= $image?>" title="Token screenshot or company image"/>
        <?php }?>
        <?php if (isset($token->job_description) && '' != $token->job_description) { ?>
          <h2>Job Description</h2>
            <?= $token->job_description?>
        <?php }?>
        <?php if (isset($token->skills_required) && '' != $token->skills_required) { ?>
          <h2>Skills Required</h2>
            <?= $token->skills_required?>
        <?php }?>
        <?php if (isset($token->responsibilities) && '' != $token->responsibilities) { ?>
          <h2>Responsibilities</h2>
            <?= $token->responsibilities?>
        <?php }?>
        <?php if (isset($company->values) && '' != $company->values) { ?>
          <h2>Company Values</h2>
            <?= $company->values?>
        <?php }?>
        <?php if (isset($token->perks) && '' != $token->perks) { ?>
          <h2>Perks</h2>
            <?= $token->perks?>
        <?php }?>
    </body>
    </html>
<?php }?>
