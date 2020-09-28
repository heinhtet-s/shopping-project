<?php
include 'header.php' ;

if(session_status()== PHP_SESSION_NONE){
	session_start();
}
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
    header('Location: login.php');
  }
require 'config/config.php';

require 'config/common.php';

?>

    <!-- End Banner Area -->

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <?php if(!empty($_SESSION['cart'])){
                
                ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                            
                        </thead>
                        <tbody>
                            <?php
                            $total=0;
                            foreach ($_SESSION['cart'] as $key => $qty) {
                            $id=str_replace('id','',$key);
                            $pdos=$pdo->prepare("SELECT * FROM products WHERE id=:id");
                            $pdos->execute([":id"=>$id]);
                            $result=$pdos->fetch(PDO::FETCH_ASSOC);
                            $total+=$result['price']*$qty;
                            
                            ?>
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="image/<?php echo $result['image']; ?>" width="200"  alt="">
                                        </div>
                                        <div class="media-body">
                                            <p><?php echo escape($result['name']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo escape($result['price']); ?></h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                    <input type="text" value="<?php echo escape($qty); ?>" class="input-text qty" readonly>
                                
                                          
                                           
                                    </div>
                                </td>
                                <td>
                                  
                                    <h5><?php echo $result['price']*$qty ; ?></h5>
                                </td>
                                <td><a class="primary-btn" style=" line-height: 35px;width: 100px;" href="cart_item_clear.php?p_id=<?php echo $result['id']?>" >Clear</a></td>
                            </tr>
                            <?php } ?>
                         
                                </td>
                                <td></td>
                                <td >
                                
                                    <h5 >Subtotal</h5>
                                </td>
                                <td></td>
                                <td>
                                    <h5><?php echo $total ?></h5>
                                </td>
                            </tr>
                            
                            <tr class="out_button_area">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">
                                        <a class="gray_btn" href="index.php">Continue Shopping</a>
                                        <a class="primary-btn" href="sale_order.php">Order submit</a>
                                        <a class="gray_btn" href="clear_all.php">Clear all </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php }; ?>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

    <!-- start footer Area -->
    <?php include "footer.php"; ?>