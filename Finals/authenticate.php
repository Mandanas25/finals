<?php
session_start();
class ConnectDb {
    private static $instance = null;
    private $conn;
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $name = 'Finals';

    private function __construct() {
        $this->conn = new PDO("mysql:host={$this->host};dbname={$this->name}", $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
	public static function getInstance() {
		if (!self::$instance) {
            self::$instance = new ConnectDb();
        }return self::$instance;
    }
public function getConnection(){
	return $this->conn;
}
}

 
$instance = ConnectDb::getInstance();

$conn = $instance->getConnection();

var_dump($conn);

$instance = ConnectDb::getInstance();

$conn = $instance->getConnection();

var_dump($conn);

$instance = ConnectDb::getInstance();

$conn = $instance->getConnection();

var_dump($conn);

if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	
	echo '<script>alert("Please fill both the username and password fields!"</script>';
}
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $conn->prepare('SELECT id, password FROM accounts WHERE username = :username')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bindParam(':username', $_POST['username']);
	$stmt->execute();

	
if ($stmt->rowCount() > 0) {
	
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $row['id'];
	$hashedPassword = $row['password'];

	$stmt->fetch();
	// Account exists, now we verify the password.
	// Note: remember to use password_hash in your registration file to store the hashed passwords.
	if (password_verify($_POST['password'], $hashedPassword)) {
		// Verification success! User has logged-in!
		// Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $_POST['username'];
		$_SESSION['id'] = $id;
		header('Location: home.php');
	} else {
		// Incorrect password
		echo 'Incorrect username and/or password!';
		
	}
} 
else {
    echo 'Incorrect username and/or password!';
	
}

	$stmt->close();
}
?>