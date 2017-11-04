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
$queries->insertPost(); //call insertPost.
$data = $queries->selectEditData(); //call selectEditData.

?>
<!-- Add or Edit Form -->
<section class="mbr-section mbr-section--relative mbr-section--fixed-size" id="form1-89" style="background-color: rgb(239, 239, 239);">
  <div class="mbr-section__container mbr-section__container--std-padding container">
    <div class="row">
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2 signup-form" data-form-type="formoid">
            <div class="mbr-header mbr-header--center mbr-header--std-padding">
              <h2 class="mbr-header__text"><?php if(isset($_GET['uid'])){ echo 'EDIT YOUR POST'; }else { echo "ADD NEW POST"; }?></h2>
            </div>
            <form action="" method="post" data-form-title="CONTACT FORM" enctype="multipart/form-data">
              <div class="form-group">
                <input type="text" class="form-control" name="author" required="" placeholder="Author Name" value="<?php if(isset($_GET['uid'])){ echo $data['post_author']; } ?>" data-form-field="Author Name">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="title" required="" placeholder="Title" value="<?php if(isset($_GET['uid'])){ echo $data['post_title']; } ?>" data-form-field="Title">
              </div>
              <div class="form-group">
                <textarea type="text" class="form-control" rows="6" name="description" required=""  placeholder="Description" data-form-field="Description"><?php if(isset($_GET['uid'])){ echo $data['post_description']; } ?></textarea>
              </div>
              <div class="form-group">
                <input type="file" name="image" required="" data-form-field="Image"><?php if(isset($_GET['uid'])){ ?><br><img src="<?php echo PUBLIC_PATH.'upload-img/'.$data['post_img']; ?>" alt="img" width='150px'><?php } ?>
              </div>
              <div class="form-group">
                <strong>Select Catagories</strong>
                <select name="category">
                  <?php $queries->dropdown(); ?>
                </select>
              </div>
              <div class="mbr-buttons mbr-buttons--right">
                <button type="submit" name="save_post" class="mbr-buttons__btn btn btn-lg btn-block btn-warning"><?php if(isset($_GET['uid'])){ echo 'SAVE'; }else { echo "CREATE"; }?>
                </button>
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