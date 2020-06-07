<?php

session_start();

if ( ! isset($_SESSION['na']) ) {
	die("ACCESS DENIED");
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

if (isset($_REQUEST['autos_id']))
{
    $auto_id = htmlentities($_REQUEST['autos_id']);

    if (isset($_POST['delete'])) 
    {
        $stmt = $pdo->prepare("
            DELETE FROM autos
            WHERE autos_id = :auto_id
        ");

        $stmt->execute([
            ':auto_id' => $auto_id, 
        ]);

        $_SESSION['status'] = 'Record deleted';
        $_SESSION['color'] = 'green';

        header('Location: index.php');
        return;
    }

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

            <p>
                Confirm: Deleting <?php echo $auto->name; ?>
            </p>

            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <input class="btn btn-danger" type="submit" name="delete" value="Delete">
                        <a class="btn btn-default" href="index.php">Cancel</a>
                    </div>
                </div>
            </form>

        </div>
    </body>
</html>