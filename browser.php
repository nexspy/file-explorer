<?php

// Globals
global $first_loop, $current_path, $highlight, $filter;


// Files
$current_path = (isset($_GET['pos'])) ? $_GET['pos'] : basename('.');
$highlight = (isset($_GET['highlight'])) ? $_GET['highlight'] : null;
$filter = (isset($_GET['filter'])) ? $_GET['filter'] : null;
//$files = glob($current_path . '/*');
$first_loop = false;

// Utility functions
function listFolderFiles($dir) {
  global $first_loop, $highlight, $filter;
  $ffs = scandir($dir);
  echo '<ul>';
  foreach ($ffs as $ff) {
    if ($ff != '.' && $ff != '..') {
      $fullpath = $dir . '/' . $ff;
      $explode = explode('.', $ff);
      $ext = end($explode);
      $class = 'list-item ';
      $class .= (is_dir($dir . '/' . $ff)) ? 'is_dir' : 'is_file';
      if (isset($_GET['pos']) && $first_loop == false) {
        echo '<li class="list-item is_dir"><a href="browser.php">..</a></li>';
        $first_loop = true;
      }
      // highlighting files with extension
      if ($ext == $highlight) {
        $class .= ' highlight ';
      }
      // filter files
      if (!is_null($filter)) {
        if ($ext != $filter && is_dir($ff) == false) {
          continue;
        }
      }
      // gather file information
      $fileinfo = array(
          'last_access' => date("Y.m.d H:i:s", fileatime($fullpath)),
          'last_changed' => date("Y.m.d H:i:s", filectime($fullpath)),
          'last_modified' => date("Y.m.d H:i:s", filemtime($fullpath)),
          'owner' => fileowner($fullpath),
          'permission' => fileperms($fullpath),
          'type' => filetype($fullpath),
          'size' => filesize($fullpath),
      );
      // display info
      $info = '<div class="file-info">';
      $info .= '<ul>';
      $info .= '<li>Last accessed at ' . $fileinfo['last_access'] . '</li>';
      $info .= '<li>Last changed at ' . $fileinfo['last_changed'] . '</li>';
      $info .= '<li>Last modification at ' . $fileinfo['last_modified'] . '</li>';
      $info .= '<li>Owner : ' . $fileinfo['owner'] . '</li>';
      $info .= '<li>Permission : ' . $fileinfo['permission'] . '</li>';
      $info .= '<li>Type : ' . $fileinfo['type'] . '</li>';
      $info .= '<li>Size : ' . $fileinfo['size'] . ' bytes' . '</li>';
      $info .= '</ul>';
      $info .= '</div>';
      
      
      echo '<li class="' . $class . '">' . $ff;
      if (is_dir($dir . '/' . $ff))
        listFolderFiles($dir . '/' . $ff);
      echo $info;
      echo '</li>';
    }
  }
  echo '</ul>';
}
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Browser</title>

    <link rel="stylesheet" href="css/browser.css" >
    
  </head>
  <body>


    <div class="wrapper">
      <div class="main">

        <?php $files = listFolderFiles($current_path); ?>
        
      </div>
    </div>

    
    <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <style>
  
  </style>
    <script type="text/javascript">
      // initiate tooltip
      $( document ).tooltip({
        position: {
          my: "center bottom-20",
          at: "center top",
          using: function( position, feedback ) {
            $( this ).css( position );
            $( "<div>" )
              .addClass( "arrow" )
              .addClass( feedback.vertical )
              .addClass( feedback.horizontal )
              .appendTo( this );
          }
        }
      });
      
      
      jQuery(document).ready(function($){
        // show file details on hover
        $('li.is_file').hover(
          function() {
            jQuery(this).find('.file-info').show();
          },
          function() {
            jQuery(this).find('.file-info').hide();
          }
        );
      });
    </script>
    
  </body>
</html>