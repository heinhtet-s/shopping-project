
<?php
require '../config/config.php';
session_start();
require '../config/common.php';
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header('Location: login.php');

}if($_SESSION['role']!=1){
  header('Location: login.php');
}
if(!empty($_GET['id'])){

$pdostatement=$pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
$pdostatement->execute();
$res=$pdostatement->fetch(PDO::FETCH_ASSOC);}

if($_POST){
  if(empty($_POST['name']) ||empty($_POST['email'])  ){
    if(empty($_POST['name'])){
      $name_error='name cannot be null';
      
    }
   if(empty($_POST['email'])){
     $email_error='email cannot be null';
   }
  
     }elseif(!empty($_POST['password']) && strlen($_POST['password']) <4  ){
    $password_error='Password should be 4 characters at least';
  }
  else{
    if(empty($_POST['isAdmin'])){
        $row=0;
    }else{
        $row=1;
    }
    $id=$_POST['id'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    
    $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
    if(empty($password)){
      $pdostatement=$pdo->prepare("UPDATE  users SET name='$name',email='$email',role='$row' WHERE id='$id'");
    }else{
      $pdostatement=$pdo->prepare("UPDATE  users SET name='$name',email='$email',role='$row',password='$password' WHERE id='$id'");
    }
    
    $result=$pdostatement->execute();
       
    
if($result){
    echo "<script>alert('Successful Edit'); </script>";
  
    echo"<script>document.location.href = 'user_index.php',true;</script>";
}
}     
        }
    


?>
<?php include('header.php');?>

<div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Edit User </h3>
              </div>
            
              <!-- /.card-header -->
 <div class="card-body">
           <form action="" enctype="multipart/form-data" method="post">
           <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>">
           <input type="hidden" name="id" value="<?php echo $res['id'] ?>">
         <div class="form-group">
             <label for="">name</label><p class="text-danger"><?php echo empty($name_error)? '':  $name_error; ?></p>
      <input type="text" name="name" class="form-control" id="" value="<?php echo escape($res['name'])?>">

         </div>
         

         <div class="form-group">
             <label for="email">Email</label><p class="text-danger"><?php echo empty($email_error)? '':  $email_error; ?></p>
             <input type="email" name="email" class="form-control" value="<?php echo escape($res['email'])?>"> 

         </div>
         <div class="form-group">
       <label for="">Password</label><p class="text-danger"><?php echo empty($password_error)? '':  $password_error; ?></p>
             <small>password is already added in this filed</small>
      <input type="password" name="password" class="form-control" >

         </div>
         <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="isAdmin" value="1" <?php  if($res['role']==1){echo "checked";} ?> >
    <label class="form-check-label" for="exampleCheck1" >is Admin</label>
  </div>
         <div class="form-group">
             <input type="submit" value="Update" class="btn btn-info">
          <a href="index.php" class="btn btn-success">back</a>
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



















<?php include('footer.html');?>

