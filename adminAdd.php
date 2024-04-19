<?php
session_start();
require_once ('mysqli_connect.php');
if(!isset($_SESSION['adminID'])){
    header('Location: adminLogin.php');
  }
  

$name = "";
$price = "";
$quantity = "";
$description = "";
$image_name = "";
$image_type = "";
$image_size = "";
$image_data = "";
$error = array();
?>

<?php


// Function to generate a product ID
function generateProductID($dbc, $prefix = 'P', $digits = 5) {
    // Query the database to find the highest existing product ID
    $highest_id_query = "SELECT MAX(RIGHT(productID, $digits)) AS max_id FROM product";
    $result = mysqli_query($dbc, $highest_id_query);
    $row = mysqli_fetch_assoc($result);
    $max_id = $row['max_id'];
    
    // If no existing product ID, start from 1
    $next_id = ($max_id === null) ? 1 : ($max_id + 1);
    
    // Format the number part with leading zeros
    $number_part = str_pad($next_id, $digits, '0', STR_PAD_LEFT);
    
    return $prefix . $number_part;
}





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

        
     
        if ($image_data == null) {
            $error['image_url'] = "Please select your product picture.";
        }


        
  if (empty($error)) {
    $product_id = generateProductID($dbc);

    $q1 = "INSERT INTO product (productID,proName,proPrice,proDesc,quantity,image,imageName) VALUES  (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($dbc, $q1);
    mysqli_stmt_bind_param($stmt, "sssssss", $product_id, $name, $price, $description, $quantity, $image_data, $image_name);
    mysqli_stmt_execute($stmt);
    
   header("Location: adminProduct.php?error=The product has been added successfully.");
        exit();
    
  }


}
?>


<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Product</title>
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

    
   </style>
  </head>

  <body>

    <div class="container">
    <h1 style="text-align:center">Add new product</h>
      <form action="adminAdd.php" method="post" enctype="multipart/form-data">

      
      <div class="form-control">
    <label for="name">Product Name:</label>
    <input type="text" id="name" class="form-control" placeholder="Enter product name" name="name" value="<?php echo $name; ?>">
    <?php if(isset($error['name'])): ?>
        <span class="error"><?php echo $error['name']; ?></span>
    <?php endif; ?>
</div>

<div class="form-control">
    <label for="price">Product Price:</label>
    <input type="text" id="price" class="form-control" placeholder="Enter product price" name="price" value="<?php echo $price; ?>">
    <?php if(isset($error['price'])): ?>
        <span class="error"><?php echo $error['price']; ?></span>
    <?php endif; ?>
</div>

<div class="form-control">
    <label for="quantity">Product Quantity:</label>
    <input type="text" id="quantity" class="form-control" placeholder="Enter product quantity" name="quantity" value="<?php echo $quantity; ?>">
    <?php if(isset($error['quantity'])): ?>
        <span class="error"><?php echo $error['quantity']; ?></span>
    <?php endif; ?>
</div>

<div class="form-control">
    <label for="detail">Product Description:</label><br>
    <textarea rows="2" cols="50" name="description" id="detail" class="form-control" placeholder="Enter details here..."><?php echo $description; ?></textarea>
    <?php if(isset($error['description'])): ?>
        <span class="error"><?php echo $error['description']; ?></span>
    <?php endif; ?>
</div>

<div class="form-control">
    <label for="image">Image:</label><br>
    <input type="file" name="image" id="image">
    <?php if(isset($error['image_url'])): ?>
        <span class="error"><?php echo $error['image_url']; ?></span>
    <?php endif; ?>
</div>


        <div class="form-control">
        <button type="submit">Submit</button>
</div>
      </form>
    </div>


  </body>
</html>
