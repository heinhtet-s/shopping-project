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
$stmt=$pdo->prepare("SELECT * FROM sale_order_detail WHERE sale_orders_id=:id");
             $stmt->execute(["id"=>$id]);
             $detail=$stmt->fetchAll();
           

            $stmt= $pdo->prepare("SELECT * FROM  products WHERE id=:id ");
            $stmt->execute([":id"=>$detail[0]['product_id']],);
            $product=$stmt->fetchAll();
            
          
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
                   
                    <tr>
                          <td>1</td>
                      
                     
                     
                      
                    <td><?php echo  escape($product[0]['name']);?></td>
                    <td><?php echo escape($detail[0]['quantity']); ?></td>
                    <td><?php echo date("Y-m-d",strtotime($detail[0]['order_date'])); ?></td>
                      
                    </tr>
                  
                                
                   
                  </tbody>
                </table>
              </div>
              <div style="float: right">
            
              <!-- /.card-body -->
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