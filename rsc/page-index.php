<!DOCTYPE html>
<html>
   <head>
      <?php 
         if(file_exists("page-details.php")) {
            include "page-details.php";
         } else {
            include $_SERVER['DOCUMENT_ROOT'] ."/rsc/page-details-defaults.php";
         }
      ?>
      <title><?php echo $title ?></title>
      <link rel="stylesheet" type="text/css" href="/rsc/main.css" />
      <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
      <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
   </head>
   <body>
      <header>
         <?php include $_SERVER['DOCUMENT_ROOT'] ."/rsc/header.php"; ?>
      </header>
      <div id="body-section">
         <?php 
            include $_SERVER['DOCUMENT_ROOT'] ."/rsc/post-list.php"; 
            generatePostList('docs');
         ?>
         <main>
           <?php
               echo "<div id='file'>";
               $handle = NULL;
               if(isset($_GET['id'])) {
                  // Directory traversal prevention
                  $filename = pathinfo($_GET['id'], PATHINFO_BASENAME);
                  $filename = str_replace("&", "", $filename);
                  $filename = str_replace("/", "", $filename);
                  $filename = str_replace("..", "", $filename);
                  $filename = str_replace("\\", "", $filename);
                  $filename = str_replace("|", "", $filename);
                  $filename = str_replace("\"", "", $filename);
                  //echo $filename;
                  if(
                     empty($filename) || 
                     !file_exists("docs/".$filename)
                  ){
                     $handle = popen("/usr/bin/pandoc docs/welcome.md", "r"); 
                     echo stream_get_contents($handle);
                     fclose($handle);
                  } else if(!substr_compare($filename, ".php", -4, 4, true)){
                     include "docs/".$filename;
                  }else{
                     if(!substr_compare($filename, ".html", -5, 5, true)){
                        //echo "HTML file ".substr($filename, -5).substr_compare($filename, ".html", -5) ; 
                        $handle = fopen("docs/".$filename, "r");
                     }else {
                        //echo "Not an HTML file";
                        if(!strpos($filename, " ")) $handle = popen("/usr/bin/pandoc docs/".$filename, "r");
                        else $handle = popen("/usr/bin/pandoc docs/\"".$filename."\"", "r");
                     }
                     echo stream_get_contents($handle);
                     fclose($handle);
                  }
               }else{
                  $handle = popen("/usr/bin/pandoc docs/welcome.md", "r"); 
                  echo stream_get_contents($handle);
                  fclose($handle);
               }
               echo "</div>";
            ?>
         </main>
      </div>
      <footer>
         <?php include $_SERVER['DOCUMENT_ROOT'] ."/rsc/footer.php"; ?>
      </footer>
   </body>
</html>
