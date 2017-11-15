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
$queries->insertLike();
$queries->viewSinglePost(); //call viewSinglePost.
$queries->displayComments(); //call displayComments.

$footer = new Footer; //create obj of header.
$footer->getContent();  //call getContent of footer.