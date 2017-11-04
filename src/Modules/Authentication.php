<?php namespace App\Modules;
use \Config\Connection;




class Authentication
{
	protected $connection;
	public function __construct()
	{
		$connectionObject = new Connection;
		$this->connection = $connectionObject->createDataBase();
	}
	/**
	 * 	User Login
	 */
	function login(){
		if(isset($_POST['login'])){
			$email = $_POST['email'];
			$password = $_POST['password'];
			$islogin = false;
			try {
				$select = $this->connection->prepare("SELECT * FROM user 
					WHERE user_email = '$email' AND user_password = '$password'"); 
				$select->execute();
				$result = $select->fetch(\PDO::FETCH_ASSOC);
				if ($select -> rowCount()>0) {
					$islogin = true;
					session_start();
					$_SESSION['user'] = $result;
					$user_role = $_SESSION['user']['user_role'];
					if($user_role == 'admin'){
						header('location:'.SRC_PATH.'template/add-edit_post.php');
					}
					else{
						header('location:'.LINK_BASE_PATH);
					}
					if(!$islogin){
						echo "<script>alert('Please enter valid email or password!!!'); </script>";
						return;
					}
				}
			}
			catch(\PDOException $e) {
				echo "Error: " . $e->getMessage();
			}
		}
	}
	/**
	 *  User logout
	 */
	function logout()
	{
		session_start();
		session_unset();
	}
}