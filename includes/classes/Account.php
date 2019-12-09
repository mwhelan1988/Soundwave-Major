<?php
	class Account {
		private $conn;
		private $errorArray;

		public function __construct($conn) {
			$this->conn = $conn;
			$this->errorArray = array();
		}

		public function login($em, $pw) {

			$pw = md5($pw);

			$query = mysqli_query($this->conn, "SELECT * FROM users WHERE email='$em' AND password='$pw'");

			if(mysqli_num_rows($query) == 1) {
				return true;
				
			} else {
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}

		}

		public function register($fn, $ln, $em, $em2, $pw, $pw2) {
			$this->validateFirstName($fn);
			$this->validateLastName($ln);
			$this->validateEmails($em, $em2);
			$this->validatePasswords($pw, $pw2);

			if(empty($this->errorArray) == true) {
				//Insert into database
				return $this->insertUserDetails($fn, $ln, $em, $pw);
			}
			else {
				return false;
			}

		}

		public function getError($error) {
			if(!in_array($error, $this->errorArray)) {
				$error = "";
			}
			return "<span class='errorMessage'>$error</span>";
		}

		private function insertUserDetails($fn, $ln, $em, $pw) {
			$encryptedPw = md5($pw); 
			$profilePic = "images/profile-pics/profilepic-template.jpg";
			$date = date ("Y-m-d");

			$result = mysqli_query($this->conn, "INSERT INTO users 
												 VALUES
												 	(NULL,
													 '$fn',
													 '$ln',
													 '$em',
													 '$encryptedPw',
													 '$date',
													 '$profilePic',
													 2
													 )");
																	
			return $result;

		}

		private function validateFirstName($fn) {
			if(strlen($fn) > 25 || strlen($fn) < 2) {
				array_push($this->errorArray, Constants::$firstNameCharacters);
				return;
			}
		}

		private function validateLastName($ln) {
			if(strlen($ln) > 25 || strlen($ln) < 2) {
				array_push($this->errorArray, Constants::$lastNameCharacters);
				return;
			}
		}

		private function validateEmails($em, $em2) {
			if($em != $em2) {
				array_push($this->errorArray, Constants::$emailsDoNotMatch);
				return;
			}

			if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
				array_push($this->errorArray, Constants::$emailInvalid);
				return;
			}

			$checkEmailQuery = mysqli_query($this->conn, "SELECT email FROM users WHERE email='$em'");
			if(mysqli_num_rows($checkEmailQuery) !=0) {
				array_push($this->errorArray, constants::$emailTaken);
			}

		}

		private function validatePasswords($pw, $pw2) {

			if($pw != $pw2) {
				array_push($this->errorArray, "Your passwords don't match");
				return;
			}
			
			if(preg_match('/[^A-Za-z0-9]/', $pw)) {
				array_push($this->errorArray, Constants::$passwordRules);
				return;
			}

			if(strlen($pw) > 30 || strlen($pw) < 3) {
				array_push($this->errorArray, Constants::$passwordCharacters);
				return;
			}

		}


	}
?>