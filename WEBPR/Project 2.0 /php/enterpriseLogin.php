<?php
  session_start();
  //logging in with enterprise
  require 'globals.php';
  require 'inputChecks.php';
  try {
    echo "<p>connecting to server</p>";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $name = $_POST["enterpriseName"];
    $description = $_POST["enterpriseDescription"];
    $email = $_POST["enterpriseEmail"];
    $phone = $_POST["enterprisePhone"];
    $password = $_POST["enterprisePassword"];


    checkMinMax(strlen($name), 5, 30, "Name is not between 5 and 30 characters.");
    checkMinMax(strlen($email), 1, 50, "Email is over 50 characters.");
    checkMinMax(strlen($description), 0, 200, "Description is longer than 200 characters.");
    checkMinMax(strlen($password), 5, 50, "Password is not between 5 and 50 characters.");
    checkMinMax(strlen($phone), 0, 50, "Phone number is longer than 200 characters.");
    checkEmail($email);
    if (strlen($phone) > 0)
      checkPhone($phone);

    $sth = $conn->prepare("SELECT * FROM enterprises WHERE enterprises.name = :name AND enterprises.email = :email");
    $sth->bindParam( ':name', $name, PDO::PARAM_STR, strlen($name) );
    $sth->bindParam( ':email', $email, PDO::PARAM_STR, strlen($email) );
    $sth->execute();

    if ($sth->rowCount() > 0) {
      $row = $sth->fetch( PDO::FETCH_ASSOC );
      if ($password != $row["password"] ) {
        //FAILING TO LOG IN INTO EXISTING ACCOUNT
        echo "<p>password incorrect</p>";
      } else {
        //LOGGING IN TO AN ACCOUNT
        echo "<p>logged in</p>";
        $_SESSION["typeLogged"] = "enterprise";
        $_SESSION["name"] = $name;
      }
    } else {
        //CREATING AN ACCOUNT
        echo "<p>$name, $description, $email, $phone</p>";
        $sql =  "INSERT INTO enterprises
        (name, description, email, phone, password)
        VALUES
        (:name, :description, :email, :phone, :password)" ;
        $sth = $conn->prepare($sql);
        $sth->bindParam( ':name', $name, PDO::PARAM_STR, strlen($name));
        $sth->bindParam( ':description', $description, PDO::PARAM_STR, strlen($description));
        $sth->bindParam( ':email', $email, PDO::PARAM_STR, strlen($email));
        $sth->bindParam( ':phone', $phone, PDO::PARAM_STR, strlen($phone));
        $sth->bindParam( ':password', $password, PDO::PARAM_STR, strlen($password));
        $sth->execute();
        echo "<p>succesfully inserted enterprise</p>";
        $sth = $conn->prepare( "SELECT * FROM enterprises;");
        $sth->execute();
        while ($row = $sth->fetch( PDO::FETCH_NUM ) ) {
          echo "<p>id: " . $row[0] . " name: " . $row[1] . " description: " . $row[2] . " email: " . $row[3] . " phone: " . $row[4] . "</p>";
        }

        $_SESSION["typeLogged"] = "enterprise";
        $_SESSION["name"] = $name;
    }
    $url = "../home.php";
    header("location: $url ");

  } catch (PDOException $e) {
    print "Error!" . $e->getMessage() . "\n";
    echo '<p><a href="../login.php"> go back </a></p>';
    die();
  } catch (Exception $e) {
    print "Error!" . $e->getMessage() . "\n";
    echo '<p><a href="../login.php"> go back </a></p>';
    die();
  }
 ?>
