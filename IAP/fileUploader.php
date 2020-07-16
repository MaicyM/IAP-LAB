<?php

include_once "DBConnector.php";

    class FileUploader{
    	//Member Variables.
    	private static $target_directory = "uploads/";
    	private static $size_limit=50000;
    	private $uploadOk = false;
    	private $file_original_name;
    	private $file_type;
    	private $file_size;
    	private $final_file_name;
    	public static $xtension = array("jpeg","jpg","png");


    	//Method to access username

    	public function setUsername($username){
    		$this->username = $username;
    	}

    	public function getUsername(){
    		return $this->username;
    	}

    	//getters and setters

    	public function setOriginalName($name){
    		$this->file_original_name=$name;
    	}
    	public function getOriginalName(){
    		return $this->file_original_name;
    	}
	    public function setFileType($type){
	    	$this->file_type=$type;
	    }
	    public function getFileType(){
	    	return $this->file_type;
	    }
	    public function setFileSize($size){
	    	$this->file_size=$size;
	    }
	    public function getFileSize(){
	    	return $this->file_size;
	    }
	    public function setFinalFileName($final_name){
	    	$this->final_file_name=$final_name;
	    }
	    public function getFinalFileName(){
	    	return $this->final_file_name;
	    }

	    //methods

	    public function uploadFile(){
	    	$connect = new DBConnect;
	    	$this->moveFile();

	    	$img_name = $this->getOriginalName();
	    	$username = $_SESSION['username'];

	    	if($this->uploadOk){
	    		$result = mysqli_query($connect->conn, "UPDATE users SET image='$img_name' WHERE username='$username'") or die("Error".mysqli_error());

	    		unset($_SESSION['username']);
	    	}
	    }
	    public function fileAlreadyExists(){
	    	$this->saveFilePathTo();

	    	$exists_in_dir = false;

	    	//Check if file exists in file path.
	    	if(file_exists($this->file_path)){
	    		$exists_in_dir = true;
	    	}

	    	return $exists_in_dir;
	    }
	    public function saveFilePathTo(){
	    	//Get Parent directory holding all files
	    	$target = self::$target_directory;

	    	$target_file = $target. basename($this->file_original_name);

	    	$this->file_path = $target_file;
	    }
	    public function moveFile(){
	    	$result = move_uploaded_file($this->final_file_name, $this->file_path);

	    	if($result){
	    		$this->uploadOk = true;
	    	}

	    	return $this->uploadOk;
	    }
	    public function fileTypeIsCorrect(){
	    	$xtension = array("jpeg","jpg","png");

	    	$of_type_xtensions = false;

	    	$type = $this->file_type;

	    	if(in_array($type, $xtension)){
	    		$of_type_xtensions = true;
	    	}

	    	return $of_type_xtensions;
	    }	    
	    public function fileSizeIsCorrect(){
	    	$size_Ok = false;
	    	$limit = self::$size_limit;

	    	if($this->file_size < 5000000000){
	    		$size_Ok = $true;
	    	}

	    	return $size_Ok;
	    }
	    public function fileWasSelected(){
	    	$selected = false;

	    	if($this->file_original_name){
	    		$this->uploadOk = true;
	    		$selected = true;
	    	}

	    	return $selected;
	    }

	}

	?>