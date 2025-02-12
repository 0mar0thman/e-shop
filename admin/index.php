<?php
ob_start();

session_start();
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit();
}

$pageTitle = "Login";
$noNavbar = "";
include 'init.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashpass = sha1($password);

    $stmt = $con->prepare("SELECT UserID, Username, Password FROM users WHERE Username = ? AND Password = ? LIMIT 1");
    $stmt->execute(array($username, $hashpass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    $errorLogin = array();

    if ($count > 0) {
        $_SESSION['id'] = $row['UserID'];
        $_SESSION['user'] = $row['Username'];
        $_SESSION['original_username']  =  $row['Username'];
        header('Location: dashboard.php');
        exit();
    } else {

        if (empty($password)) $errorLogin[] =  "Password Cannot be Empty !!";
        if (empty($username)) $errorLogin[] =  "User Name Cannot be Empty !!";
        if (!empty($username) && !empty($password)) $errorLogin[] = "Not Valid !!";

        foreach ($errorLogin as $value) {
            $_SESSION['errorLogin'][] = $value;
        }
        header('Location: index.php');
        exit();
    }
}
?>

<?php include $pages . 'login.php'; ?>
<?php include $tpl . 'footer.php'; ?>