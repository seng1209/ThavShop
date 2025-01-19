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

    // $_GET, $_POST =  special variable used to collect data from an HTML 
    //                  form data is sent to the file in the action 
    //                  attribute of <form> 
    //                  <form action="some_file.php" method="get">

    // $_GET =  Data is appended to the url 
    //          NOT SECURE
    //          Bookmark is possible w/ values
    //          GET requests can be cached 
    // Better for a search page

    // $_POST = Data is packaged inside the body of the HTTP requirest
    // MORE SECURE
    // No data limint
    // Cannot bookmark
    // GET requests are not cached
    // Better for submitting credentials 

    // control statement
    // if(condition){...} elseif(condition){...} else{...}

    // Logical operators = combine conditional statements
    // && (AND operator)
    // || (OR operator)
    // !  (NOT operator)

    // switch = replacement to using many elseif statements
    //          more efficient, less code to write (like c++ or java)

    // loop
    // for loop
    // for ($i = 0; $i <= 100; $i++){...}
    // while loop
    
    // array = "variable" which can hold more than one value at
    // $food = array("apple", "banana", "...", .....);
    // echo $food[0] access by index

    // foreach($foods as $food){...}

    // associative array = An array made of key=>value pairs
    // associative_array = array("key"=>"value",......);

    // isset() = Returns TRUE if a variable is declared and not null
    // empty() = Returns TRUE if a variable is not declared, false, null, ""
    
    // include() =  Copies the contect of a file (php/html/text)
    //              and includes it in your php file.
    //              Sections of our website become reusable
    //              Changes only need to be made in one place

    // cookie = Information about a user stored in a user's web-vrowser
    //          thrgeted advertisements, browsing preferences, and
    //          other non-sensitive data

    // session =    SGB used to store information on a user
    //              to be used across multiple pages.
    //              A user is assigned a session-id 
    //              ex. login credentials
    // session_start();
    // session_destroy();

    // The readfile() function reads a file and writes it to the output buffer.

    readfile("./file.txt")

    ?>
</body>
</html>