<?php

session_start();

if ( ! isset($_SESSION['na']) ) {
	die("ACCESS DENIED");
}

// If the user requested logout go back to index.php
if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    return;
}

$status = false;

if ( isset($_SESSION['status']) ) {
	$status = htmlentities($_SESSION['status']);
	$status_color = htmlentities($_SESSION['color']);

	unset($_SESSION['status']);
	unset($_SESSION['color']);
}

try 
{
    $pdo = new PDO("mysql:host=localhost;dbname=id13583630_contactlist", "id13583630_dbuser", "Aishu@123456");
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
    die();
}

$name = htmlentities($_SESSION['na']);

$_SESSION['color'] = 'red';
if(isset($_REQUEST['autos_id']))
{
	if (isset($_POST['name']) && isset($_POST['contact'])) 
	{
	    if (strlen($_POST['name']) < 1 || strlen($_POST['contact']) < 1)
	    {
	        $_SESSION['status'] = "All fields are required";
	        header("Location: edit.php?autos_id=" . htmlentities($_REQUEST['autos_id']));
	        return;
	    }

	    $name = htmlentities($_POST['name']);
	    $contact = htmlentities($_POST['contact']);
    	$auto_id = htmlentities($_REQUEST['autos_id']);
	    $stmt = $pdo->prepare("
	    	UPDATE autos
	    	SET name = :name, contact = :contact
		    WHERE autos_id = :auto_id
	    ");

	    $stmt->execute([
	        ':name' => $name, 
	        ':contact' => $contact, 
	        ':auto_id' => $auto_id,
	    ]);

	    $_SESSION['status'] = 'Record edited';
	    $_SESSION['color'] = 'green';

	    header('Location: index.php');
		return;
	}


	$auto_id = htmlentities($_REQUEST['autos_id']);

	$stmt = $pdo->prepare("
	    SELECT * FROM autos
	    WHERE autos_id = :auto_id
	");

	$stmt->execute([
	    ':auto_id' => $auto_id, 
	]);

	$auto = $stmt->fetch(PDO::FETCH_OBJ);
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Gumastha Aishwarya</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <h1>Editing Contact</h1>
            <?php
                if ( $status !== false ) 
                {
                    // Look closely at the use of single and double quotes
                    echo(
                        '<p style="color: ' .$status_color. ';" class="col-sm-10 col-sm-offset-2">'.
                            htmlentities($status).
                        "</p>\n"
                    );
                }
            ?>
            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="name">Name:</label>
                    <div class="col-sm-3 input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input class="form-control" type="text" name="name" id="name" value="<?php echo htmlentities($auto->name); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="contact">Contact:</label>
                    <div class="col-sm-3 input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                        <input class="form-control" type="text" name="contact" id="contact" value="<?php echo htmlentities($auto->contact); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="file">PROFILE</label>
                    <div class="col-sm-3">
                    <input type="file" name="image"  class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <input class="btn btn-primary" type="submit" value="Save">
                        <input class="btn" type="submit" name="cancel" value="Cancel">
                    </div>
                </div>
            </form>

        </div>
    </body>
</html>