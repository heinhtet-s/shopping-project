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
                <h3 class="card-title"> Order listing </h3>
              </div>
             <?php
        
             if(!empty($_GET['pageno'])){
              $pageno=$_GET['pageno'];
            }else{
              $pageno=1;

            }
            $numOfrecs=4;
            $offset=($pageno-1)*$numOfrecs;
            
             

             $stmt=$pdo->prepare("SELECT user_id,SUM(total_price) FROM  sale_orders GROUP BY user_id HAVING SUM(total_price)>50000");
             $stmt->execute();
             $rawuser=$stmt->fetchAll();
            $total_pages=ceil(count($rawuser)/$numOfrecs);

            $stmt= $pdo->prepare("SELECT user_id 'id',SUM(total_price)'SUM' FROM sale_orders GROUP BY user_id HAVING SUM(total_price)>50000 LIMIT $offset,$numOfrecs   ");
            $stmt->execute();
            $order=$stmt->fetchAll();
           
             ?>
              <!-- /.card-header -->
              <div class="card-body">
               
                <p>These are best Royal members who had bought  more than 50000 kyats</p>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                        <th>No</th>
                      <th >user Name </th>
                      <th>Total Amount</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($order){
                      $i=1;
                      foreach($order as $o){
                       
                    ?>
                    <tr>

                      <td><?php echo $i; ?></td>
                     
                      <?php
                      $pdostatement=$pdo->prepare("SELECT * FROM users WHERE id=:id");

                      $pdostatement->execute([":id"=>$o['id']]);
                      $user=$pdostatement->fetchAll();
                     
                      ?>
                    <td><?php echo  escape($user[0]['name']);?></td>
                    <td><?php echo escape($o['SUM']);?></td>
                    </tr>
                  
                      <?php $i++;
                     }
                     
                     } ?>                 
                   
                  </tbody>
                </table>
              </div>
              <div style="float: right">
           
              <!-- /.card-body -->
       
            <nav aria-label="Page navigation example" style ="float: right;">
  <ul class="pagination">
  <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
    <li class="page-item <?php if($pageno <= 1){echo 'disabled';}?>">
    <a class="page-link"    href="<?php if($pageno <= 1){echo '#';}
    else{echo '?pageno='.($pageno-1);} ?>">Previous</a>    </li>
    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $pageno ?>"><?php echo $pageno ?></a></li>
    
    <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';} ?>" >
    <a class="page-link"    href="<?php if($pageno >=  $total_pages){echo '#';}else{echo '?pageno='.($pageno+1);} ?>">Next</a>    </li>

    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages?>">Last</a></li>
  </ul>
</nav>
           
  </ul>
</nav></div>
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