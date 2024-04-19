<?php
session_start();
require_once ('mysqli_connect.php');
if(!isset($_SESSION['adminID'])){
  header('Location: adminLogin.php');
}

$id=$_REQUEST['productID'];
$name = "";
$price = "";
$quantity = "";
$description = "";
$error = "";
$image_data = "";
$productID="";

if(!empty($_POST)){

  $productID= $_POST['productID'];

    $q="DELETE FROM product where productID = '$productID'";
    $r=mysqli_query($dbc,$q);
    if($r){
     
      header("Location: adminProduct.php?error=The product has delete succesfully.");
	    exit();
        }
      
    else{
        echo "<p>The product has not delete succesfully.</p>"; }
}
else{
  $q="SELECT * FROM product where productID ='$id'";
  $r=mysqli_query($dbc,$q);
if(mysqli_num_rows($r)==1){
    $row=mysqli_fetch_array($r);
    $id=$row['productID'];
    $name=$row['proName'];
    $price=$row['proPrice'];
    $description=$row['proDesc'];
    $quantity=$row['maxQuantity'];
    $image_data= $row['image']; // Assuming 'image_data' is the column name where the image data is stored
}

mysqli_free_result($r);
}

mysqli_close($dbc);
?>

<html>
<head>
<title>Delete Product</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>

  #ending{
    
    font-family: Arial, Helvetica, sans-serif;
    font-size:30px;
    color:red;
  }
 table{
  border:none;
  width:100%;
  margin-bottom:3%;
  font-family: Arial, Helvetica, sans-serif;
 }
td{
    font-size: 28px;
    font-family: Arial, Helvetica, sans-serif;
    width:50%;
    padding-left:10px;
}

th{
  width:50%;
  font-size: 28px;
  text-align:right;
  padding-right:10px;
  
}

caption{
  text-align:center;
  margin-bottom:4%;
  font-size:40px;
  text-decoration:underline;
  font-weight: bold;
  font-family:Garamond;

}
    .container {
  margin-left:30%;
	margin-right:30%;
  margin-top:3%;
  padding-bottom:60px;
}

body{
    background-image: url("rainbow2.jpg");
    background-size: cover;
}

#submit{
  background-color: rgb(119, 255, 0);
  padding: 15px 30px 15px 30px;
  border-radius: 30px;
  
}

#cancel{
  background-color:orchid;
  padding: 15px 30px 15px 30px;
  border-radius: 30px;
  
}
.submit{
  text-align:center;
}


#submit:hover{
  filter: brightness(1.2);
  
}
#cancel:hover{
  filter: brightness(1.2);
  
}

.current-image {
        max-width: 300px; /* Adjust the max-width to your desired size */
        max-height: 300px; /* Adjust the max-height to your desired size */
        
    
    }

     .current-image-container {
        display: flex;
        justify-content: center;
    }
</style>
</head>
<body>
    <div class="container">
<form action="deleteProduct.php" method="post">
<table  cellpadding="5" cellspacing="0"> 
<caption>Delete Event</caption>
    <tr>
       <th>Product ID :</th>
       <td><?php echo $id; ?><input type="hidden" name="productID" maxlength="10"  value="<?php echo $id; ?>"/></td>
     </tr>
     <tr>
       <th>Name :</th>
       <td><?php echo $name; ?></td> 
    </tr>
        <tr>
            <th>Price:</th>
            <td><?php echo $price; ?></td> 
        </tr>
        <tr>  
        <th>Quantity :</th>
        <td><?php echo $quantity; ?></td>
</tr> 
<tr>  
        <th>Description :</th>
        <td><?php echo $description; ?></td>
</tr> 
<tr>
    <th>Image :</th>
    <td>
        <div class="current-image-container">
            <?php
            if (!empty($image_data)) {
                $image_base64 = base64_encode($image_data);
                echo '<img src="data:image/jpeg;base64,' . $image_base64 . '" alt="Product Image" class="current-image">';
            } else {
                echo '<p>No image available</p>';
            }
            ?>
        </div>
    </td>
</tr>
</table> 


<div class="submit">
  <p1 id="ending">Are sure want to delete ? </p1>
<br><br>
<input type="submit" name="Delete" id="submit" value="Delete" />
<input type="button" value="Cancel" id="cancel" onclick="location='adminProduct.php'"/>
 </div>
</form>
 

</div>

</body>
</html>
