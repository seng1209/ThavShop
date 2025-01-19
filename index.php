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

      $myfile = fopen("./file.txt", "a") or die("File not found");
      $txt = "Chheng Han\n";
      fwrite($myfile, $txt);
      $txt = "Srey Nich\n";
      fwrite($myfile, $txt);
      $txt = "Mey\n";
      fwrite($myfile, $txt);
      fclose($myfile);

      $myfile = fopen("./file.txt", "r") or die("File not found");
      while(!feof($myfile)){
        echo fgets($myfile) . "<br/>";
      }
      fclose($myfile);
    ?>
</body>
</html>