<?php 
   $nav = "\n<nav id='site'><ul>\n";
   $nav = $nav."<li><a href=\"/\">Home</a></li>";
   $nav = $nav."<li class=\"dropdown\" ><a>Projects</a>\n";
   $nav = $nav."<ul class=\"dropdown-content\">\n";
   $nav = $nav."<li><a href=\"/projects/blog\">Blog</a></li>\n";
   $nav = $nav."<li><a href=\"/projects/website\">Website</a></li>\n";
   $nav = $nav."</ul></li>\n";
   $nav = $nav."</ul></nav>";
   echo $nav;
?>
