<?php
	include_once 'config.php';
	_session_start();
	if (!logged_in()) {
            header('Location: '.$app_url);
	}
	
	function text_input($label, $id) {
		echo PHP_EOL;
		echo '			<div class="form-group form-group-lg">'.PHP_EOL;
		echo '				<label for="'.$id.'" class="col-sm-4 control-label">'.$label.'</label>'.PHP_EOL;
		echo '				<div class="col-sm-8">'.PHP_EOL;
		echo '					<input type="text" class="form-control" id="'.$id.'" name="'.str_replace('-', '_', $id).'">'.PHP_EOL;
		echo '				</div>'.PHP_EOL;
		echo '			</div>'.PHP_EOL;
	}
	function file_input($label, $id) {
		echo PHP_EOL;
		echo '			<div class="form-group form-group-lg">'.PHP_EOL;
		echo '				<label for="'.$id.'-input" class="col-sm-4 control-label">'.$label.'</label>'.PHP_EOL;
		echo '				<div class="col-sm-4">'.PHP_EOL;
		echo '					<input type="hidden" id="'.$id.'" name="'.str_replace('-', '_', $id).'" value="">'.PHP_EOL;
		echo '					<input type="file" id="'.$id.'-input" name="'.str_replace('-', '_', $id).'_input">'.PHP_EOL;
		echo '				</div>'.PHP_EOL;
		echo '				<div class="col-sm-4">'.PHP_EOL;
		echo '					<img id="'.$id.'-img"  src="" alt="No '.$label.' Selected" height="100" width="100">'.PHP_EOL;
		echo '					<button  type="button" class="btn btn-default btn-sm" onclick="clearImage(\''.$id.'\')">Clear Image</button>'.PHP_EOL;
		echo '				</div>'.PHP_EOL;
		echo '			</div>'.PHP_EOL;
	}
	function select_input($label, $id, $options) {
		echo '			<div class="form-group form-group-lg">'.PHP_EOL;
		echo '				<label for="'.$id.'" class="col-sm-4 control-label">'.$label.'</label>'.PHP_EOL;
		echo '				<div class="col-sm-8">'.PHP_EOL;
		echo '					<select class="form-control" id="'.$id.'" name="'.str_replace('-', '_', $id).'">'.PHP_EOL;
		foreach ($options as $option) {
			echo "						<option value=\"$option\">".ucwords($option)."</option>".PHP_EOL;
		}
		echo '					</select>'.PHP_EOL;
		echo '				</div>'.PHP_EOL;
		echo '			</div>'.PHP_EOL;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GiveToken.com - Create Recruiting Token</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/recruiting_token.css">
</head>	
<body>
	<div id="center-column">
		<form class="form-horizontal" id="recruiting-token-form">
			<input type="hidden" id="id" name="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : null); ?>">
			<div class="input-section" id="required-info">
				<h1>Required Info</h1>
				<?php text_input('Job Title', 'job-title'); ?>
				<?php text_input('Job Description', 'job-description'); ?>
			</div>
			<div class="input-section" id="basic-info">
				<h1>Basic Info</h1>
				<?php text_input('Job Location(s)', 'job-locations'); ?>
				<?php text_input('Skills Required', 'skills-required'); ?>
				<?php text_input('Responsibilities', 'responsibilities'); ?>
				<?php text_input('Perks', 'perks'); ?>
			</div>
			<div class="input-section" id="important-info">
				<h1>Important Info</h1>
				<?php text_input('Company', 'company'); ?>
				<?php text_input('Salary Range', 'salary-range'); ?>
				<?php text_input('Full-Time or Part-Time', 'full-time-part-time'); ?>
			</div>
			<div class="input-section" id="special-info">
				<h1>Special Info</h1>
				<?php text_input('Ask Candidate if Interested? (suggested)', 'ask-interested'); ?>
				<?php text_input('Ask Candidate for desired Salary? (pending)', 'ask-salary'); ?>
				<?php text_input('Ask Candidate if Remote or in Person? (pending)', 'ask-remote'); ?>
			</div>
			<div class="input-section" id="advanced-info">
				<h1>Advanced Info</h1>
				<?php text_input('Company Video', 'company-video'); ?>
				<?php file_input('Company Picture', 'company-picture'); ?>
				<?php text_input('Company TagLine (14-0 char)', 'company-tagline'); ?>
				<?php text_input('Company Values', 'company-values'); ?>
				<?php file_input('Backdrop Picture', 'backdrop-picture'); ?>
				<?php text_input('Backdrop Color', 'backdrop-color'); ?>
				<?php 
					$styles[0] = 'engineering';
					$styles[1] = 'business';
					$styles[2] = 'creative';
					select_input('Style', 'style', $styles); 
				?>
				<?php 
					$sizes[0] = 'start-up';
					$sizes[1] = 'fortune 100/500';
					select_input('Special Size', 'special-size', $sizes); 
				?>

			</div>
			<div class="input-section" id="social-media-info">
				<h1>Social Media Info</h1>
				<?php text_input('Company\'s Facebook', 'company-facebook'); ?>
				<?php text_input('Company\'s LinkedIn', 'company-linkedin'); ?>
				<?php text_input('Company\'s Twitter', 'company-twitter'); ?>
				<?php text_input('Company\'s YouTube Channel', 'company-youtube'); ?>
			</div>
			<div class="input-section" id="button-section">
				<button type="button" class="btn btn-primary btn-lg" id="save-button" onclick="saveRecruitingToken()">Save</button>
			</div>
		</form>
	</div>
	
	<script src="js/create_recruiting.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script>
		$('#company-picture-input').on('change', handleImageFileSelect);
		$('#backdrop-picture-input').on('change', handleImageFileSelect);
		$('#company-picture-img').data("saved", true);
		$('#backdrop-picture-img').data("saved", true);
	</script>
</body>
</html>