<html>
    <head>
        <title>My Shop</title>
    </head>

    <body>
        <h1>Welcome to my shop</h1>
        <ul>
            <?php

            $json = file_get_contents('http://product-service/');
            $obj = json_decode($json);
            $products = $obj->products;
            foreach ($products as $product) {
                echo "<li>$product</li>";
            }

            ?>
        </ul>


<?php

$servername = "db:3306";
$username = "muj-user";
$password = "moje-heslo";
$dbname = "moje-databaze";

// Create connection
$db = new mysqli($servername, $username, $password, $dbname);

echo "<p/>";

// Check connection
if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

//Create table if not exists
$sql = 'CREATE TABLE if not exists testlog (
    id int NOT NULL AUTO_INCREMENT,
    datum datetime,
    ip varchar(100),
    agent varchar(1000),
    PRIMARY KEY (id)
  )';

if ($db->query($sql) === TRUE) {
    echo "Table create command OK. <br>";
} else {
    echo "Error creating table: " . $db->error;
}

//Insert current user info
$sql = "insert into testlog(datum, ip, agent) values (now(), \"" . $_SERVER['REMOTE_ADDR'] . "\", \"" . $_SERVER['HTTP_USER_AGENT'] . "\")";
if ($db->query($sql) === TRUE) {
    echo "Insert record OK. <br>";
} else {
    echo "Error inserting log record: " . $db->error;
}

echo "<p/>";

//Select all current records
$sql = "SELECT * FROM testlog";
if($result = mysqli_query($db, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo "<table>";
            echo "<tr>";
                echo "<th>id</th>";
                echo "<th>datum</th>";
                echo "<th>ip</th>";
                echo "<th>agent</th>";
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['datum'] . "</td>";
                echo "<td>" . $row['ip'] . "</td>";
                echo "<td>" . $row['agent'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
    } else{
        echo "No user log records were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
}

// Close the connection
$db->close();

?>


    </body>
</html>
