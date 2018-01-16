<?php

session_start();

if(!$_SESSION['email'])
{
    header("Location: login.php");//redirect to login page to secure the welcome page without login access.
}

$host    = "localhost";
$user    = "root";
$pass    = "root";
$db_name = "CSV_DB";

//create connection
$connection = mysqli_connect($host, $user, $pass, $db_name);

//test if connection failed
if(mysqli_connect_errno()){
    die("connection failed: "
        . mysqli_connect_error()
        . " (" . mysqli_connect_errno()
        . ")");
}

//get results from database
$result = mysqli_query($connection,"SELECT * FROM Inventaire");
$all_property = array();  //declare an array for saving property
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Simple requête</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
</head>

<body>

<div class="container">
    
    <?php
    echo $_SESSION['email'];
    ?>
    <a href="logout.php">Logout</a>
    
    <h2>Inventaire</h2>
           
    <table class="table table-striped">
        <thead>
        <tr>
            <?php
            while ($property = mysqli_fetch_field($result)) {
                echo '<th>' . $property->name . '</th>';  //get field name for header
                array_push($all_property, $property->name);  //save those to array
            }
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                foreach ($all_property as $item) {
                    echo '<td>' . $row[$item] . '</td>'; //get items using property value
                }
                echo '</tr>';
            }
        ?>

        </tbody>
    </table>
</div>

</body>
</html>

