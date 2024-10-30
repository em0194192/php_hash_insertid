<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    include "function.php";
    //preparedStatements();
    //preparedParameters();
    $newPassword = "Cats";
    $hashedPassword = hashpassword($newPassword);
    echo("</br>");
    echo($hashedPassword);
    //saveCustomer($hashedPassword);

    $enteredPassword = "Cats";
    $savedPassword = $hashedPassword; //ideally retrieved from the db
    checkPassword($enteredPassword, $savedPassword);


    ?>
</body>
</html>