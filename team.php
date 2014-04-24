<?php require_once("config.php"); ?>

<!DOCTYPE HTML>

<html lang="en">
  <head>
    <title><?php echo $website_title; ?> - Team</title>
    <link href="css/layout.css" rel="stylesheet" type="text/css" media="screen" />
  </head>

  <body id="team">
    <div id="wrapper">
    
      <?php include_once("header.html"); ?>
      
      <div id="main">
        
        <?php include_once("navigation.html"); ?>
        
        <div id="content">
          <h1>Team</h1>
  	      <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.</p>
  	      <p>
            <img class="float-left" src="images/teamwork.jpg" height="132" width="196"/>
            <strong>Team members:</strong> Martin Griesser, Boris Schmidlehner
          </p>
          <p class="clear">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.</P>
          <!-- p style="clear: both">Some words about our team!</p -->
        </div> <!-- end content -->
        
      </div> <!-- end main -->
      <?php include_once("footer.html"); ?>
    
    </div> <!-- end wrapper --> 
  
  </body>

</html>
