<?php
use \Sizzle\Database\{
    RecruitingCompany,
    RecruitingCompanyImage,
    RecruitingToken
};

/**
 * This is simple HTML to show the right info on LinkedIn
 */
$token = new RecruitingToken($long_id, 'long_id');
$company = new RecruitingCompany($token->recruiting_company_id ?? '');
$image = $token->screenshot();
if ($image !== false) {
    $image = APP_URL.'uploads/'.str_replace(' ', '%20',$image);
} else {
    $images = (new RecruitingCompanyImage())->getByRecruitingTokenLongId($long_id);
    if (!empty($images)) {
        $image = APP_URL.'uploads/'.str_replace(' ', '%20',$images[0]['file_name']);
    }
}

$title = $token->job_title . (isset($company->name) ? ' at '.$company->name : '');
$description = $token->job_description ?? '';

if (isset($token->id)) {
    ?>
    <!doctype html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta property="og:type" content="website" />
      <meta property="og:site_name" content="<?=$token->job_title?>" />
      <meta property="og:title" content="<?=$title?>" />
      <meta property="og:description" content="<?=$description?>">
      <meta property="og:image" content="<?=$image ?? ''?>">
      <meta name="author" content="S!zzle">
    </head>
    <body>
    </body>
    </html>
<?php }?>
