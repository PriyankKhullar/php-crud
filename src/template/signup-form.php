<?php
session_start();
include '../../config/common-url.php';
require_once AUTO_LOAD;

use \App\Modules\Header;
use \App\Modules\MenuBar;
use \App\Modules\BlogQueries;
use \App\Modules\Footer;

$header = new Header;  //create obj of header.
$header->TemplateHeader();  //call templateHeader.

$menuBar = new MenuBar;  //create object of menuBar.
$menuBar->getContent(); //call getContent of menu.

$queries = new BlogQueries; //create object of BlogQueries.
$queries->insertUser(); //call insertUser.

?>
<!-- Signup Form -->
<section class="mbr-section mbr-section--relative mbr-section--fixed-size" id="form1-89" style="background-color: rgb(239, 239, 239);">
  <div class="mbr-section__container mbr-section__container--std-padding container">
    <div class="row">
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2 signup-form" data-form-type="formoid">
            <div class="mbr-header mbr-header--center mbr-header--std-padding">
              <h2 class="mbr-header__text">SIGNUP FORM</h2>
            </div>
            <form action="" method="post" data-form-title="CONTACT FORM">
              <div class="form-group">
                <input type="text" class="form-control" name="name" required="" placeholder="Name" data-form-field="Name">
              </div>
              <div class="form-group">
                <input type="email" class="form-control" name="email" required="" placeholder="Email" data-form-field="Email">
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" required="" placeholder="Password" data-form-field="Password">
              </div>
              <div class="form-group">
                <input type="checkbox" onclick="showPassword()" data-form-field="showPassword"> Show Password
              </div>
              <div class="mbr-buttons mbr-buttons--right">
                <button type="submit" name="submit" class="mbr-buttons__btn btn btn-lg btn-block btn-warning">SUBMIT</button>
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