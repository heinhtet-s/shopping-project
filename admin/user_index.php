<?php
require '../config/config.php';
session_start();
require '../config/common.php';
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header('Location: login.php');

}if($_SESSION['role']!=1){
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
                <h3 class="card-title"> Blog listings</h3>
              </div>
             <?php
         
             if(!empty($_GET['pageno'])){
              $pageno=$_GET['pageno'];
            }else{
              $pageno=1;

            }
            $numOfrecs=4;
            $offset=($pageno-1)*$numOfrecs;
            if(empty($_GET['search'] )){
             

             $stmt=$pdo->prepare("SELECT * FROM users ORDER BY id DESC");
             $stmt->execute();
             $rawuser=$stmt->fetchAll();
            $total_pages=ceil(count($rawuser)/$numOfrecs);

            $stmt= $pdo->prepare("SELECT * FROM  users ORDER BY id DESC LIMIT $offset,$numOfrecs ");
            $stmt->execute();
            $user=$stmt->fetchAll();}
            else{
           $searchkey=$_GET['search'];
           $stmt=$pdo->prepare("SELECT * FROM users WHERE name LIKE '%$searchkey%' ");
             $stmt->execute();
             $rawuser=$stmt->fetchAll();
             
             
             $total_pages=ceil(count($rawuser)/$numOfrecs);
             $stmt= $pdo->prepare("SELECT * FROM  users WHERE name LIKE '%$searchkey%' ORDER BY id DESC LIMIT $offset,$numOfrecs ");
             $stmt->execute();
             $user=$stmt->fetchAll();
           
             

            }
             ?>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="user_add.php" class="btn btn-success">Create New User</a>
                <div><br></div>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th >id</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th >Role</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($user){
                      $i=1;
                      foreach($user as $u){
                       
                    ?>
                    <tr>

                      <td><?php echo $i; ?></td>
                      <td><?php echo escape($u['name']); ?></td>
                      
                    <td><?php echo escape($u['email']); ?></td>
                    <td><?php if($u['role']==1){echo "Admin";}else{echo "User";}?></td>
                      
                      <td>
                
                    
                      <a href="user_edit.php?id=<?php echo$u['id']; ?>" class="btn btn-warning">edit</a>
                  
                    
                      <a href="user_delete.php?id=<?php echo $u['id']; ?>"  onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-warning">delete</a>
                    
                       
                      </td>
                    </tr>
                  
                      <?php $i++;
                     }
                     
                     } ?>                 
                   
                  </tbody>
                </table>
              </div>
              <div style="float: right">
            <?php  if(!empty($searchkey)){ ?>
              <!-- /.card-body -->
              <nav aria-label="Page navigation example" >
  <ul class="pagination">
  <li class="page-item"><a class="page-link" href="?search=<?php echo $searchkey.'&'?>pageno=1">First</a></li>
    <li class="page-item <?php if($pageno <= 1){echo 'disabled';}?>">
    <a class="page-link"    href="<?php if($pageno <= 1){echo '#';}else{echo '?search='.$searchkey.'&pageno='.($pageno-1);} ?>">Previous</a>    </li>
    <li class="page-item"><a class="page-link" href="?search=<?php echo $searchkey.'&pageno='.$pageno ?>"><?php echo $pageno ?></a></li>
    
    <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';} ?>" >
    <a class="page-link"    href="<?php if($pageno >=  $total_pages){echo '#';}else{echo '?search='.$searchkey.'&pageno='.($pageno+1);} ?>">Next</a>    </li>

    <li class="page-item"><a class="page-link" href="?search=<?php echo $searchkey.'&pageno='.$total_pages?>">Last</a></li>
            <?php }else{ ?>
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
            <?php } ?>
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