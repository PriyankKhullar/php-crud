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
			$password = hash("sha256", $_POST['password']);
			$user_role = "user";
			$table = 'user';
			$dbfield = array("user_name"=>$name, "user_email"=>$email,"user_password"=>$password, "user_role"=>$user_role);
			$sql = $this->connection->prepare("SELECT COUNT(id) FROM user WHERE user_email= :email ");
			$sql->bindParam(':email',$email);
			$sql->execute();
			$rows = $sql->fetchColumn();

			// if user get email already existed
			if ($rows == 1) {
				echo "<script>alert('This email is already exist.Please use another email.')</script>";
			}

			// user enter another email
			else{				
				$this->commands->insert($table, $dbfield);
				echo "<script>alert('Account Created Successfully.'); 
				location.assign('login-form.php'); </script>";
			}
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
				$description = $_POST['description'];
				$image_name = $_FILES['image']['name'];
				$image_tmp = $_FILES['image']['tmp_name'];
				$dest= "$image_name";
				$category_id = $_POST['category'];
				move_uploaded_file($image_tmp, PUBLIC_BASE_PATH."upload-img/$image_name");

				// if user want to update img 
				if($image_name){
					$update = "UPDATE post SET post_title = :post_title, post_author = :post_author, post_description = :post_description, post_img = :post_img, category_id = :category_id WHERE id=".$id;
					$query = $this->connection->prepare($update);
					$query->bindParam(':post_img', $dest, \PDO::PARAM_STR, 15);
					$query->bindParam(':post_title', $title, \PDO::PARAM_STR, 15);
					$query->bindParam(':post_author', $author, \PDO::PARAM_STR, 15);
					$query->bindParam(':post_description', $description, \PDO::PARAM_STR, 15);
					$query->bindParam(':category_id', $category_id, \PDO::PARAM_STR, 15);
				}

				// user don't change image
				else{
					$update = "UPDATE post SET post_title = :post_title, post_author = :post_author, post_description = :post_description, category_id = :category_id WHERE id=".$id;
					$query = $this->connection->prepare($update);
					$query->bindParam(':post_title', $title, \PDO::PARAM_STR, 15);
					$query->bindParam(':post_author', $author, \PDO::PARAM_STR, 15);
					$query->bindParam(':post_description', $description, \PDO::PARAM_STR, 15);
					$query->bindParam(':category_id', $category_id, \PDO::PARAM_STR, 15);
				}

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
				$image_name = $_FILES['image']['name'];
				$image_tmp = $_FILES['image']['tmp_name'];
				$dest= "$image_name";
				$user_id = $_SESSION['user']['id'];
				$category_id = $_POST['category'];
				move_uploaded_file($image_tmp, PUBLIC_BASE_PATH."upload-img/$image_name");
				$table = 'post';
				$dbfield = array("post_title"=>$title, "post_description"=>$description, "post_img"=>$dest, "post_author"=>$author, "user_id"=>$user_id, "category_id"=>$category_id);
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
	function dropDown()
	{
		try{
			$parent_id = '1';
			$select = $this->connection->prepare("SELECT * FROM post_category WHERE parent_id = :parent_id  ORDER BY display_order");
			$select->bindParam(':parent_id', $parent_id);
			$select->execute();
			$result = $select->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $select->fetchall();
			dropDown($row);
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
			// display according to category
			if(isset($_GET['category_id'])){
				$category_id = $_GET['category_id'];
				$select = $this->connection->prepare("SELECT * FROM post WHERE category_id = :category_id");
				$select->bindParam(':category_id', $category_id);
				$select->execute();
				$result = $select->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $select->fetchall();
				foreach ($row as $key) {
					showPostByCategoy($key);
				}
			}

			// display search post
			elseif(isset($_GET['search-btn'])){
				$isSearch = false;
				$search = $_GET['search-post']; 
				$search = $this->connection->prepare("SELECT post.*, count(DISTINCT post_likes.id) as total_likes ,count(DISTINCT post_comments.id) as total_comments FROM post LEFT JOIN post_comments ON post.id =post_comments.post_id LEFT JOIN post_likes ON post.id = post_likes.post_id WHERE post.post_title Like '%".$search."%' GROUP BY post.id");
				$search->execute();
				$search->setFetchMode(\PDO::FETCH_ASSOC);
				while ($key = $search->fetch()) 
				{
					if ($search->rowCount() > 0) 
					{
						$isSearch = true;
						showAllPosts($key);
					}
				}
				if (!$isSearch) {
					echo "<script type='text/javascript'> alert('Record Not Found!!!'); </script>";
					return;
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
					showAllPosts($key);
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
				$post_id = $_GET['post_id'];
				$user_id = $_GET['user_id'];
				$sql = "SELECT * from post_likes WHERE user_id= :user_id AND post_id = :post_id";
				$query_execute = $this->connection->prepare($sql);
				$query_execute->bindParam(':user_id', $user_id);
				$query_execute->bindParam(':post_id', $post_id);
				$query_execute->execute();
				
				// if user like
				if($query_execute->fetchColumn() > 0) {
					$sql = "DELETE FROM post_likes WHERE user_id = :user_id AND post_id = :post_id";

				}
				// id user unlike
				else{
					$sql = "INSERT INTO post_likes (user_id, post_id) VALUES (:user_id, :post_id)";
				}
				$like_execute = $this->connection->prepare($sql);
				$like_execute->bindParam(':user_id', $user_id);
				$like_execute->bindParam(':post_id', $post_id);
				$like_execute->execute();
				header('location:'.$_SERVER['HTTP_REFERER']);
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
		// if user do any comment
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
		try{
			if (isset($_GET['id'])){
				$select = $this->connection->prepare("SELECT post.*, count(DISTINCT post_likes.id) as total_likes ,count(DISTINCT post_comments.id) as total_comments FROM post LEFT JOIN post_comments ON post.id =post_comments.post_id LEFT JOIN post_likes ON post.id = post_likes.post_id WHERE post.id =".$_GET['id']);
				$select->execute();
				$select->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $select->fetch();
				showSinglePosts($row);
			}
		}
		catch(\PDOException $e) {
			echo "Error: " . $e->getMessage();
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
			showComment($row);
		}
		catch(\PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}
	/**
	 *  Display Latest Posts
	 */
	function latestPost()
	{
		try{
			$select_Data = $this->connection->prepare("SELECT * FROM post ORDER BY id DESC limit 3");
			$select_Data->execute();
			$result = $select_Data->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $select_Data->fetchAll();
			latestPost($row);
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
			$parent_id = '1';
			$select = $this->connection->prepare("SELECT * FROM post_category WHERE parent_id = :parent_id "); 
			$select->bindParam(':parent_id',$parent_id);
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