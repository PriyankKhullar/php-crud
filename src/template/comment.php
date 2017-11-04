<?php
session_start();
include '../../config/common-url.php';
require_once AUTO_LOAD;

use \App\Modules\Header;
use \App\Modules\MenuBar;
use \App\Modules\BlogQueries;
use \App\Modules\Footer;

$header = new Header; //create obj of header.
$header->TemplateHeader();  //call templateHeader.

$menuBar = new MenuBar; //create object of menuBar.
$menuBar->getContent(); //call getContent of menu.

$queries = new BlogQueries; //create object of BlogQueries.
$queries->insertComment();  //call insertComment.

?>
<!-- Commenting Form -->
<script type='text/javascript' src='../../public/js/captcha-function.js'></script>
<section class="mbr-section mbr-section--relative mbr-section--fixed-size" id="form1-89" style="background-color: rgb(239, 239, 239);">
  <div class="mbr-section__container mbr-section__container--std-padding container">
    <div class="row">
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2 signup-form" data-form-type="formoid">
            <div class="mbr-header mbr-header--center mbr-header--std-padding">
              <h2 class="mbr-header__text">Comment</h2>
            </div>
            <form action="" method="post" data-form-title="CONTACT FORM" enctype="multipart/form-data" name="form1" id="form1">
              <div class="form-group">
                <input type="text" class="form-control" name="name" required="" placeholder="Name" data-form-field="Author Name" value="<?php if(isset($_SESSION['user']['user_email'])){
                  echo $_SESSION['user']['user_name'];
                }?>">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="comment" required="" data-form-field="comment" placeholder="Comment">
              </div>
              <div class="form-group">
                <label for='message'>Enter this code :</label>
                <img src="captcha.php?rand=<?php echo rand();?>" id='captchaimg'><br><br>
                Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.</td>
                <input id="captcha_code" class="captcha_input" name="captcha_code" type="text" placeholder="Enter the code"><br><br>
              </div>
              <div class="mbr-buttons mbr-buttons--right">
                <button type="submit" name="comment_btn" onclick="return validate();" class="mbr-buttons__btn btn btn-lg btn-block btn-warning">Comment</button>
              </div>
            </form>
          </div>
        </div>  
      </div>
    </div>
  </div>
</section>
<?php 
$footer = new Footer; //create obj of header.
$footer->getContent();  //call getContent of footer.