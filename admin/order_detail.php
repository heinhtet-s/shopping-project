<?php
require '../config/config.php';
session_start();
require '../config/common.php';
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header('Location: login.php');

}
if($_SESSION['role']!=1){
  header('Location: login.php');
}
$id=$_GET['id'];
if(!empty($_GET['pageno'])){
  $pageno=$_GET['pageno'];
}else{
  $pageno=1;

}
$numOfrecs=3;
$offset=($pageno-1)*$numOfrecs;

 

 $stmt=$pdo->prepare("SELECT * FROM sale_order_detail WHERE sale_orders_id=:id");
 $stmt->execute(["id"=>$id]);
 $rawuser=$stmt->fetchAll();
 
$total_pages=ceil(count($rawuser)/$numOfrecs);

$stmt= $pdo->prepare("SELECT * FROM sale_order_detail WHERE sale_orders_id=:id  LIMIT $offset,$numOfrecs ");
$stmt->execute(["id"=>$id]);
$detail=$stmt->fetchAll();
           

 
 



//



            
            
          
?>
<?php include('header.php');?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> Order detail </h3>
              </div>
           
              <!-- /.card-header -->
              <div class="card-body">
              <a href="order_list.php" class="btn btn-success">Back </a>
                <div><br></div>
                
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                        <th>No</th>
                      <th >Product</th>
                      <th>quantity</th>
                      <th>date</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                   <?php 
                   $i=0;

                   foreach($detail as $d){ 
                           $i++;
                     $stmt= $pdo->prepare("SELECT * FROM  products WHERE id=:id ");
                     $stmt->execute([":id"=>$d['product_id']],);
                     $product=$stmt->fetchAll();
               
                     
                     ?>
                    <tr>
                          <td><?php echo $i; ?></td>
                      
                     
                     
                      
                    <td><?php echo  escape($product[0]['name']);?></td>
                    <td><?php echo escape($d['quantity']); ?></td>
                    <td><?php echo date("Y-m-d",strtotime($d['order_date'])); ?></td>
                      
                    </tr>
                  
                          <?php } ?>         
                   
                  </tbody>
                </table>
              </div>
              <div >
              <nav aria-label="Page navigation example " style="float: right!important; margin-right: 70px;" >
              <ul class="pagination">
  <li class="page-item"><a class="page-link" href="?pageno=1&id=<?php echo $id; ?>">First</a></li>
    <li class="page-item <?php if($pageno <= 1){echo 'disabled';}?>">
    <a class="page-link"    href="?id=<?php echo $id; ?>&<?php if($pageno <= 1){echo '#';}
    else{echo 'pageno='.($pageno-1);} ?>">Previous</a>    </li>
    <li class="page-item"><a class="page-link" href="?id=<?php echo $id; ?>&pageno=<?php echo $pageno ?>"><?php echo $pageno ?></a></li>
    
    <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';} ?>" >
    <a class="page-link"    href="?id=<?php echo $id; ?>&<?php if($pageno >=  $total_pages){echo '#';}else{echo 'pageno='.($pageno+1);} ?>">Next</a>    </li>

    <li class="page-item"><a class="page-link" href="?id=<?php echo $id; ?>&pageno=<?php echo $total_pages?>">Last</a></li>
  </ul>
</nav>
            
  </ul>
</nav>
                   
          </div>
            </div>
            <!-- /.card -->

           
            <!-- /.card -->
          </div>
         
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <?php include('footer.html');?>