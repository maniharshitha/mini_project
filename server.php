<?php

    session_start();
    $username = "";
	$email = "";
	$errors = array();
		// connect to the database
	$db = mysqli_connect('localhost', 'id13583630_dbuser', 'Aishu@123456', 'id13583630_contactlist');

	// if register button is clicked

	if(isset($_POST['register'])){
	     if(isset($_POST['username'])&&isset($_POST['email'])&&isset($_POST['password_1'])&&isset($_POST['password_2'])){
		$username = mysqli_real_escape_string($db,$_POST['username']);
		$email = mysqli_real_escape_string($db,$_POST['email']);
		$password_1 = mysqli_real_escape_string($db,$_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db,$_POST['password_2']);

		//ensure that the form field are filled properly

		if (empty($username)) {
			array_push($errors, "Username is required"); 
		}
		if (empty($email)) {
			array_push($errors, "Email is required"); 
		}
		if (empty($password_1)) {
			array_push($errors, "Password is required"); 
		}
		if ($password_1 != $password_2) {
			array_push($errors, "Two password do not match"); 
		}

		// if there are no errors, save user to the database
		if (count($errors) == 0) {
			$password = $password_1; //encrypt password before storing in database (security)
			$sql = "INSERT INTO users (username, email, password) 
						VALUES ('$username','$email', '$password')";
            mysqli_query($db,$sql);
            $_SESSION['na']=$username;
            $_SESSION['success']="you are now logged in";
            header('location:index.php');
        }
	     }
    }


    if(isset($_POST['login'])){
        $username = mysqli_real_escape_string($db,$_POST['username']);
		$password = mysqli_real_escape_string($db,$_POST['password']);

		//ensure that the form field are filled properly

		if (empty($username)) {
			array_push($errors, "Username is required"); 
		}
		if (empty($password)) {
			array_push($errors, "password is required"); 
        }
        

        if(count($errors)==0){
            $password=$password;
            $query="SELECT * FROM users WHERE username='$username' AND password='$password'";
            $result=mysqli_query($db,$query);
            $row=mysqli_num_rows($result);
            if($row>=1){
                $_SESSION['na']=$username;
                $_SESSION['success']="you are now logged in";
                header('location:index.php');
            }
            else
            {
                
                array_push($errors,"user not available");
               // header('location: login.php');
            }
        }
    }
    
   /* if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['username']);
        header('location: login.php');
    }*/
?>