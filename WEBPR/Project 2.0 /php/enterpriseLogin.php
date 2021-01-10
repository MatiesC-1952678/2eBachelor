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


    checkMinMax(strlen($name), 5, 30, "The name is not between 5 and 30 characters. Go back and retry.");
    checkMinMax(strlen($email), 1, 50, "The email is over 50 characters. Go back and retry.");
    checkMinMax(strlen($description), 0, 200, "The description is longer than 200 characters. Go back and retry.");
    checkMinMax(strlen($password), 5, 50, "The password is not between 5 and 50 characters. Go back and retry.");
    checkMinMax(strlen($phone), 0, 50, "The phone number is longer than 200 characters. Go back and retry.");
    checkEmail($email);
    if (strlen($phone) > 0)
      checkPhone($phone);

    $sth = $conn->prepare("SELECT * FROM enterprises WHERE enterprises.name = :name AND enterprises.email = :email");
    $sth->bindParam( ':name', $name, PDO::PARAM_STR, strlen($name) );
    $sth->bindParam( ':email', $email, PDO::PARAM_STR, strlen($email) );
    if (!$sth->execute())
      throw new PDOException('An error occurred');

    if ($sth->rowCount() > 0) {
      $row = $sth->fetch( PDO::FETCH_ASSOC );
      if ($email != $row["email"]) {
        header("location: ../error.php?error=".urlencode('<p>The email you entered is incorrect to log in to this account. Go back and retry.</p>'));
        die();
      }
      if (!password_verify($password, $row["password"])) {
        //FAILING TO LOG IN INTO EXISTING ACCOUNT
        header("location: ../error.php?error=".urlencode('<p>The password you entered is incorrect to log in to this account. Go back and retry.</p>'));
        die();
      } else {
        //LOGGING IN TO AN ACCOUNT
        //echo "<p>logged in</p>";
        $_SESSION["typeLogged"] = "enterprise";
        $_SESSION["name"] = $name;
      }
    } else {
        //INSERTING ENTERPRISE
        //echo "<p>$name, $description, $email, $phone</p>";

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql =  "INSERT INTO enterprises
        (name, description, email, phone, password)
        VALUES
        (:name, :description, :email, :phone, :password)" ;
        $sth = $conn->prepare($sql);
        $sth->bindParam( ':name', $name, PDO::PARAM_STR, strlen($name));
        $sth->bindParam( ':description', $description, PDO::PARAM_STR, strlen($description));
        $sth->bindParam( ':email', $email, PDO::PARAM_STR, strlen($email));
        $sth->bindParam( ':phone', $phone, PDO::PARAM_STR, strlen($phone));
        $sth->bindParam( ':password', $hash, PDO::PARAM_STR, strlen($hash));
        if (!$sth->execute())
          throw new PDOException('An error occurred');

        /*
        $sth = $conn->prepare( "SELECT * FROM enterprises;");
        if (!$sth->execute())
          throw new PDOException('An error occurred');
        while ($row = $sth->fetch( PDO::FETCH_NUM ) ) {
          echo "<p>id: " . $row[0] . " name: " . $row[1] . " description: " . $row[2] . " email: " . $row[3] . " phone: " . $row[4] . "</p>";
        }
        */

        $_SESSION["typeLogged"] = "enterprise";
        $_SESSION["name"] = $name;
    }
    $url = "../home.php";
    header("location: $url ");

  } catch (PDOException $e) {
    header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
    die();
  } catch (Exception $e) {
    header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
    die();
  }
 ?>
