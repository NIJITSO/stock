<style type="text/css">
   @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
*{
  margin: 0;
  padding: 0;
  outline: none;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}
body{
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  padding: 10px;
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(115deg, #6a41ed 10%, #01ad94 90%);
}
.container{
  max-width: 800px;
  background: #fff;
  width: 800px;
  padding: 25px 40px 10px 40px;
  box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
}
.container .text{
  text-align: center;
  font-size: 41px;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  background-color: #6a41ed;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.container form{
  padding: 30px 0 0 0;
}
.container form .form-row{
  display: flex;
  margin: 32px 0;
}
form .form-row .input-data{
  width: 100%;
  height: 40px;
  margin: 0 20px;
  position: relative;
}
#date{
   transform: translateY(-30px);
   font-size: 14px;

}
form .form-row .textarea{
  height: 70px;
}
.input-data input,
.textarea textarea{
  display: block;
  width: 100%;
  height: 100%;
  border: none;
  font-size: 17px;
  border-bottom: 2px solid rgba(0,0,0, 0.12);
}
.input-data input:focus ~ label, .textarea textarea:focus ~ label,
.input-data input:valid ~ label, .textarea textarea:valid ~ label{
  transform: translateY(-20px);
  font-size: 14px;
  color: #3498db;
}
.textarea textarea{
  resize: none;
  padding-top: 10px;
}
.input-data label{
  position: absolute;
  pointer-events: none;
  bottom: 10px;
  font-size: 16px;
  transition: all 0.3s ease;
}
.textarea label{
  width: 100%;
  bottom: 40px;
  background: #fff;
}
.input-data .underline{
  position: absolute;
  bottom: 0;
  height: 2px;
  width: 100%;
}
.input-data .underline:before{
  position: absolute;
  content: "";
  height: 2px;
  width: 100%;
  background: #3498db;
  transform: scaleX(0);
  transform-origin: center;
  transition: transform 0.3s ease;
}

.submit-btn .input-data{
  overflow: hidden;
  height: 45px!important;
  width: 25%!important;
}
.submit-btn .input-data .inner{
  height: 100%;
  width: 300%;
  position: absolute;
  left: -100%;
  background-color: #01ad94;
  transition: all 0.4s;
}
.submit-btn .input-data:hover .inner{
  left: 0;
}
.submit-btn .input-data input{
  background: none;
  border: none;
  color: #fff;
  font-size: 17px;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 1px;
  cursor: pointer;
  position: relative;
  z-index: 2;
}
@media (max-width: 700px) {
  .container .text{
    font-size: 30px;
  }
  .container form{
    padding: 10px 0 0 0;
  }
  .container form .form-row{
    display: block;
  }
  form .form-row .input-data{
    margin: 35px 0!important;
  }
  .submit-btn .input-data{
    width: 40%!important;
  }
}



</style>
<?php
require('../set.php');
session_start();
if (isset($_SESSION['updateId'])) {
   $sql = "SELECT * FROM `items_table` WHERE `items_table`.`id` = '{$_SESSION['updateId']}'";
   $result = mysqli_query($conn, $sql);
   $data = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Get the submitted form data
   $catId = $_POST['cat'];
   $title = $_POST['title'];
   $date = $_POST['date'];
   $price = $_POST['price'];
   $description = $_POST['description'];

   // Check if a new image was uploaded
   if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
      $image = $_FILES['image']['name'];
      $targetDir = "../img/";
      $targetFile = $targetDir . basename($image);

      // Delete the old image if it exists
      if (!empty($data['image']) && file_exists($targetDir . $data['image'])) {
         unlink($targetDir . $data['image']);
      }

      move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
   } else {
      // If no new image was uploaded, use the existing image
      $image = $data['image'];
   }

   // Update the database with the new information
   $sql = "UPDATE `items_table` SET `idCat` = '$catId', `image` = '$image', `title` = '$title', `date` = '$date', `price` = '$price', `description` = '$description' WHERE `id` = '{$_SESSION['updateId']}'";
   mysqli_query($conn, $sql);

   // Redirect to a success page or perform any other necessary actions
   header("Location: index.php");
   exit();
}
?>
<div class="container">
   <div class="text">
      Update Cours
   </div>
   <form method="POST" enctype="multipart/form-data">
      <div class="input-data">
         <select name="cat">
            <?php
            $sql = "SELECT * FROM categorie";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
               if ($data['idCat'] == $row['idCat']) {
                  echo "<option selected value='{$row['idCat']}'>{$row['nameCat']}</option>";
               } else {
                  echo "<option value='{$row['idCat']}'>{$row['nameCat']}</option>";
               }
            }
            ?>
         </select>
      </div>
      <div class="form-row">
         <div class="input-data">
            <img src="../img/<?=$data['image']?>" width="50">
            <input type="file" name="image" value="">
            <div class="underline"></div>
         </div>
         <div class="input-data">
            <input type="text" name="title" value="<?=$data['title']?>">
            <div class="underline"></div>
            <label for="">Titre du cour</label>
         </div>
         <div class="input-data">
            <input type="date" name="date" value="<?=$data['date']?>">
            <div class="underline"></div>
            <label id="date" for="">Date d'ajoute</label>
         </div>
      </div>
      <div class="form-row">
         <div class="input-data">
            <input type="number" step="0.01" name="price" min="0" value="<?=$data['price']?>">
            <div class="underline"></div>
         </div>
      </div>
      <div class="form-row">
         <div class="input-data textarea">
            <textarea name="description" rows="8" cols="80"><?=$data['description']?></textarea>
            <br />
            <div class="underline"></div>
            <label for="">Description</label>
            <br />

            <div class="form-row submit-btn">
               <div class="input-data">
                  <div class="inner"></div>
                  <input type="submit" value="Submit">
               </div>
            </div>
         </div>
      </div>
   </form>
</div>