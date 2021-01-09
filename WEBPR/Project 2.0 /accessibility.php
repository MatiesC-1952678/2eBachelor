<?php
  session_start();
  if (empty($_SESSION["typeLogged"])) {
    $_SESSION["typeLogged"] = "";
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Accessibility</title>
  <meta charset="utf-8">
  <meta name="description" content="A platform for hotels and customers to easily meet">
  <meta name="keywords" content="Room,Country,Hotel,Book">
  <meta name="author" content="Maties Claesen">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- Page Container -->
  <div id="PageContainer">

    <?php include ("php/header.php") ?>

    <!-- Main Content -->
    <div>
      <!-- AccesibilityList -->
      <section id="AccesibilityList">
        <h1>Accessibility statement for Suite Dreams</h1>
        <p>We want everyone who visits the Suite Dreams website to feel welcome and find the experience rewarding.</p>
        <h2>What are we doing?</h2>
        <p>To help us make the Suite Dreams website a positive place for everyone, we've been using the <a href="http://www.w3.org/TR/WCAG/">Web Content Accessibility Guidelines (WCAG) 2.1</a>. These guidelines explain how to make web content more accessible for people with disabilities, and user friendly for everyone.</p>
        <p>The guidelines have three levels of accessibility (A, AA and AAA). We’ve chosen Level AA as the target for the Suite Dreams website.</p>
        <h2>How are we doing?</h2>
        <p>We're working hard to achieve our goal of Level AA accessibility, but we realise there are some areas that still need improving. The following information explains what we're doing to make that happen.</p>
        <h3>Success criteria 1.2.3:</h3>
        <p>User uploaded videos do not have alternative texts. However in the future there will be a way to add alternative text descriptions yourself when uploading the video(s).</p>
        <h3>Success criteria 1.2.5:</h3>
        <p>No, however in the future a user could perhaps add these as well.</p>
        <h3>Success criteria 1.3.3:</h3>
        <p>When using a mobile device, navigation buttons are not accessible with text elements. Using a bigger screen however makes the header have descriptions.</p>
        <h3>Success criteria 2.1.1:</h3>
        <p>The map is only partially operable because you need to use mouseclicks. However in the future, there will be keyboard bindings available.</p>
        <h3>Success criteria 2.4.1:</h3>
        <p>There are no links available that let you quickly move to other parts of the page.</p>
        <h3>Success criteria 3.2.2:</h3>
        <p>You can enter wrong values meaning the css layout changes but besides that, no.</p>
        <h3>Success criteria 3.3.4:</h3>
        <p>There is no way of doing these things before doing a booking. However you could do this in the future on another page.</p>
        <h2>Let us know what you think</h2>
        <p>If you enjoyed using the Suite Dreams website, or if you had trouble with any part of it, please get in touch. We'd like to hear from you in any of the following ways:</p>
        <ul>
          <li>email us at <a href="mailto:matieke6@gmail.com">matieke6@gmail.com</a></li>
          <li>call us on 0478559247</li>
        </ul>
        <p>This accessibility statement was generated on 9th January 2021 using the <a href="http://accessibilitystatementgenerator.com">Accessibility Statement Generator</a>, <a href="https://nomensa.com">built by Nomensa</a>.</p>
      </section>
    <?php include("php/footer.php") ?>
  </div>
</div>
</body>
</html>
