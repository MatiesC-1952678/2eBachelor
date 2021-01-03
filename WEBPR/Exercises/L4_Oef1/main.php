<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="">
    <script src="" charset="utf-8"></script>
    <title></title>
  </head>
  <body>
      <p>test wow, cool</p>
      <a href="test.php">Click here</a><br>
      <?php 
        mt_srand((double)microtime() * 1000000);
        $getal = mt_rand(0,4); 
        switch($getal) {
            case (0):
                echo 'wow (0)';
                break;
            case (1):
                echo "cool ($getal)";
                break;
            case (2):
                echo 'holy crap (2)';
                break;
            case (3):
                echo 'last (3)';
                break;
            case (4):
                echo 'wtf 3 (4)';
                break;
        }
        ?>
  </body>
</html>