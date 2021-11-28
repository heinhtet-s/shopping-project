

<?php
include 'header.php' ;
if(session_status()== PHP_SESSION_NONE){
	session_start();
}
require 'config/config.php';

require 'config/common.php';
if(!empty($_GET['pageno'])){
	$pageno=$_GET['pageno'];
  }else{
	$pageno=1;

  }
  $numOfrecs=2;
  $offset=($pageno-1)*$numOfrecs;
  
  if(empty($_GET['search'] )){
	if(!empty($_GET['c_id'])){
		$c_id=$_GET['c_id'];
		$stmt=$pdo->prepare("SELECT * FROM products WHERE category_id=:id AND  quantity>0 ");
		$stmt->execute([':id'=>$c_id]);
		$rawuser=$stmt->fetchAll();
		
		$total_pages=ceil(count($rawuser)/$numOfrecs);
		$stmt=$pdo->prepare("SELECT * FROM products WHERE category_id=:id AND quantity>0 LIMIT $offset,$numOfrecs");
		$stmt->execute([':id'=>$c_id]);
		$user=$stmt->fetchAll();
		
		}else{
	 
	   

   $stmt=$pdo->prepare("SELECT * FROM products WHERE quantity>0 ORDER BY id DESC");
   $stmt->execute();
   $rawuser=$stmt->fetchAll();
  $total_pages=ceil(count($rawuser)/$numOfrecs);

  $stmt= $pdo->prepare("SELECT * FROM  products WHERE quantity>0 ORDER BY id DESC LIMIT $offset,$numOfrecs ");
  $stmt->execute();
  $user=$stmt->fetchAll();
		}
}
  else{
 $searchkey=$_GET['search'];
 $stmt=$pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchkey%' AND  quantity>0 ");
   $stmt->execute();
   $rawuser=$stmt->fetchAll();

   
   $total_pages=ceil(count($rawuser)/$numOfrecs);
   $stmt= $pdo->prepare("SELECT * FROM  products WHERE name LIKE '%$searchkey%' AND quantity>0 ORDER BY id DESC LIMIT $offset,$numOfrecs ");
   $stmt->execute();
   $user=$stmt->fetchAll();
   
   

  }
?> 


    <!-- End Banner


                  <!-- Start Filter Bar -->
				  <div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<div class="sidebar-categories">
					<div class="head">Browse Categories</div>
					<ul class="main-categories">
						<li class="main-nav-list">
							<?php 
							$cat=$pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
							$cat->execute();
							$cat=$cat->fetchAll();
							?>
							<?php foreach($cat as $c){ ?>
						<a href="?c_id=<?php echo $c['id']; ?>"><?php echo escape($c['name']);?></a>
							<?php } ?>
						</li>

						
					</ul>
				</div>
			
			</div>
			<div class="col-xl-9 col-lg-8 col-md-7">
				<!-- Start Filter Bar -->
				<div class="filter-bar d-flex flex-wrap align-items-center">
					<div class="pagination">
						<?php if(!empty($searchkey)) { ?>
						<a href="?search=<?php echo $searchkey.'&'?>pageno=1" class="active">First</a>
						<a href="<?php if($pageno <= 1){echo '#';}else{echo '?search='.$searchkey.'&pageno='.($pageno-1);} ?>"  class="prev-arrow <?php if($pageno <= 1){echo 'disabled';}?>"><i class="fa fa-long-arrow-left  aria-hidden="true"></i></a>
						<a href="?search=<?php echo $searchkey.'&pageno='.$pageno ?>" class="active"><?php echo $pageno ?></a>
						
						
						
						<a href="<?php if($pageno >=  $total_pages){echo '#';}else{echo '?search='.$searchkey.'&pageno='.($pageno+1);} ?>" class="<?php if($pageno >= $total_pages){echo 'disabled';} ?>" next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
						<a href="?search=<?php echo $searchkey.'&pageno='.$total_pages?>" class="active">Last</a>
						<?php }elseif( !empty($c_id)){?>
							<a href="?c_id=<?php echo $c_id.'&'?>pageno=1" class="active">First</a>
						<a href="<?php if($pageno <= 1){echo '#';}else{echo '?c_id='.$c_id.'&pageno='.($pageno-1);} ?>"  class="prev-arrow <?php if($pageno <= 1){echo 'disabled';}?>"><i class="fa fa-long-arrow-left  aria-hidden="true"></i></a>
						<a href="?c_id=<?php echo $c_id.'&pageno='.$pageno ?>" class="active"><?php echo $pageno ?></a>
						
						
						
						<a href="<?php if($pageno >=  $total_pages){echo '#';}else{echo '?c_id='.$c_id.'&pageno='.($pageno+1);} ?>" class="<?php if($pageno >= $total_pages){echo 'disabled';} ?>" next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
						<a href="?c_id=<?php echo $c_id.'&pageno='.$total_pages?>" class="active">Last</a>

						<?php }else{?>
							<a href="?pageno=1" class="active">First</a>
						<a href="<?php if($pageno <= 1){echo '#';} else{echo '?pageno='.($pageno-1);} ?>"  class="prev-arrow <?php if($pageno <= 1){echo 'disabled';}?>"><i class="fa fa-long-arrow-left " aria-hidden="true"></i></a>
						<a href="?pageno=<?php echo $pageno ?>"class="active"><?php echo $pageno ?></a>
						
						
						
						<a href="<?php if($pageno >=  $total_pages){echo '#';}else{echo '?pageno='.($pageno+1);} ?>"class="<?php if($pageno >= $total_pages){echo 'disabled';} ?>" next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
						<a href="?pageno=<?php echo $total_pages?>" class="active">Last</a>
						<?php  } ?>
	 				</div>
					
				
				</div>
				<!-- End Filter Bar -->
				<!-- Start Best Seller -->
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
						<?php if($user){
							foreach( $user as $r){
							?>
						<!-- single product -->
						<div class="col-lg-4 col-md-6">
							<div class="single-product">
								<a href="product_detail.php?id=<?php echo $r['id']?>"><img class="img-fluid" style="width:auto; height:200px;" src="image/<?php echo escape($r['image']); ?>" alt=""></a>
								<div class="product-details">
									<h6><?php echo escape($r['name']); ?></h6>
									<div class="price">
										<h6>Price</h6>
										<h6 class="l-through"><?php echo escape($r['price']);  ?></h6>
									</div>
									<div class="prd-bottom">
									
                                        <form action="Addtocart.php" method="post" style="display: inline-block;" >
										<input type="hidden" name="id" value="<?php echo $r['id']?>">
										<input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>">
										<input type="hidden" name="qty" value="1">
										<div class="social-info" >
											
								                <button type="submit"  class="social-info" style="display: contents;" >
												<span class="ti-bag"></span>
												<p class="hover-text" style="width: 78px;">add to bag</p>
												</button>
											
											
										</div>
										</form>
										<a href="product_detail.php?id=<?php echo $r['id']?>" class="social-info">
											<span class="lnr lnr-move"></span>
											<p class="hover-text">view more</p>
										</a>
									</div>
								</div>
							</div>
						</div>
						<?php } 
						   
						   } ?>
					</div>
				</section>
				<!-- End Best Seller -->
				<!-- Start Filter Bar -->
				
			</div>
		</div>
	</div>

	

	<!-- start footer Area -->
	<?php include('footer.php'); ?>