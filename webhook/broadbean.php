<?php
use Sizzle\Bacon\Service\MandrillEmail;

//for testing purposes
$_POST['job'] = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<job>
    <command>add</command>
    <username>bobsmith</username>
    <password>p455w0rd</password>
    <contact_name>Bob Smith</contact_name>
    <contact_email>bob@smith.com</contact_email>
    <contact_telephone>020 7987 6900</contact_telephone>
    <contact_url>www.smith.com</contact_url>
    <days_to_advertise>7</days_to_advertise>
    <application_email>bob.12345.123@smith.aplitrak.com</application_email>
    <application_url>http://www.url.com/ad.asp?adid=12345123</application_url>
    <job_reference>abc123</job_reference>
    <job_title>Test Engineer</job_title>
    <job_type>Contract</job_type>
    <job_id>abc123_1234567</job_id>
    <job_duration>6 Months</job_duration>
    <job_startdate>ASAP</job_startdate>
    <job_skills>VB, C++, PERL, Java</job_skills>
    <job_description>This is the detailed description</job_description>
    <job_location>London</job_location>
    <job_industry>Marketing</job_industry>
    <salary_currency>gbp</salary_currency>
    <salary_from>25000</salary_from>
    <salary_to>30000</salary_to>
    <salary_per>annum</salary_per>
    <salary_benefits>Bonus and Pension</salary_benefits>
    <salary>£25000 - £30000 per annum + Bonus and Pension</salary>
</job>";

// record webhook hit post associated with web request
$xml = $_POST['job'];

// parse XML
$p = xml_parser_create();
xml_parse_into_struct($p, $xml, $vals, $index);
xml_parser_free($p);
$html = '';
foreach ($vals as $val) {
    if (2 == $val['level']) {
        $html .= $val['tag'].': '.$val['value']."<br />\n";
    }
}

// create token

// email Robbie
if (ENVIRONMENT != 'production') {
    $to = TEST_EMAIL;
} else {
    $to = 'sales@gosizzle.io';
}
$mandrill = new MandrillEmail();
$mandrill->send(
    array(
        'to'=>array(array('email'=>$to)),
        'from_email'=>'broadbean@gosizzle.io',
        'from_name'=>'Broadbean Webhook',
        'subject'=>'New Broadbean Submission',
        'html'=>$html
    )
);

// respond
$response = 'success';
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo "\n";
echo "<response>$response</response>";
