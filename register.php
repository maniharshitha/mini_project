<?php 
session_start();
$errors=array();
try{
    $pdo=new PDO("mysql:host=localhost;dbname=id13583630_contactlist","id13583630_dbuser","Aishu@123456");
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "connection failed:" .$e->getMessage();
    die();
}
if(isset($_POST['username'])&&isset($_POST['email'])&&isset($_POST['password_1'])&&isset($_POST['password_2'])){
    if(strlen($_POST['username'])<1||strlen($_POST['email'])<1||strlen($_POST['password_1'])<1||strlen($_POST['password_2'])<1){
        array_push($errors,"all fields are required");
        header("Location:index.php");
        return ;
    }
    $username=htmlentities($_POST['username']);
    $email=htmlentities($_POST['email']);
    $password_1=htmlentities($_POST['password_1']);
    $password_2=htmlentities($_POST['password_2']);
    if($password_1!=$password_2) {array_push($errors,"paswords do not match");}
    if(count($errors)==0){
    $stmt=$pdo->prepare("INSERT INTO users(username,email,password) VALUES(:username,:email,:password_1)");
    $stmt->execute([
        ':username'=>$username,
        ':email'=>$email,
        ':password_1'=>$password_1
        ]);
    $_SESSION['na']=$username;
        $_SESSION['success']="logged in";
        header('Location:index.php');
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title> registration </title>
<link rel="stylesheet" type="text/css" href="style.css">
     <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
</head>
<body>
<div class="header">
<h2>register</h2>
</div>
<form method="post" action="register.php"> 
    <?php include('errors.php');?>
    <div class="input-group">
     <label>Username</label>
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
     <input type="text" name="username" >
</div>
<div class="input-group">
     <label>Email add</label>
    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
     <input type="text" name="email">
</div>
<div class="input-group">
     <label>Password</label>
     <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
     <input type="password" name="password_1">
</div>
<div class="input-group">
     <label>password</label>
     <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
     <input type="password" name="password_2">
</div>
<div class="input-group">
     <button type="submit" name="register" class="btn">Register</button>
</div>
<p> Already a member?<a href="login.php"> Sign in</a>
</p>

</form>

</body>
</html>