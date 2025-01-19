<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Learning</title>
</head>
<body>
    <?php

      $myfile = fopen("./file.txt", "r") or die("File not found");
      while(!feof($myfile)){
        echo fgets($myfile) ." <br/>";
      }
      fclose($myfile);

    ?>
</body>
</html>