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
?>
<?php include('header.php');?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> Weekly report </h3>
              </div>
             <?php
               $current_date=date('Y-m-d');
               $from_date=date('Y-m-d',strtotime($current_date.'+1 day'));
               $to_date=date('Y-m-d',strtotime($current_date.'-7 day'));
               $pdos=$pdo->prepare("SELECT * FROM sale_orders WHERE order_date<:from_date AND order_date>:to_date");
               $pdos->execute([':from_date'=>$from_date,
                    ':to_date'=>$to_date,     ]);
                    $result=$pdos->fetchAll();
                   
             ?>
              <!-- /.card-header -->
              <div class="card-body">
               
                <div><br></div>
                <table id="tables" class="table table-bordered" >
                  <thead>                  
                    <tr>
                      <th >No</th>
                      <th>User id</th>
                      <th>Total price</th>
                      <th >Order date</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($result){
                      $i=1;
                      foreach($result as $u){
                       
                    ?>
                    <tr>

                      <td><?php echo $i; ?></td>
                      <?php
 $pdos=$pdo->prepare("SELECT * FROM users WHERE id=:id");
 $pdos->execute([':id'=>$u['user_id'],
           ]);
      $user=$pdos->fetchAll();
     

                      ?>

                      <td><?php echo escape($user[0]['name']); ?></td>
                   
                    
                      <td><?php echo escape($u['total_price'])?></td>
                      <td><?php echo escape(date('Y-m-d',strtotime($u['order_date'])))?></td>
                      
                      
                    </tr>
                  
                      <?php $i++;
                     }
                     
                     } ?>                 
                   
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

  <script>
  $(document).ready(function() {
    $('#tables').DataTable();
  }); </script> 
