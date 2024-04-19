<?php
  session_start();
  require_once ('mysqli_connect.php');
  if(!isset($_SESSION['userID'])){
      header('Location: login.php');
  }


?>
<?php

if(isset($_POST['productID']) && isset($_POST['quantity'])) {
   $productID = $_POST['productID'];
   $userID = $_SESSION['userID'];
   $newQuantity = $_POST['quantity'];

   // Update the quantity in the cart
   $update_query = "UPDATE cart SET quantity = $newQuantity WHERE userID = '$userID' AND productID = '$productID'";
   $update_result = mysqli_query($dbc, $update_query);

   if($update_result) {
       echo "Quantity updated successfully";
   } else {
       echo "Error updating quantity: " . mysqli_error($dbc);
   }
} else {
}


if(isset($_POST['delete_product'])) {
    $productID = $_POST['delete_product'];
    $userID = "chuah0909";

    // Delete the product from the cart
    $delete_query = "DELETE FROM cart WHERE userID = '$userID' AND productID = '$productID'";
    $delete_result = mysqli_query($dbc, $delete_query);

    if($delete_result) {
        $message = "Product deleted successfully from the cart.";
    } else {
        $error = "Error deleting product from the cart: " . mysqli_error($dbc);
    }
}

// Your code for displaying the cart and other functionalities goes here
?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Cart</title>
   <style>
    body{
  background-image: url('bck.jpg');
  background-size:cover;
}
    table {
  border: 1px solid;
  text-align: center;
  width: 70%;  
 
  margin-left: auto;
  margin-right: auto;
}
#picture{
   width:100px;
   height:100px;
}
th{
 
  text-align: center;
  height: 70px;
  padding: 15px;
}

table,th,td,tr{
    border:none;
}

tr{
    border: 1px solid;
}
td{
  
  text-align: center;
  padding: 15px;
}
#h1{
  text-align: center;
  font-family: Arial, Helvetica, sans-serif;
  text-decoration:underline;
  margin:1% 0% 1% 0%;
  font-size:50px;
}
.delete{
  padding: 5px;
  text-align: center;
  margin-bottom: 25px;
}

.del{
  background-color: rgb(119, 255, 0);
  padding: 15px 30px 15px 30px;
  border-radius: 30px;
  margin-top :1%;
  
}
.del:hover{
  filter: brightness(1.2);
  

}
#id1{
  color:blueviolet;
  margin-left:10px;
  font-family: Arial, Helvetica, sans-serif;
  font-size: larger;

}
#id1:hover{
  text-decoration:underline;
  color:black;
}

#id2{
  color:blueviolet;
  margin-left:10px;
  font-family: Arial, Helvetica, sans-serif;
  font-size: larger;
}
#id2:hover{
  text-decoration:underline;
  color:black;
}

p1{
  margin-left:20px;
  border-style:none;
  background-color:bisque;
  padding: 10px 20px 10px 20px;
  border-radius: 30px;
}

.delete-button {
    background-color: #ff5555; /* Red background color */
    color: white; /* Text color */
    padding: 10px 20px; /* Padding around the button text */
    border: none; /* Remove border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Show pointer cursor on hover */
    transition: background-color 0.3s; /* Smooth transition for background color change */
}

.delete-button:hover {
    background-color: #cc0000; /* Darker red background color on hover */
}


.total-price-container {
  text-align: right;
  margin-right: 20px;
}

.total-price-container label {
  font-weight: bold;
}

.quantity-container {
    display: flex;
    align-items: center;
}

.quantity-input {
    width: 50px;
}

.quantity-buttons button {
    padding: 5px 10px;
    margin-left: 5px;
    border: none;
    cursor: pointer;
}

.quantity-buttons button:hover {
    background-color: #ddd;
}

.checkout {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 5px;
}

.checkout:hover {
    background-color: #45a049; /* Darker green */
}




    </style>
    <script>
$(document).ready(function() {
    $('.quantity-input').on('change', function() {
        var productID = $(this).data('product-id');
        var newQuantity = $(this).val();
        $.ajax({
            url: 'cart.php',
            type: 'POST',
            data: { productID: productID, quantity: newQuantity },
            success: function(response) {
                // Handle success, such as displaying a success message
                console.log('Quantity updated successfully');
            },
            error: function(xhr, status, error) {
                // Handle error, such as displaying an error message
                console.error('Error updating quantity: ' + error);
            }
        });
    });
});

$(document).ready(function() {
    // Function to calculate total price
    function calculateTotalPrice() {
      var totalPrice = 0;
      // Iterate over each checked checkbox
      $('input[name="checked[]"]:checked').each(function() {
        // Get the quantity and price of the product
        var quantity = parseInt($(this).closest('tr').find('.quantity-input').val());
        var price = parseFloat($(this).closest('tr').find('td:nth-child(4)').text().replace('RM ', ''));
        // Calculate subtotal and add it to the total price
        totalPrice += (quantity * price);
      });
      // Display the total price in the fixed textbox
      $('#total-price').val('RM ' + totalPrice.toFixed(2));
    }

    // Call the function initially
    calculateTotalPrice();

    // Listen for changes in quantity input fields
    $('.quantity-input').on('change', function() {
      calculateTotalPrice(); // Recalculate total price
    });

    // Listen for changes in checked checkboxes
    $('input[name="checked[]"]').on('change', function() {
      calculateTotalPrice(); // Recalculate total price
    });
  });

  $(document).ready(function() {
    $('.quantity-input').on('change', function() {
        var newValue = parseInt($(this).val());
        var maxValue = parseInt($(this).attr('max'));

        if (newValue > maxValue) {
            $(this).val(maxValue);
        }
        // You can add AJAX call here to update the quantity in the database
    });

    $('.quantity-increase').on('click', function() {
        var inputField = $(this).parent().prev('.quantity-input');
        var currentValue = parseInt(inputField.val());
        var maxValue = parseInt(inputField.attr('max'));

        if (isNaN(currentValue)) {
            currentValue = 0;
        }

        if (currentValue < maxValue) {
            inputField.val(currentValue + 1).trigger('change');
        }
    });

    $('.quantity-decrease').on('click', function() {
        var inputField = $(this).parent().prev('.quantity-input');
        var currentValue = parseInt(inputField.val());

        if (isNaN(currentValue)) {
            currentValue = 0;
        }

        if (currentValue > 1) {
            inputField.val(currentValue - 1).trigger('change');
        }
    });
});

$(document).ready(function() {
    // Function to handle delete button click
    $('.delete-button').on('click', function() {
        var productID = $(this).data('product-id');
        if (confirm('Are you sure you want to delete this product?')) {
            $.ajax({
                url: 'cart.php',
                type: 'POST',
                data: { delete_product: productID },
                success: function(response) {
                    // Reload the page after successful deletion
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error, such as displaying an error message
                    console.error('Error deleting product: ' + error);
                }
            });
        }
    });
});


      </script>
  </head>
  <body>
  <?php include("header2.php"); ?>
    <form action="order.php" method="Post">
        <h1 id="h1">Cart</h1>
       
        <div class="myDiv">
            <table border="1" cellpadding="15" cellspacing="0">
                <tr>
                    <th>&nbsp;</th>
                    <th></th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>

                <?php
                $userID = $_SESSION['userID'];
                $q = "SELECT cart.*, product.*, product.maxquantity
                      FROM cart
                      INNER JOIN product ON cart.productID = product.productID
                      WHERE cart.userID = '$userID'";
                $r = mysqli_query($dbc, $q);
                $num = mysqli_num_rows($r);

                if ($num > 0) {
                  while ($row = mysqli_fetch_array($r)) {
                      printf('
                          <tr>
                              <td><input type="checkbox" name="checked[]" value="%s"/></td>
                              <td><img src="data:image/jpeg;base64,%s" id="picture"/></td>
                              <td>%s</td>
                              <td>RM %s</td>
                              <td>
    <div class="quantity-container">
        <input type="number" name="quantity" value="%s" min="1" max="%s" class="quantity-input" data-product-id="%s" readonly>
        <div class="quantity-buttons">
        <button type="button" class="quantity-decrease">-</button>
            <button type="button" class="quantity-increase">+</button>
        </div>
    </div>
</td>

                              <td align="center">
                              <button class="delete-button" data-product-id="%s">Delete</button>
                              </td>
                          </tr>',
                          $row['productID'],
                          base64_encode($row['image']),
                          $row['proName'],
                          $row['proPrice'],
                          $row['quantity'],
                          $row['maxquantity'],
                          $row['productID'],
                          $row['productID']
                      );
                  }
              }

             

                mysqli_free_result($r);
                mysqli_close($dbc);
                ?>
                <tr>
                  <td colspan="8"><div class="total-price-container"><label>Total Price  :  </label><input type="text" id="total-price" readonly> </div></td>
            </tr>
            <tr>
    <td colspan="8">
        <div class="checkout-container">
            <input type="submit" name="checkout" value="Checkout" class="checkout"/>
        </div>
    </td>
</tr>
            </table>
           
        </div>
    </form>
    <?php include("footer.php"); ?>
</body>
</html>