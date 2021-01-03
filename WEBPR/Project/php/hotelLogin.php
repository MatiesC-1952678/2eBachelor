<?php
  require 'globals.php';
  try {
    echo "<p>connecting to server</p>";
    $conn = new PDO( "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    /*
    $sql = "CREATE TABLE Hotels (
      hotelID INT,
      name VARCHAR(30),
      description VARCHAR(200),
      email VARCHAR(50),
      phone INT,
      CONSTRAINT hotelPrimaryKey PRIMARY KEY (hotelID)
    );" ;
    $conn->exec($sql);
    echo "<p>succesfully made table</p>";
    */

    //"ADD FILE" LATER
    //$profilePic = $_POST["hotelProfilePic"];
    $name = $_POST["hotelName"];
    $description = $_POST["hotelDescription"];
    $email = $_POST["hotelEmail"];
    $phone = $_POST["hotelPhone"];

    $id = rand(); //Temporary measure -> check database if id is already in use otherwise generate new id

    //echo "<p>$profilePic<p>";
    echo "<p>$name, $description, $email, $phone</p>";

    $sql =  "INSERT INTO Hotels
    (hotelID, name, description, email, phone)
    VALUES
    (:id, :name, :description, :email, :phone);" ;
    $sth = $conn->prepare($sql);
    $sth->bindParam( ':id', $id, PDO::PARAM_INT);
    $sth->bindParam( ':name', $name, PDO::PARAM_STR, 30 );
    $sth->bindParam( ':description', $description, PDO::PARAM_STR, 200 );
    $sth->bindParam( ':email', $email, PDO::PARAM_STR, 50);
    $sth->bindParam( ':phone', $phone, PDO::PARAM_INT);
    $sth->execute();
    echo "<p>succesfully inserted hotel</p>";
    $sth = $conn->prepare( "SELECT * FROM Hotels;");
    $sth->execute();
    while ($row = $sth->fetch( PDO::FETCH_NUM ) ) {
      echo "<p>id: " . $row[0] . " name: " . $row[1] . " description: " . $row[2] . " email: " . $row[3] . " phone: " . $row[4] . "</p>";
    }

    setcookie("typeLogged", "hotel", time( ) + 3600);

    echo '<a href="http://localhost:8080/Project/home.html"> Click here to go back </a>';
    //instantly go to page
    //https://stackoverflow.com/questions/353803/redirect-to-specified-url-on-php-script-completion

  } catch (PDOException $e) {
    print "Error!" . $e->getMessage() . "\n";
    die();
  }
 ?>
