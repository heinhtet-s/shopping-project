
<?php include('header.php');

require 'config/config.php';

require 'config/common.php';
$id=$_GET['id'];
$pdostatement=$pdo->prepare("SELECT * FROM products WHERE id=:id ");
$pdostatement->execute([':id'=>$id]);
$result=$pdostatement->fetch(PDO::FETCH_ASSOC);
$pdostatement=$pdo->prepare("SELECT * FROM categories WHERE id=:id");
$pdostatement->execute([':id'=>$result['category_id']]);
$cat=$pdostatement->fetch(PDO::FETCH_ASSOC);

 


?>


<div class="product_image_area" style="padding: 0px !important;">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					
					
						
							<img class="img-fluid" src="image/<?php echo $result['image']; ?>" alt="" width="400" style="height: auto;">
						
					</div>
				

				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3><?php echo $result['name']; ?></h3>
						<h2><?php echo $result['price']; ?></h2>
						<ul class="list">
							<li><a class="active" href="#"><span>Category</span> : <?php echo $cat["name"]; ?></a></li>
							<li><a href="#"><span>Availibility</span> : In Stock</a></li>
						</ul>
						<p>Mill Oil is an innovative oil filled radiator with the most modern technology. If you are looking for
							something that can make your interior look awesome, and at the same time give you the pleasant warm feeling
							during the winter.</p>
							<form action="Addtocart.php" method="post">
							<input type="hidden" name="id" value="<?php echo $result['id'];?>">
						<div class="product_count">
							<label for="qty">Quantity:</label>
							<input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
							<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
							 class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
							<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
							 class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
						</div>
						<div class="card_area d-flex align-items-center">
					   <input type="submit" value="Add to cart" style="border: none;"class="primary-btn text-white">
							<a class="primary-btn text-white" herf="index.php">Back</a>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div></div></div></div><br>
	<!--================End Single Product Area =================-->

	
	






<?php include('footer.php');?>