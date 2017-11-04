<?php namespace App\Modules;

class Header
{
	function TemplateHeader()
	{
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="generator" content="Mobirise v2.6.1, mobirise.com">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="shortcut icon" href="<?php echo PUBLIC_PATH.'images/discover-mobile-350x350-16.png" type="image/x-icon'?>">
			<meta name="description" content="">
			<title>MOBIRISE</title>
			<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:700,400&amp;subset=cyrillic,latin,greek,vietnamese">
			<link rel="stylesheet" href="<?php echo PUBLIC_PATH.'css/bootstrap.min.css'?>">
			<link rel="stylesheet" href="<?php echo PUBLIC_PATH.'css/style.css'?>">
			<link rel="stylesheet" href="<?php echo PUBLIC_PATH.'css/slider-style.css'?>">
			<link rel="stylesheet" href="<?php echo PUBLIC_PATH.'css/gallery-style.css'?>">
			<link rel="stylesheet" href="<?php echo PUBLIC_PATH.'css/mbr-additional.css'?>" type="text/css">
		</head>
		<section class="content-2 simple col-1 col-undefined mbr-parallax-background mbr-after-navbar" id="content5-77" style="background-image: url(<?php echo PUBLIC_PATH.'images/iphone-926663-1920-1920x1280-94.jpg';?>);">
			<div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(0, 0, 0);"></div>
			<div class="container">
				<div class="row">
					<div>
						<div class="thumbnail">
							<div class="caption">
								<h3>MOBIRISE</h3>
								<div><p>Create blogs via login or signup<br></p></div>
							</div>
						</div>
					</div> 
				</div>
			</div>
		</section>
		</html>
		<?php
	}
}