<?php


/*$name= "Akwesi" ;
$$name= "Ama";
echo "His name is " ,$name;
*/
function displayinfo($name,$age)
{
/*$name="ELEZAR NARTEH";
$age= 21;*/
    echo "The age of the {$name} is {$age}";


} 

displayinfo (name: "Narteh Eleazar", age:"21");



// Initialize PDO connection (update DSN, username, and password as needed)
$dsn = 'mysql:host=localhost;dbname=your_database_name';
$username = 'your_username';
$password = 'your_password';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT DATABASE()");
    echo $stmt->fetchColumn();
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}