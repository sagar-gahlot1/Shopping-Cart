<?php
session_start();

// UPDATE `login_user` SET  `cart`=null  WHERE  `id`=200

if( !defined('FOO_EXECUTED') ){
    $con1 = mysqli_connect('127.0.0.1:3306','root','','karan') or die('Unable To connect');
$id=$_SESSION["id"];
$temp=mysqli_query($con1,"SELECT `cart` FROM `login_user` WHERE id=$id");

$row1 = mysqli_fetch_assoc($temp);
$temp1=$row1['cart'];
$_SESSION["shopping_cart"]=unserialize($temp1);
//echo gettype($temp1);

mysqli_close($con1);
    define('FOO_EXECUTED', TRUE);
}



try {
	if(isset($_SESSION["name"])){}
	else{
		echo 'Please login first';
		exit(0);
	}
  }
  
  //catch exception
  catch(Exception $e) {
	echo 'Please login first';
	exit();
  }


?>
<html>
<head>
<title>User Login</title>
</head>
<body>

<?php
if($_SESSION["name"]) {
?>
Welcome <?php echo $_SESSION["name"]; ?>. Click here to <a href="logout.php" tite="Logout">Logout.

<?php
include('db.php');


$status="";
if (isset($_POST['code']) && $_POST['code']!=""){
$code = $_POST['code'];
$result = mysqli_query($con,"SELECT * FROM `products` WHERE `code`='$code'");
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
$code = $row['code'];
$price = $row['price'];
$image = $row['image'];


$cartArray = array(
	$code=>array(
	'name'=>$name,
	'code'=>$code,
	'price'=>$price,
	'quantity'=>1,
	'image'=>$image)
);




if(empty($_SESSION["shopping_cart"])) {
	$_SESSION["shopping_cart"] = $cartArray;
	$status = "<div class='box'>Product is added to your cart!</div>";

	$con1 = mysqli_connect('127.0.0.1:3306','root','','karan') or die('Unable To connect');
$id=$_SESSION["id"];
$shopc=serialize($_SESSION["shopping_cart"]);
 $sql="UPDATE `login_user` SET `cart`='$shopc' WHERE `id`=$id";
 if ($con1->query($sql) === TRUE) {
	
  } else {
	echo "Error updating record: " . $con1->error;
  }
  $con1->close();


}else{
	$array_keys = array_keys($_SESSION["shopping_cart"]);
	if(in_array($code,$array_keys)) {
		$status = "<div class='box' style='color:red;'>
		Product is already added to your cart!</div>";	
	} else {
	$_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$cartArray);

    
$con1 = mysqli_connect('127.0.0.1:3306','root','','karan') or die('Unable To connect');
$id=$_SESSION["id"];
$shopc=serialize($_SESSION["shopping_cart"]);
 $sql="UPDATE `login_user` SET `cart`='$shopc' WHERE `id`=$id";
 if ($con1->query($sql) === TRUE) {
	
  } else {
	echo "Error updating record: " . $con1->error;
  }
  $con1->close();

	$status = "<div class='box'>Product is added to your cart!</div>";
	}

	}
}

?>
<html>
<head>
<title>Shopping Cart</title>
<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
</head>
<body>
<div style="width:700px; margin:50 auto;">

<h2>Shopping Cart</h2>   

<?php
if(!empty($_SESSION["shopping_cart"])) {
$cart_count = count(array_keys($_SESSION["shopping_cart"]));
?>
<div class="cart_div">
<a href="cart.php"><img src="cart-icon.png" /> Cart<span><?php echo $cart_count; ?></span></a>
</div>
<?php
}

$result = mysqli_query($con,"SELECT * FROM `products`");
while($row = mysqli_fetch_assoc($result)){
		echo "<div class='product_wrapper'>
			  <form method='post' action=''>
			  <input type='hidden' name='code' value=".$row['code']." />
			  <div class='image'><img src='".$row['image']."' /></div>
			  <div class='name'>".$row['name']."</div>
		   	  <div class='price'>$".$row['price']."</div>
			  <button type='submit' class='buy'>Buy Now</button>
			  </form>
		   	  </div>";
        }
mysqli_close($con);
?>

<div style="clear:both;"></div>

<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>


<?php
}else echo "<h1>Please login first .</h1>";
?>

</body>
</html>