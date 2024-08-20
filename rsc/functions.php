<?php 
function getLinkLabel($file) {
   if($file->getExtension() == 'md' ||
      $file->getExtension() == 'org' ||
      $file->getExtension() == 'wiki' ||
      $file->getExtension() == 'txt'){
      return $file->openFile()->fgets();
   } else if($file->getExtension() == 'html'){
          //function page_title($url) {
      // Stackoverflow: https://stackoverflow.com/questions/399332/fastest-way-to-retrieve-a-title-in-php
        $fp = file_get_contents($file->getPathname());
        if (!$fp) 
            return null;

        $res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
        if (!$res) 
            return null; 

        // Clean up title: remove EOL's and excessive whitespace.
        $title = preg_replace('/\s+/', ' ', $title_matches[1]);
        $title = trim($title);
        return $title;
    //}
         //$document = new DOMDocument();
      //$document->load('Recipes/'.$file->getFilename());
      //return $document->getElementsByTagName('title')->item(1)->nodeValue;
      //return $file->getFilename();
   } else if($file->getExtension() == 'docx' || 
             $file->getExtension() == 'odt'  ||
             $file->getExtension() == 'tex'  ||
             $file->getExtension() == 'php'  ||
             $file->getExtension() == 'pdf'  ||
             $file->getExtension() == 'rtf'){
      return basename($file->getFilename(), ".".$file->getExtension());
   }
}
function isConvertable($file) {
   if(substr($file->getFilename(), 0, 1) != "." && ($file->getExtension() == 'md' || $file->getExtension() == 'docx' ||
      $file->getExtension() == 'org' || $file->getExtension() == 'rtf' ||
      $file->getExtension() == 'txt' || $file->getExtension() == 'tex' ||
      $file->getExtension() == 'html' || $file->getExtension() == 'php' ||
      $file->getExtension() == 'pdf' || 
      $file->getExtension() == 'wiki' || $file->getExtension() == 'odt')) { 
      return true;
   }
   return false;
}

?>
