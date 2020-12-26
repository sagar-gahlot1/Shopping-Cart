<?php
$id=$_POST['id'];
$name = $_POST['name'];
$user_name = $_POST['user_name'];
$email = $_POST['email'];
$password = $_POST['password'];
//$age=$_POST['age'];
//$adhar_num = $_POST['adhar_num'];
//$gender = $_POST['gender'];
//$phone = $_POST['phone'];
//$state=$_POST['state'];
if (!empty($name) || !empty($id) || !empty($email) || !empty($user_name)||!empty($password)) {
 $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "karan";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
     $SELECT = "SELECT email From login_user Where email = ? Limit 1";
     $INSERT = "INSERT Into login_user (id,name,user_name,email,password) values(?, ?, ?, ?, ?)";
     //Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;
     if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("issss",$id,$name,$user_name,$email,$password);
      $stmt->execute();
      echo "Signup sucessfully ..... now you can login ";
      echo '<a href="login.php">move to login</a>';
     } else {
      echo "Someone already register using this email";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>  