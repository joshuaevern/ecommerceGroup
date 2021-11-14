<?php
    require('../Controllers/cart_controller.php');
    require('../Settings/core.php');

    //if ip is from share internet
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $IP_address = $_SERVER['HTTP_CLIENT_IP'];
      //echo $IP_address;

    //if ip is from proxy
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $IP_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
      //echo $IP_address;

    //ip from remote address
    }else{

      $IP_address = $_SERVER['REMOTE_ADDR'];
      //echo $IP_address;
    }

   
    if(isset($_POST['add_to_cart'])){
      $productID = $_POST['id'];
      $customerID = $_SESSION['user_id'];
      $qty = $_POST['qty'];
      echo $productID, $customerID,$qty, $IP_address;

      //echo $productID;
      $productExist = select_one_cart_product_controller($productID,$customerID);
      //var_dump($productExist);

      $qty = $_POST['qty'] ? : 1;

     
       
      if ($productExist){

        $newquantity = $productExist['qty'] + $qty;
        echo $newquantity;
       
        $updatequantity = update_quantity_controller($productID,$customerID,$newquantity);

        if ($updatequantity){
          header('Location: ../View/cart.php');

        }else{
          echo 'failed';
        }

      } else{
            $productDetails = add_to_cart_controller($productID,$IP_address,$customerID,$qty);
            //var_dump($productDetails);
            if ($productDetails ==true){
              echo '<script>alert("Product added to cart successfully");
                    window.location ="../View/all_product.php";
                  </script>';
            }else{
              echo '<script>alert("Failed to add product! Try again.");
                    window.location ="../View/single_product.php";
                    </script>';
          }

        }
     
     

   
     
   
   
    }
   
?>