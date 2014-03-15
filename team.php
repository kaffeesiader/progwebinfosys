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
  	      <p>
            <img class="float-left" src="images/teamwork.jpg" height="132" width="196"/>
            <strong>Team members:</strong> Martin Griesser, Boris Schmidlehner
          </p>
          <p class="clear">&nbsp</P>
          <!-- p style="clear: both">Some words about our team!</p -->
        </div> <!-- end content -->
        
      </div> <!-- end main -->
      <?php include_once("footer.html"); ?>
    
    </div> <!-- end wrapper --> 
  
  </body>

<html>
