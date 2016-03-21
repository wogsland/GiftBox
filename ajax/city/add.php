<?php
use Sizzle\Database\City;

$success = 'false';
$data = '';
if (logged_in() && is_admin()) {
    $vars = [
       'name',
       'image_file',
       'population',
       'longitude',
       'latitude',
       'county',
       'country',
       'timezone',
       'temp_hi_spring',
       'temp_lo_spring',
       'temp_avg_spring',
       'temp_hi_summer',
       'temp_lo_summer',
       'temp_avg_summer',
       'temp_hi_fall',
       'temp_lo_fall',
       'temp_avg_fall',
       'temp_hi_winter',
       'temp_lo_winter',
       'temp_avg_winter'
    ];
    $missing_var = false;
    $City = new City();
    foreach ($vars as $var) {
        if (isset($_POST[$var]) && '' != $_POST[$var]) {
            $City->$var = escape_string($_POST[$var]);
        } else {
            $missing_var = true;
        }
    }
    if (!$missing_var) {
        $success = $City->save() ? 'true' : 'false';
    }
}

header('Content-Type: application/json');
echo json_encode(array('success'=>$success, 'data'=>$data));
