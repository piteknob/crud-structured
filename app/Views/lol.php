<?php 
if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
        <ul>
            <label for="username">Username: </label>
            <input type="text" name="username" id="password">  
            <br><br>
            <label for="password">Password: </label>
            <input type="password" name="password" id="password">
            <br><br>
            <button type="submit" name="submit">Login</button>
        </ul>
    </form>
</body>
</html>