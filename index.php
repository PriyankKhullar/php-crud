<?php
session_start();
include 'config/common-url.php';
require_once AUTO_LOAD;

use \Config\Connection;
use \Config\DatabaseTable;
use \App\Modules\Header;
use \App\Modules\MenuBar;
use \App\Modules\BlogQueries;
use \App\Modules\Footer;

$connection = new Connection;   //create obj of Connection.
$connection->createDataBase();  //call createDataBase.

$table = new DatabaseTable; //create obj of DatabaseTable.
$table->createTable();  //call createTable.

$header = new Header;  //create obj of header.
$header->TemplateHeader();  //call templateHeader.

$queries = new BlogQueries; //create object of BlogQueries.
$queries->deletePost(); //call deletePost.
$queries->insertLike(); //call insertLike.

$menuBar = new MenuBar;  //create object of menuBar.
$menuBar->getContent(); //call getContent of menu.
?>
<!-- Section For Search -->
<section class="mbr-section" id="header3-78">
    <div class="mbr-section__container container mbr-section__container--first">
        <div class="mbr-header mbr-header--wysiwyg row">
            <div class="col-sm-10 col-sm-offset-2">
                <form method="get" action="" class="form-inline pull-right">
                    <input type="text" class="form-control search-box" name="search-post" placeholder="Search">
                    <input type="submit" class="cta-subscribe btn btn-primary" name="search-btn" value="Search">
                </form>
            </div>
        </div>
    </div>
</section>
<?php 
$queries->showPosts(); //call showPosts.
?>

<!-- Section for pagination -->
<section class="mbr-section" id="header3-78">
    <div class="mbr-section__container container mbr-section__container--first">
        <div class="mbr-header mbr-header--wysiwyg row">
            <div class="col-sm-8 col-sm-offset-2">
                <?php if(!isset($_GET['category_id'])){ $queries->pagination(); }//call pagination ?>
            </div>
        </div>
    </div>
</section>
<?php
$footer = new Footer; //create obj of header.
$footer->getContent();  //call getContent of footer.