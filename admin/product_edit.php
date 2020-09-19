<?php
session_start();
require '../config/config.php';
require '../config/common.php';

if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header('Location: login.php');
}if($_SESSION['role']!=1){
  header('Location: login.php');
}

$id=$_GET['id'];
$pdostatement=$pdo->prepare("SELECT * FROM products WHERE id=:id");
$pdostatement->execute([":id"=>$id]);
$old_p=$pdostatement->fetchAll();
if($_POST){
 
  if(empty($_POST['name']) || empty($_POST['description']) || empty($_POST['quantity'])|| empty($_POST['price']) || empty($_POST['category'])){

if(empty($_POST['name'])){
$name_error="Name field cannot be null";
}
if(empty($_POST['description'])){
$description_error="description field cannot be null";

}
if(empty($_POST['quantity'])){
$quantity_error="quantity field cannot be null";

}elseif(is_numeric($_POST['quantity']) != 1){
   
    $quantity_error="Quantity should be integer value";
 
   }
if(empty($_POST['price'])){

    $price_error="price field cannot be null";
}elseif(is_numeric($_POST['price'] ) != 1){
    
    $price_error="Price should be integer value";
 
   }
if(empty($_POST['category'])){
  
    $category_error="category field cannot be null";
}
if(empty($_FILES['image']['name'])){
    $image_error='Image cannot be null';

  }


  }elseif(is_numeric($_POST['quantity']) != 1){
   
    $quantity_error="Quantity should be integer value";
 
   }elseif(is_numeric($_POST['quantity']) != 1){
   
    $quantity_error="Quantity should be integer value";
 
   }
  else{
      $name=$_POST['name'];
      $desc=$_POST['description'];
      $quantity=$_POST['quantity'];
      $price=$_POST['price'];
      $category_id=$_POST['category'];
     

      if(!empty($_FILES['image']['name'])){
        
     $file='../image/'.($_FILES['image']['name']);
    $imageType=pathinfo($file,PATHINFO_EXTENSION);
     $imageType=strtoupper($imageType);
    if($imageType!='PNG' && $imageType !='JPG' && $imageType!='JEPG'){
        echo "<script>alert('Please enter image file'); </script>";
    }else{
    move_uploaded_file($_FILES['image']['tmp_name'],$file); 
      $pdostatement=$pdo->prepare("UPDATE  products SET name=:name ,description=:description ,quantity=:quantity,price=:price,category_id=:category_id,image=:image WHERE id='$id'");
      $result=$pdostatement->execute([
       
        ":name"=>$name,
        ":description"=>$desc,
        ":quantity"=>$quantity,
        ":price"=>$price,
        ":category_id"=>$category_id,
        ":image"=>$_FILES['image']['name'],
      
        
        
      ]);
    }    
    }else{
      $pdostatement=$pdo->prepare("UPDATE  products SET name=:name ,description=:description ,quantity=:quantity,price=:price,category_id=:category_id WHERE id='$id'");
      $result=$pdostatement->execute([
        
        ":name"=>$name,
        ":description"=>$desc,
        ":quantity"=>$quantity,
        ":price"=>$price,
        ":category_id"=>$category_id,]);
        
      

        

    }

     
   if($result){
echo "<script>alert('successfully added');</script>";
echo "<script>window.location.href = 'index.php'</script>;";

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
                <h3 class="card-title">Create New Product  </h3>
              </div>
            
              <!-- /.card-header -->
 <div class="card-body">
           <form action="" enctype="multipart/form-data" method="post">
           <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>">
         <div class="form-group">
             <label for="">name</label><p class="text-danger"><?php echo empty($name_error)? '':  $name_error; ?></p>
      <input type="text" value="<?php echo $old_p[0]['name']?>" name="name" class="form-control" id="">

         </div>

         <div class="form-group">
             <label for="">description</label><p class="text-danger"><?php echo empty($description_error)? '':  $description_error; ?></p>
    <textarea name="description" id="" cols="30" rows="5" class="form-control"><?php echo $old_p[0]['description']?></textarea>

         </div>
         <div class="form-group">
             <label for="">Instock</label><p class="text-danger"><?php echo empty($quantity_error)? '':  $quantity_error; ?></p>
      <input type="number" name="quantity" class="form-control" id="" value="<?php echo $old_p[0]['quantity']?>">

         </div>
         <div class="form-group">
             <label for="">Price</label><p class="text-danger"><?php echo empty($price_error)? '':  $price_error; ?></p>
      <input type="number" name="price" class="form-control" id="" value="<?php echo $old_p[0]['price']?>">

         </div>
         <?php
         $pdostatement=$pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
         $pdostatement->execute();
         $cat=$pdostatement->fetchAll();
          
         ?>
         <label for="">Choose Category</label><p class="text-danger"><?php echo empty($category_error)? '':  $category_error; ?></p>
         <select class="browser-default custom-select" name="category">

  
<?php foreach ($cat as  $c) { ?>
    

  <option value="<?php echo $c['id'] ;?>"<?php if($c['id']==$old_p[0]['category_id']){echo "selected";} ?>><?php echo $c['name'] ;?></option>
<?php } ?>
</select> <br><br>
<div class="form-group">
  <img src="../image/<?php echo $old_p[0]['image']; ?>" alt="" class="img-fluid" width="150" height="150"><br>
             <label for="">Image</label><p class="text-danger"><?php echo empty($image_error)? '':  $image_error; ?></p>
      <input type="file" name="image" class="form-control" id="">

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
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <?php include('footer.html');?>