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
if(!isset($_SESSION['id'])  ||  $_SESSION['role']!=="admin"){
  header('Location: ../Authentification/');
}
if (isset($_SESSION['updateId'])) {
   $sql = "SELECT * FROM `product` WHERE `product`.`idP` = '{$_SESSION['updateId']}'";
   $result = mysqli_query($conn, $sql);
   $data = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Get the submitted form data
   $nameProduct = $_POST['title'];
   $quantite = $_POST['quantite'];
   $prix = $_POST['prix'];
   $description = $_POST['description'];


   // Update the database with the new information
   $sql = "UPDATE `product` SET `nameP` = '$nameProduct',`qtyP` = '$quantite',`descP` = '$description' WHERE `idP` = '{$_SESSION['updateId']}'";
   mysqli_query($conn, $sql);

   // Redirect to a success page or perform any other necessary actions
   header("Location: index.php");
   exit();
}
?>
<div class="container">
   <div class="text">
      Update Produits
   </div>
   <form method="POST" enctype="multipart/form-data">
      <div class="input-data">
      </div>
      <div class="form-row">
         <div class="input-data">
            <input type="text" name="title" value="<?=$data['nameP']?>">
            <div class="underline"></div>
            <label for="">Titre du Produit</label>
         </div>
      </div>

      <div class="form-row">
         <div class="input-data textarea">
            <textarea name="description" rows="8" cols="80"><?=$data['descP']?></textarea>
            <br />
            <div class="underline"></div>
            <label for="">Description</label>
            <br />

         </div>
      </div>
            <div class="form-row">
         <div class="input-data textarea">
            <input type="text" name="prix" value="<?=$data['prixP']?>">
            <br />
            <div class="underline"></div>
            <label for="">Prix</label>
            <br />

         </div>
      </div>
      <div class="form-row">
          <div class="input-data">
            <input type="text" name="quantite" value="<?=$data['qtyP']?>">
            <div class="underline"></div>
            <label for="">Quantite du Produit</label>
         </div>
      </div>
      <div class="form-row submit-btn">
               <div class="input-data">
                  <div class="inner"></div>
                  <input type="submit" value="Submit">
               </div>
            </div>
   </form>
</div>