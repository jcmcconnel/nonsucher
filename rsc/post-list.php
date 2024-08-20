<?php 
   include $_SERVER['DOCUMENT_ROOT'] ."/rsc/functions.php";
   
function generatePostList($docsRoot='docs') {
   $nav = "\n<nav id='posts'><ul>\n";
   foreach(new DirectoryIterator($docsRoot) as $file ) {
      if( ! ($file->getFilename() == 'welcome.md') && isConvertable($file)){
         if(isset($_GET['id']) && $file == $_GET['id']) {
            $nav = $nav."<li id='selected'><a href='?id=welcome.md'>".getLinkLabel($file)."</a></li>\n";
         } else {
            if(strpos($file->getFilename(), ' ') !== false) {
               $nav = $nav."<li><a href='?id=\"".$file."\"'>".getLinkLabel($file)."</a></li>\n";
            } else {
               $nav = $nav."<li><a href='?id=".$file."'>".getLinkLabel($file)."</a></li>\n";
            }
         }
      }
   }
   $nav = $nav."</ul></nav>";
   echo $nav;
}
?>
