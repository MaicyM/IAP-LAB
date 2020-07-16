<?php
include_once "Crud.php";
include_once "authenticate.php";
require_once "DBConnector.php";

class User implements Crud,Authenticator{
	private $user_id;
	private $first_name;
	private $last_name;
	private $city;
	private $username;
	private $password;
	private $tmzn_off;
	private $utc_timestamp;

	function __construct($first_name,$last_name,$city,$username,$password){
		$this->first_name=$first_name;
		$this->last_name=$last_name;
		$this->city=$city;
		$this->username=$username;
		$this->password=$password;
	}

	public static function create(){
		$instance = new ReflectionClass(__CLASS__);
		return $instance->newInstanceWithoutConstructor();
	}
	public function setUsername($username){
		$this->username=$username;
	}
	public function getUsername(){
		return $this->username;
	}
	

	public function setPassword($password){
		$this->password=$password;
	}
	public function getPassword(){
		return $this->password;
	}
	public function hashPassword(){
		$this->password=password_hash($this->password, PASSWORD_DEFAULT);
	}
	public function isPasswordCorrect(){
		$con=new DBConnect();
		$found=false;
		$sql="SELECT * FROM users";
		$res=mysqli_query($con->conn, $sql);

		while($row=mysqli_fetch_array($res)){
			if(password_verify($this->getPassword(), $row['password']) && $this->getUsername()==$row['username']){
				$found=true;
			}

		}
		$con->closeDatabase();
		return $found;
	}
	public function login(){
		if($this->isPasswordCorrect())
		{
			header("Location: private_page.php");
		}
	}

	public function createUserSession(){
		session_start();
		$_SESSION['username']=$this->getUsername();
	}

	public function logout(){
		session_start();
		unset($_SESSION['username']);
		session_destroy();
		header("Location: lab1.php");
	}

	public function setId($user_id){
		$this->user_id=$user_id;
	}
	public function getId(){
		return $this->$user_id;
	}

	public function setTimezoneOffset($tmzOffset){
		$this->tmzn_off = $tmzOffset;
	}
	public function getTimezoneOffset(){
		return $this->tmzn_off;
	}

	public function setUtcTimestamp($utc_timestamp){
		$this->utc_timestamp = $utc_timestamp;
	}
	public function getUtcTimestamp(){
		return $this->utc_timestamp;
	}

	public function save(){
		$con= new DBConnect();
		$fn=$this->first_name;
		$ln=$this->last_name;
		$ct=$this->city;
		$uname=$this->username;
		$this->hashPassword();
		$pass=$this->password;
		$tmzOffset=$this->getTimezoneOffset();
		$utc_timestamp = $this->getUtcTimestamp();
		$sql="INSERT INTO users(first_name,last_name,user_city,username,password, created_time, offset) VALUES ('$fn','$ln','$ct','$uname','$pass', '$utc_timestamp', '$tmzOffset')";
		$res=mysqli_query($con->conn,$sql);
		return $res;
	}
	public function validateForm(){
		$fn=$this->first_name;
		$ln=$this->last_name;
		$ct=$this->city;

		if($fn==""||$ln==""||$ct==""){
			return false;
		}
		return true;
	}
	public function createFormErrorSessions(){
		session_start();
		$_SESSION['form_error']="All fields required";
	}
	public function readUnique(){
		return null;
	}
	public function readAll(){
		return null;
	}
	public function search(){
		return null;
	}
	public function update(){
		return null;
	}
	public function removeOne(){
		return null;
	}
	public function removeAll(){
		return null;
	}
}
?>