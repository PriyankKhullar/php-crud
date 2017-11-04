<?php namespace App\Modules;

include SRC_BASE_PATH.'methods/function.php';

use \Config\Connection;
use \App\Modules\Commands;

class BlogQueries
{
	protected $connection;
	protected $commands;
	public function __construct()
	{
		$connectionObject = new Connection;
		$this->connection = $connectionObject->createDatabase();
		$this->commands = new Commands;
	}
	/**
	 *  insert user detail in user table
	 */
	function insertUser()
	{
		if(isset($_POST['submit'])){
			$name = $_POST['name'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$user_role = "user";
			$table = 'user';
			$dbfield = array("user_name"=>$name, "user_email"=>$email,"user_password"=>$password, "user_role"=>$user_role);
			$this->commands->insert($table, $dbfield);
			header('location:'.SRC_PATH.'template/login-form.php');
		}
	}
	/**
	 *  insert post in post table
	 */
	function insertPost()
	{
		// update the post
		if(isset($_GET['uid'])){
			$id = $_GET['uid'];
			if (isset($_POST['save_post'])) {
				$title = $_POST['title'];
				$author = $_POST['author'];
				$description = $_POST['description'];
				$imageName = $_FILES['image']['name'];
				$imageTmp = $_FILES['image']['tmp_name'];
				$dest= "$imageName";
				$category_id = $_POST['category'];
				move_uploaded_file($imageTmp, PUBLIC_BASE_PATH."upload-img/$imageName");
				$update = "UPDATE post SET post_title = '$title', post_author = '$author', post_description = '$description', post_img = '$dest', category_id = '$category_id' WHERE id=".$id;
				$query = $this->connection->prepare($update);
				$query->execute();
				header('location:'.LINK_BASE_PATH);
			}
		}
		//insert post
		else{
			if (isset($_POST['save_post'])){
				$title = $_POST['title'];
				$author = $_POST['author'];
				$description = $_POST['description'];
				$imageName = $_FILES['image']['name'];
				$imageTmp = $_FILES['image']['tmp_name'];
				$dest= "$imageName";
				$userid = $_SESSION['user']['id'];
				$category_id = $_POST['category'];
				print_r($_POST);
				move_uploaded_file($imageTmp, PUBLIC_BASE_PATH."upload-img/$imageName");
				$table = 'post';
				$dbfield = array("post_title"=>$title, "post_description"=>$description, "post_img"=>$dest, "post_author"=>$author, "user_id"=>$userid, "category_id"=>$category_id);
				$this->commands->insert($table, $dbfield);
				header('location:'.LINK_BASE_PATH);
			}
		}
	}
	/**
	 *  Select data from post table accroding to get uid
	 */
	function selectEditData()
	{
		if (isset($_GET['uid'])){
			$params = [ 'id ='.$_GET['uid'] ];
			return $row = $this->commands->select('post',['*'] , $params);
		}
	}
	/**
	 *  Display categories in dropdown
	 */
	function dropdown()
	{
		try{
			$select = $this->connection->prepare("SELECT * FROM post_category WHERE parent_id = 1 ORDER BY 	display_order"); 
			$select->execute();
			$result = $select->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $select->fetchall();
			drop_down($row);
		}
		catch(\PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}
	/**
	 *  Display All Posts
	 */
	function showPosts()
	{
		try {
			if(isset($_GET['category_id'])){
				$id = $_GET['category_id'];
				$select = $this->connection->prepare("SELECT * FROM post WHERE category_id =". $id); 
				$select->execute();
				$result = $select->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $select->fetchall();
				foreach ($row as $key) {
					displayCategoryPosts($key);
				}
			}
			elseif(isset($_GET['search-btn'])){
				$search = $this->connection->prepare("SELECT post.*, COUNT(distinct post_likes.id) as total_likes,  COUNT(distinct post_comments.id) as total_comments FROM post LEFT JOIN post_likes ON post_likes.post_id = post.id  LEFT  JOIN post_comments ON post_comments.post_id = post.id GROUP BY post.id ORDER BY id DESC"); 
				$search->execute();
				$result = $search->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $search->fetchAll();
				if (isset($_GET['search-btn'])) {
					$isSearch = false;
					$search = $_GET['search-post']; 
					foreach ($row as $key) {
						$id = $key['id'];
						if ($key['post_title'] == $search){
							$isSearch = true;
							displayAllPosts($key);
						}
					}
					if (!$isSearch){
						echo "<script type='text/javascript'> alert('Record Not Found!!!'); </script>";
						return;
					}
				}
			}
			// display all post
			else{
				$limit = 3;
				$offset = 0;
				if(isset($_GET['page'])){
					$page = $_GET['page'];
					if($page == 1 or $page == ""){
						$offset = 0;
					}
					else{
						$offset = $page * $limit -3;
					}
				}
				$select = $this->connection->prepare("SELECT post.*, COUNT(distinct post_likes.id) as total_likes,  COUNT(distinct post_comments.id) as total_comments FROM post LEFT JOIN post_likes ON post_likes.post_id = post.id  LEFT  JOIN post_comments ON post_comments.post_id = post.id GROUP BY post.id ORDER BY id DESC LIMIT $offset, $limit"); 
				$select->execute();
				$result = $select->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $select->fetchAll();
				foreach ($row as $key) {
					displayAllPosts($key);
				}
			}
		}
		catch(\PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}
	/**
	 *  insert Likes, only user can like one time any post
	 */
	function insertLike()
	{
		try{
			if((isset($_GET['post_id']) && !empty($_GET['post_id'])) && (isset($_GET['user_id']) && !empty($_GET['user_id']))){
				$post_id=$_GET['post_id'];
				$user_id = $_GET['user_id'];

				$sql =   "SELECT * from post_likes WHERE user_id='".$user_id."' AND post_id =" . $post_id;
				$query = $this->connection->query($sql);
				if($query->fetchColumn() > 0) {
					$sql = "DELETE FROM post_likes WHERE user_id='".$user_id."' AND post_id =" . $post_id;
				}else{
					$sql = "INSERT INTO post_likes (user_id, post_id)
					VALUES ('$user_id', '$post_id')";
				}
				$this->connection->exec($sql);
				header('location:'.LINK_BASE_PATH);
			}
		}
		catch(\PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}
	/**
	 *  insert Commments in post_comment table
	 */
	function insertComment()
	{
		if(isset($_POST['comment_btn'])){
			$name = $_POST['name'];
			$comment = $_POST['comment'];
			$getId = $_GET['comment_id'];
			$table = 'post_comments';
			$dbfield = array("user_name"=>$name, "post_comment"=>$comment, "post_id"=>$getId);
			if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){
				echo "<script>alert('Please enter captcha code!!!'); </script>";
			}else{
				$this->commands->insert($table, $dbfield);
				header('location:'.LINK_BASE_PATH);
			}
		}
	}
	/**
	 *  delete any post
	 */
	function deletePost()
	{
		try {
			if (isset($_GET['id'])) {
				$id = $_GET['id'];
				$table = 'post';
				$params = [ 'id ='.$_GET['id'] ];
				$this->commands->delete($table, $params);
				header('location:'.LINK_BASE_PATH);
			}
		}
		catch(\PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}
	/**
	 *  Display Single Post.
	 */
	function viewSinglePost()
	{
		if (isset($_GET['id'])){
			$params = [ 
			'id ='.$_GET['id'] 
			];
			$row = $this->commands->select('post',['*'] , $params);
			displaySinglePost($row);
		}
	}
	/**
	 *  Display Comments on single post.
	 */
	function displayComments()
	{
		try{
			$select = $this->connection->prepare("SELECT * FROM post_comments"); 
			$select->execute();
			$result = $select->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $select->fetchall();
			displayComments($row);
		}
		catch(\PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}
	/**
	 *  Display Latest Posts
	 */
	function latest_post()
	{
		try{
			$select_Data = $this->connection->prepare("SELECT * FROM post ORDER BY id DESC limit 3");
			$select_Data->execute();
			$result = $select_Data->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $select_Data->fetchAll();
			latest_post($row);
		} catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}
	/**
	 *  Display Pagination
	 */
	function pagination()
	{
		try{
			$pagination = $this->connection->prepare("SELECT * FROM post");
			$pagination ->execute();
			$count = $pagination-> rowCount();
			$res = ceil($count/3);
			for ($pageNo=1; $pageNo <=$res ; $pageNo++) { 
				echo '<a class="btn btn-primary pages" href="?page='.$pageNo.'">'.$pageNo.'</a>';
			}
		}
		catch(\PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}
	/**
	 *  Display category in footer
	 */
	function category()
	{
		try{
			$select = $this->connection->prepare("SELECT * FROM post_category WHERE parent_id = 1 "); 
			$select->execute();
			$result = $select->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $select->fetchall();
			category($row);
		}
		catch(\PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}
}