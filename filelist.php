<?PHP
error_reporting(E_ALL & ~E_NOTICE);
  // output file list as table rows
  function getFileList($dir)
  {
    // array to hold return value
    $retval = array();

    // add trailing slash if missing
    if(substr($dir, -1) != "/") $dir .= "/";

    // open pointer to directory and read list of files
    $d = @dir($dir) or die("getFileList: Failed opening directory $dir for reading");
    while(false !== ($entry = $d->read())) {
      // skip hidden files
      if($entry[0] == ".") continue;
      if(is_dir("$dir$entry")) {
        $retval[] = array(
          "name" => "$entry",
          "type" => filetype("$dir$entry"),
          "size" => 0,
          "lastmod" => filemtime("$dir$entry")
        );
      } elseif(is_readable("$dir$entry")) {
        $retval[] = array(
          "name" => "$entry",
          "type" => mime_content_type("$dir$entry"),
          "size" => filesize("$dir$entry"),
          "lastmod" => filemtime("$dir$entry")
        );
      }
    }
    $d->close();

    return $retval;
  }
    
  $dirlist = getFileList("backup");
echo "<table border=\"1\">\n";
  echo "<thead>\n";
  echo "<tr><th>SL</th><th>Name</th><th>Type</th><th>Size</th><th>Last Modified</th></tr>\n";
  echo "</thead>\n";
  echo "<tbody>\n";
  $m=0;
  foreach($dirlist as $file) {
	  $n++;
    echo "<tr>\n";
    echo "<td>{$n}</td>\n";
	 echo "<td><a href='#'>{$file['name']}</a></td>\n";
    echo "<td>{$file['type']}</td>\n";
    echo "<td>{$file['size']}</td>\n";
    echo "<td>",date('r', $file['lastmod']),"</td>\n";
    echo "</tr>\n";
  }
  echo "</tbody>\n";
  echo "</table>\n\n";?>
