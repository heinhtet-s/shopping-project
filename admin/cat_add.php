<?php
session_start();
require '../config/config.php';
require '../config/common.php';

if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header('Location: login.php');
}if($_SESSION['role']!=1){
  header('Location: login.php');
}
if($_POST){
  
  if(empty($_POST['name']) || empty($_POST['description'])){

if(empty($_POST['name'])){
$name_error="Name field cannot be null";
}
if(empty($POST['description'])){
$description_error="description field cannot be null";

}

  }else{
      $name=$_POST['name'];
      $desc=$_POST['description'];
    
      $pdostatement=$pdo->prepare("INSERT INTO categories(name,description) VALUES(:name,:description)");
      $result=$pdostatement->execute([
        ":name"=>$name,
        ":description"=>$desc,
        
      ]);
     
   if($result){
echo "<script>alert('successfully added');</script>";
echo "<script>window.location.href = 'category.php'</script>;";

   }
    
  }

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
                <h3 class="card-title">Create New Category</h3>
              </div>
            
              <!-- /.card-header -->
 <div class="card-body">
           <form action="" enctype="multipart/form-data" method="post">
           <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>">
         <div class="form-group">
             <label for="">name</label><p class="text-danger"><?php echo empty($name_error)? '':  $name_error; ?></p>
      <input type="text" name="name" class="form-control" id="">

         </div>

         <div class="form-group">
             <label for="">description</label><p class="text-danger"><?php echo empty($description_error)? '':  $description_error; ?></p>
    <textarea name="description" id="" cols="30" rows="5" class="form-control"></textarea>

         </div>

         <div class="form-group">
             <input type="submit" value="Create" class="btn btn-info">
          <a href="category.php" class="btn btn-success">back</a>
         </div>
</form>
         

           </div>
              <!-- /.card-body -->
            
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