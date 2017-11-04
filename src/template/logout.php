<?php
include '../../config/common-url.php';
require_once AUTO_LOAD;

use \App\Modules\Authentication;
use \App\Modules\Header;
use \App\Modules\MenuBar;
use \App\Modules\Footer;

$authentication = new Authentication;  //create obj of Authentication.
$authentication->logout(); //call logout.

$header = new Header; //create obj of header.
$header->TemplateHeader();  //call templateHeader.

$menuBar = new MenuBar; //create obj of MenuBar.
$menuBar->getContent(); //call getContent of menuBar.
?>
<!-- logout Section -->
<section class="mbr-section mbr-section--relative mbr-section--fixed-size" id="form1-89">
	<div class="mbr-section__container mbr-section__container--std-padding container">
		<div class="mbr-header mbr-header--wysiwyg row">
			<div class="col-sm-10 col-sm-offset-2">
				<h3 class="mbr-header__text">Thanks for Visiting my mobirise template.</h3>
				<p class="mbr-header__subtext">Click here to go home page <a href="<?php echo LINK_BASE_PATH; ?>">Home</a></p>
			</div>
		</div>
	</div>
</section>
<?php 
$footer = new Footer; //create obj of Footer.
$footer->getContent(); //call getContent of footer.