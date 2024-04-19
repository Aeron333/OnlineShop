<?php
session_start();
require_once ('mysqli_connect.php');
if(!isset($_SESSION['adminID'])){
  header('Location: adminLogin.php');
}


?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Product</title>
   <style>

.button2 {
  background-color:red;
  border: none;
  color: white;
  padding: 12px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 12px;
}
.button1 {
  background-color:#4CAF50;
  border: none;
  color: white;
  padding: 12px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 12px;
}
.button0 {
  background-color:#4CAF50;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin-top:20px;

 
}

body {
	
	font-family:'Source Sans Pro', sans-serif;
	margin:0;
  background-image: url("rainbow2.jpg");
  background-size: cover;
}

.container {
            margin: auto;
            width: 95%;
            position: relative; /* Needed for absolute positioning */
        }

.table {
  border-collapse: collapse;
  border: none;
  margin-bottom:1%;
}

td , th{
    border:1px solid;
    border-color:black;
    text-align:center;
    font-weight: bold;
    
   overflow: hidden;  
}

th{
   font-weight: 900;
   padding:5px 20px 5px 20px;
}


.pic {
  width: 200px;
  width:10%;
}

caption{
  text-align:center;
  margin:30px;
  font-size:40px;
  text-decoration:underline;
  font-weight: bold;
font-family:Garamond;

}

.bottom{
  caption-side: bottom;
}
#pictu{
  padding: 5px;
  width: 100px;
  height: 100px;
}
.error{
  font-size:20px;
  text-decoration:underline;
  font-weight: bold;
font-family:Garamond;
margin-left:auto;
margin-bottom:19px;
}


   </style>
  </head>

  <body>
  <?php include("adheader.php"); ?> 
  
    <div class=container>
    <a href="adminAdd.php" class="button0">Add Product</a>
<table class="table">
    <caption>Product On Sell</caption>
    <tr>
    <th style="width:12%;">Product ID</th>
    <th style="width:10%;">Name</th>
    <th style="width:10%;">Price (RM)</th>
    <th style="width:10%;">Description</th>
    <th style="width:10%;">Quantity</th>
    <th style="width:20%;">Image</th>
    <th colspan="2" class="wide";>Operation</th>
    
    <tr>
    <?php
$q = "SELECT * FROM product";
$r = mysqli_query($dbc,$q);
$num = mysqli_num_rows($r);

if ($num >0){
    while ($row = mysqli_fetch_array($r)){
      printf('   
      <tr>
          <td>'.$row['productID'].'</td>
          <td>'.$row['proName'].'</td>
          <td>'.$row['proPrice'].'</td>
          <td>'.$row['proDesc'].'</td>
          <td>'.$row['maxQuantity'].'</td>
          <td><img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" id="pictu"/></td>
          <td style="padding:8px;"><a href="editProduct.php?productID='.$row['productID'].'" class="button1">Modify</a></td>
          <td style="padding:8px;"><a href="deleteProduct.php?productID='.$row['productID'].'" class="button2">Delete</a></td>
      </tr>');

    }
}

mysqli_free_result($r);

mysqli_close($dbc);
?>
</table>

<div class="error">
<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>

</div>

</div>

  </body>
</html>
