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
			$password = hash("sha256", $_POST['password']);
			$islogin = false;
			try{
				$stmt =$this->connection->prepare('SELECT *	FROM user 
					WHERE user_email = :email AND user_password = :pswd');
				$stmt->bindParam(':email', $email, \PDO::PARAM_STR, 15);
				$stmt->bindParam(':pswd', $password, \PDO::PARAM_INT);
				$stmt->execute();
				$result = $stmt->fetch(\PDO::FETCH_ASSOC);
				if ($stmt->rowCount()>0) {
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
				}
				if(!$islogin){
					echo "<script>alert('Please enter valid email or password!!!'); </script>";
					return;
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