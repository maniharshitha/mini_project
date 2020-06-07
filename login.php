<?php
session_start();
$errors=array();
try{
    $pdo =new PDO("mysql:host=localhost;dbname=id13583630_contactlist","id13583630_dbuser","Aishu@123456");
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} 
catch(PDOException $e){
    echo "connection failed" .$e->getMessage();
    die();
}
if(isset($_POST['username'])&&isset($_POST['password'])){
    if(strlen($_POST['username'])<1||strlen($_POST['password'])<1)
    {
        array_push($errors,"All fields are required");
        header("Location: index.php");
        return;
    }
    $username=htmlentities($_POST['username']);
    $password=htmlentities($_POST['password']);
    $stmt=$pdo->prepare("SELECT * FROM users WHERE username='$username' and password='$password'");
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_OBJ);
    if($stmt->rowCount()>0){
        $_SESSION['na']=$_POST['username'];
        $_SESSION['success']="logged in";
        header("Location:index.php");
    }
    else{
        array_push($errors,"usernot availabe");
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
<h2>Login</h2>
</div>
<form method="post" action="login.php">
<?php include('errors.php');?> 
    <div class="input-group">
     <label>Username</label>
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
     <input type="text" name="username">
</div>
<div class="input-group">
     <label>Password</label>
         <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
     <input type="password" name="password">
</div>
<div class="input-group">
     <button type="submit" name="login" class="btn">login</button>
</div>
<p> Don't have an account?<a href="register.php"> Sign up</a>
</p>

</form>

</body>
</html>