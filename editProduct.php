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


$image_name = "";
$image_type = "";
$image_size = "";
$image_data = "";
$image_dataold = "";
$error = array();

?>


<?php
if(!empty($_POST)){

  $name= $_POST['name'];
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];
  $description= $_POST['description'];


  if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    $image_name = $name;
    $image_type = $_FILES["image"]["type"];
    $image_size = $_FILES["image"]["size"];
    $temp_name = $_FILES["image"]["tmp_name"];
    $image_data = file_get_contents($temp_name);
  
  }



    if($name == null)
        $error['name'] = "Please enter product name.";
    elseif(!preg_match('/^[A-Za-z @,\'\.\-\/+$]/', $name))
        $error['name'] = "There are invalid characters in your product name.";

    
        if ($price == null) {
            $error['price'] = "Price is required.";
        } else {
            if (!is_numeric($price)) {
                $error['price'] = "Price must be a numeric value.";
            } elseif ($price < 0) {
                $error['price'] = "Price cannot be negative.";
            } else {
                // Adjust these values according to your requirements
                $minPrice = 0;
                $maxPrice = 1000;
                
                if ($price < $minPrice || $price > $maxPrice) {
                    $error['price'] = "Price must be between $minPrice and $maxPrice.";
                } elseif (strpos($price, '.') !== false) {
                    $decimalPrecision = 2; // Adjust according to your requirements
                    $decimalCount = strlen(substr(strrchr($price, '.'), 1));
                    if ($decimalCount > $decimalPrecision) {
                        $error['price'] = "Price can have maximum $decimalPrecision decimal places.";
                    }
                } elseif (!preg_match('/^\d+(\.\d{1,2})?$/', $price)) {
                    $error['price'] = "Price format is invalid.";
                }
            }
        }
    
        if ($quantity == null) {
            $error['quantity'] = "Quantity is required.";
        } else {
            if (!is_numeric($quantity)) {
                $error['quantity'] = "Quantity must be a numeric value.";
            } elseif ($quantity <= 0) {
                $error['quantity'] = "Quantity must be greater than zero.";
            }
        }

        if ($description == null) {
            $error['description'] = "Description is required.";
        }

  

  if(empty($error)){

    $q = "";
if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    $q = "UPDATE product SET  
    proName=?,
    proPrice=?,
    quantity=?,
    proDesc=?,
    image=?,
    imageName=?
    WHERE productID=?";
    $stmt = mysqli_prepare($dbc, $q);
    mysqli_stmt_bind_param($stmt, "sssssss", $name, $price, $quantity, $description, $image_data, $image_name, $id);
} else {
    $q = "UPDATE product SET  
    proName=?,
    proPrice=?,
    quantity=?,
    proDesc=?
    WHERE productID=?";
    $stmt = mysqli_prepare($dbc, $q);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $price, $quantity, $description, $id);
}

if (mysqli_stmt_execute($stmt)) {
    header("Location: adminProduct.php?error=The event details have been updated successfully.");
    exit();
} else {
    header("Location: adminProduct.php?error=The event details could not be updated.");
    exit();
}


}
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
    $image_dataold = $row['image']; // Assuming 'image_data' is the column name where the image data is stored

}

mysqli_free_result($r);
}
mysqli_close($dbc);
?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Product</title>
   <style>
.container{
  min-width: min-content;
  justify-content: center;
  display: flex;
  margin: 15px 30% 15px 30%;
  border-radius:30px;
  padding: 30px;
  background-color:aliceblue;
}

.form-control {
  display: block;
  width: 100%;
  padding: 15px;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  text-align: center;
}

textarea {
        resize: none;
        height: 100px;
        width: 350px;
}

body{
  background-image: url("rainbow2.jpg");
  background-size: cover;
}

li{
  font-size: 18px;
  color: red;
}

.error {
        color: red;
    }


.current-image {
        max-width: 200px; /* Adjust the max-width to your desired size */
        max-height: 200px; /* Adjust the max-height to your desired size */
        border: 5px solid #555;
    }
   </style>
  </head>

  <body>

    <div class="container">
    <h1 style="text-align:center">Edit Product</h>
      <form action="editProduct.php" method="post"  enctype="multipart/form-data">

      <div class="form-control">
          <label for="id">Product ID:</label>
          <td><?php echo $id; ?><input type="hidden" name="productID" maxlength="10"  value="<?php echo $id; ?>"/></td>
        </div>


      <div class="form-control">
          <label for="name">Product Name:</label>
          <input type="text" id="name" class="form-control" placeholder="Enter product name" name="name" value="<?php echo $name; ?>">
          <?php if(isset($error['name'])): ?>
        <span class="error"><?php echo $error['name']; ?></span>
    <?php endif; ?>
        </div>

        <div class="form-control">
          <label for="name">Product Price:</label>
          <input type="text" id="price" class="form-control" placeholder="Enter product price" name="price" value="<?php echo $price; ?>">
          <?php if(isset($error['price'])): ?>
        <span class="error"><?php echo $error['price']; ?></span>
    <?php endif; ?>
        </div>

        <div class="form-control">
          <label for="name">Product Quantity:</label>
          <input type="text" id="quantity" class="form-control" placeholder="Enter product quantity" name="quantity" value="<?php echo $quantity; ?>">
          <?php if(isset($error['quantity'])): ?>
        <span class="error"><?php echo $error['quantity']; ?></span>
    <?php endif; ?>
        </div>


        <div class="form-control">
          <label for="description">Product Description:</label><br>
          <textarea rows="2" cols="50" name="description" id="description" class="form-control" placeholder="Enter details here..."><?php echo $description; ?></textarea>
          <?php if(isset($error['description'])): ?>
        <span class="error"><?php echo $error['description']; ?></span>
    <?php endif; ?>
        </div>



        <div class="form-control">
    <label for="current_image"></label><br>
    <div class="current-image-container">
        <?php
        if (!empty($image_dataold)) {
            $image_base64 = base64_encode($image_dataold);
            echo '<img src="data:image/jpeg;base64,' . $image_base64 . '" alt="Product Image" class="current-image">';
        }
        ?>
    </div>
</div>

<div class="form-control">
<label for="image">Image:</label><br>
        <input type="file" name="image" id="image">
</div>




        <div class="form-control">
        <button type="submit">Update</button>
</div>
      </form>
    </div>
 
  </body>
</html>
