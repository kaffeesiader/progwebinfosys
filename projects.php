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
  	      <p>Here goes our projects.</p>
          <div class="project-item">
             <p class="project-name"><a href="">Project 1</a></p>
             <p class="project-description">Description of project 1</p>   
          </div>
          <div class="project-item">
             <p class="project-name"><a href="">Project 2</a></p>
             <p class="project-description">Description of project 2</p>   
          </div>
          <div class="project-item">
             <p class="project_name"><a href="">Project 3</a></p>
             <p class="project_description">Description of project 3</p>   
          </div>
        </div> <!-- end content -->
        
      </div> <!-- end main -->
      <?php include_once("footer.html"); ?>
    
    </div> <!-- end wrapper --> 
  
  </body>

<html>
