<?php require_once("config.php"); ?>

<!DOCTYPE HTML>

<html lang="en">
  <head>
    <title><?php echo $website_title; ?> - Projects</title>
    <link href="css/layout.css" rel="stylesheet" type="text/css" media="screen" />
  </head>

  <body id="projects">
    <div id="wrapper">
    
      <?php include_once("header.html"); ?>
      
      <div id="main">
        
        <?php include_once("navigation.html"); ?>
        
        <div id="content">
          <h1>Projects</h1>
  	      <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.</p>
          <div class="project-item">
             <p class="project-name"><a href="wiki/index.php">Mini Wiki</a></p>
             <p class="project-description">Implementation of a simple Wiki</p>   
          </div>
        </div> <!-- end content -->
        
      </div> <!-- end main -->
      <?php include_once("footer.html"); ?>
    
    </div> <!-- end wrapper --> 
  
  </body>

</html>
