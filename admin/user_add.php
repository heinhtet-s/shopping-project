
<?php
require '../config/config.php';

session_start();
require '../config/common.php';
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header('Location: login.php');

}if($_SESSION['role']!=1){
  header('Location: login.php');
}
if($_POST){
  if(empty($_POST['name']) ||empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password']) <4 ){
    if(empty($_POST['name'])){
      $name_error='name cannot be null';
      
    }
   if(empty($_POST['email'])){
     $email_error='email cannot be null';
   }
   if(empty($_POST['address'])){
    $add_error='address cannot be null';
  }
  if(empty($_POST['phone'])){
    $phone_error='phone cannot be null';
  }
   if(empty($_POST['password'])){
     $password_error='Password cannot be null';
   }

    if(strlen($_POST['password'])<4) {
   $password_error='Password should be 4 characters at least';
  } }
  else{
    if(empty($_POST['isAdmin'])){

        $role=0;
    }else{
        $role=1;
    }
    $email=$_POST['email'];
    
    $stat=$pdo->prepare("SELECT * FROM users WHERE email=:email");
   
   $stat->bindValue(':email',$email);
  
    $stat->execute();
    
    $user=$stat->fetch(PDO::FETCH_ASSOC);
  
   
    if(!empty($user)){
        echo "<script>alert('email duplicated');</script>";
        echo"<script>document.location.href = 'user_add.php',true;</script>";}
        else{
         $password=$_POST['password'];
       $password=password_hash($password,PASSWORD_DEFAULT);
       $phone=$_POST['phone'];
       $address=$_POST['address'];
            $pdostatement=$pdo->prepare("INSERT INTO users(name,email,password,role) VALUES(:name,:email,:password,:role)");
    $result=$pdostatement->execute([
        ":name"=>$_POST['name'],
        ":email"=>$_POST['email'],
        ":password"=>$password,
        ":phone"=>$phone,
        ":address"=>$address,
        ":role"=>$role,
    ]);
if($result){
    echo "<script>alert('Successful Added'); </script>";
  
    echo"<script>document.location.href = 'user_index.php',true;</script>";
}
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
                <h3 class="card-title">Create New User </h3>
              </div>
            
              <!-- /.card-header -->
 <div class="card-body">
           <form action="user_add.php" enctype="multipart/form-data" method="post">
           <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>">
         <div class="form-group">
             <label for="">name</label><p class="text-danger"><?php echo empty($name_error)? '':  $name_error; ?></p>
      <input type="text" name="name" class="form-control" id="" >

         </div>
         

         <div class="form-group">
             <label for="email">Email</label><p class="text-danger"><?php echo empty($email_error)? '':  $email_error; ?></p>
             <input type="email" name="email" class="form-control"  >

         </div>
         <div class="form-group">
            <label for="">Password</label><p class="text-danger"><?php echo empty($password_error)? '':  $password_error; ?></p>
             
      <input type="password" name="password" class="form-control" >

         </div>
         <div class=" form-group">
                            <p class="text-danger"><?php echo empty($add_error)? '':  $add_error; ?></p>
								<input type="text" class="form-control" id="name" name="address" >
                            </div>
                            <div class="form-group">
                            <p class="text-danger"><?php echo empty($phone_error)? '':  $phone_error; ?></p>
								<input type="text" class="form-control" id="name" name="phone" >
                            </div>
         <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="isAdmin" value="1">
    <label class="form-check-label" for="exampleCheck1" >is Admin</label>
  </div>
         <div class="form-group">
             <input type="submit" value="Create" class="btn btn-info">
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