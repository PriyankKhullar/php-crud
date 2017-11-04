<?php
/**
 *  diaplay all posts nd call select query
 *  @param $key use as a values of array in which data stored.
 */
function displayAllPosts($key)
{
    $id = $key['id'];
    $user = $key['user_id'];
    ?>
    <section class="mbr-section" id="header3-78">
        <div class="mbr-section__container container mbr-section__container--first">
            <div class="mbr-header mbr-header--wysiwyg row">
                <div class="col-sm-8 col-sm-offset-2">
                    <h3 class="mbr-header__text"><?php echo $key['post_title'];?></h3>
                    <p class="mbr-header__subtext">By <?php echo $key['post_author'];?> posted <?php echo $key['posted_at'];?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="mbr-section" id="image2-83">
        <div class="mbr-section__container container mbr-section__container--middle">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <figure class="mbr-figure mbr-figure--wysiwyg mbr-figure--full-width mbr-figure--caption-inside-bottom">
                        <div>
                            <img class="mbr-figure__img" height="300px" width="500px" src= '<?php echo PUBLIC_PATH.'upload-img/'.$key['post_img'];?>'>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </section>
    <section class="mbr-section" id="content1-79">
        <div class="mbr-section__container container mbr-section__container--middle">
            <div class="row">
                <div class="mbr-article mbr-article--wysiwyg col-sm-8 col-sm-offset-2"><p><blockquote><em class="blog-description"><?php echo $key['post_description'];?></em></blockquote><a href="<?php echo SRC_PATH; ?>template/single-post.php?id=<?php echo $id; ?>" class="mbr-buttons__btn btn animated fadeInUp delay btn-primary" name="read-more" >Read More</a>
                </div>
            </div>
        </div>
        <div class="mbr-section__container container mbr-section__container--middle">
            <div class="row">
                <div class="mbr-article mbr-article--wysiwyg col-sm-8 col-sm-offset-2">
                    <?php
                    // if user login then display like button.
                    if (isset($_SESSION['user']['user_email'])){
                        $user_id = $_SESSION['user']['id']; ?>
                        <!-- view like button -->
                        <?php echo $key['total_likes'] ?><a href="<?php echo LINK_BASE_PATH;?>index.php?post_id=<?php echo $key['id'] ?>&&user_id=<?php echo $user_id ?>" class="mbr-buttons__btn animated fadeInUp delay" name="like" href=""><i class="glyphicon glyphicon-thumbs-up" style="font-size: 30px; "></i></a>

                        <!-- view Comment button -->
                        <?php echo $key['total_comments'] ?><a class="mbr-buttons__btn animated fadeInUp delay" name="comment" href="<?php echo SRC_PATH; ?>template/comment.php?comment_id=<?php echo $id;?>"><i class="glyphicon glyphicon-comment" style="font-size: 30px; "></i></a>

                        <?php
                        // display edit delete button only to those post which user is login
                        if($user == $user_id){  
                            ?>
                            <!-- view edit button -->
                            <a href="<?php echo SRC_PATH; ?>template/add-edit_post.php?uid=<?php echo $id;?>" onclick="return updateFunction()" class="mbr-buttons__btn animated fadeInUp delay" name="edit"><i class="glyphicon glyphicon-edit" style="font-size: 30px; "></i></a>

                            <!-- View Delete Button -->
                            <a href="<?php echo LINK_BASE_PATH;?>index.php?id=<?php echo $id; ?>" onclick="return deleteFunction()" class="mbr-buttons__btn animated fadeInUp delay" name="comment" href=""><i class="glyphicon glyphicon-trash" style="font-size: 30px; "></i></a>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}
/**
 *  display particular post
 *  @param $key use as a values of array in which data stored.
 */
function displaySinglePost($row){
    ?>
    <section class="mbr-section" id="header3-78">
        <div class="mbr-section__container container mbr-section__container--first">
            <div class="mbr-header mbr-header--wysiwyg row">
                <div class="col-sm-8 col-sm-offset-2">
                    <h3 class="mbr-header__text"><?php echo $row['post_title'];?></h3>
                    <p class="mbr-header__subtext">By <?php echo $row['post_author'];?> posted <?php echo $row['posted_at'];?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="mbr-section" id="image2-83">
        <div class="mbr-section__container container mbr-section__container--middle">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <figure class="mbr-figure mbr-figure--wysiwyg mbr-figure--full-width mbr-figure--caption-inside-bottom">
                        <div>
                            <img class="mbr-figure__img" height="300px" width="500px" src= '<?php echo PUBLIC_PATH.'upload-img/'.$row['post_img'];?>'>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </section>
    <section class="mbr-section" id="content1-79">
        <div class="mbr-section__container container mbr-section__container--middle">
            <div class="row">
                <div class="mbr-article mbr-article--wysiwyg col-sm-8 col-sm-offset-2"><p><blockquote><em class="description"><?php echo $row['post_description'];?></em></blockquote>
                </div>
            </div>
        </div>
    </section>
    <?php
}
/**
 *  display comments
 *  @param $key use as a values of array in which data stored.
 */
function displayComments($row){
    ?>
    <div class="mbr-section__container container mbr-section__container--middle">
        <div class="row">
            <div class="mbr-article mbr-article--wysiwyg col-sm-8 col-sm-offset-2">
                <?php
                foreach ($row as $key) {
                    $post_id = $key['post_id'];
                    if ($post_id == $_GET['id']) {
                        echo '<a href="#"><h3>'.$key['user_name'].'</h3></a>';
                        echo $key['post_comment'].'&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp&nbsp;Commented on &nbsp;&nbsp;&nbsp'.
                        $key['commented_at'].'<hr>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}
/**
 *  display Post according to category
 *  @param $key use as a values of array in which data stored.
 */
function displayCategoryPosts($key)
{
    $id = $key['id'];
    ?>
    <section class="mbr-section" id="header3-78">
        <div class="mbr-section__container container mbr-section__container--first">
            <div class="mbr-header mbr-header--wysiwyg row">
                <div class="col-sm-8 col-sm-offset-2">
                    <h3 class="mbr-header__text"><?php echo $key['post_title'];?></h3>
                    <p class="mbr-header__subtext">By <?php echo $key['post_author'];?> posted <?php echo $key['posted_at'];?></p>
                </div>
            </div>
        </div>
    </section>
    <section class="mbr-section" id="image2-83">
        <div class="mbr-section__container container mbr-section__container--middle">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <figure class="mbr-figure mbr-figure--wysiwyg mbr-figure--full-width mbr-figure--caption-inside-bottom">
                        <div>
                            <img class="mbr-figure__img" height="300px" width="500px" src= '<?php echo PUBLIC_PATH.'upload-img/'.$key['post_img'];?>'>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </section>
    <section class="mbr-section" id="content1-79">
        <div class="mbr-section__container container mbr-section__container--middle">
            <div class="row">
                <div class="mbr-article mbr-article--wysiwyg col-sm-8 col-sm-offset-2"><p><blockquote><em class="blog-description"><?php echo $key['post_description'];?></em></blockquote><a href="<?php echo SRC_PATH; ?>template/single-post.php?id=<?php echo $id; ?>" class="mbr-buttons__btn btn animated fadeInUp delay btn-primary" name="read-more" >Read More</a>
                </div>
            </div>
        </div>
    </section>
    <?php
}
/**
 *  display latest Post
 *  @param $key use as a values of array in which data stored.
 */
function latest_post($row)
{
    foreach ($row as $key) {
        ?>
        <ul class="mbr-contacts__list">
            <li>
                <h4><a class="footer-sub-heading" href="<?php echo SRC_PATH; ?>template/single-post.php?id=<?php echo $key['id']; ?>"><?php echo $key['post_title'];?></a><br> Posted By : <?php echo $key['post_author'];?>
                </h4>
            </li>
        </ul>
        <?php
    }
}
/**
 *  display category in dropdown
 *  @param $key use as a values of array in which data stored.
 */
function drop_down($row)
{
    $id = $key['id'];
    foreach ($row as $key) {
        ?>
        <option value="<?php echo $key['id']; ?>"><?php echo $key['category']; ?></option>
        <?php
    }
}
/**
 *  display category list in footer
 *  @param $key use as a values of array in which data stored.
 */
function category($row)
{
    foreach ($row as $key) {
        ?>
        <ul class="mbr-contacts__list">
            <li><h4><a class="footer-sub-heading" href="<?php echo LINK_BASE_PATH;?>index.php?category_id=<?php echo $key['id'];?>"><?php echo $key['category'];?></a></h4></li>
        </ul>
        <?php
    }
}