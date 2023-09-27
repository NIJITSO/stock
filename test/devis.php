<?php
require('../set.php');
session_start();
if(!isset($_SESSION['id'])  ||  $_SESSION['role']!=="admin"){
  header('Location: ../Authentification/');
}




// Fetch products from the database
$sql = "SELECT * FROM `product`"; // Use the correct table name for products
$result = mysqli_query($conn, $sql);

$products = array(); // An array to store product data

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        /* CSS to hide the divs by default */
        #Product div {
            display: none;
        }
        #societe {
            display: block;
        }
    </style>
<link rel="stylesheet" href="css/style.min.css">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <meta name="viewport"
          content="width=device-width,
                   initial-scale=1.0">
    <title>netserv</title>
    <link rel="stylesheet"
          href="css/style.css">

	<style type="text/css">
     td,th{
        padding: 10px 30px;
     }   
    </style>
</head>
 
<body>

    <header>
 
        <div class="logosec">
            <div class="logo">NETSERV</div>
            <img src=
"https://media.geeksforgeeks.org/wp-content/uploads/20221210182541/Untitled-design-(30).png"
                class="icn menuicn"
                id="menuicn"
                alt="menu-icon">
        </div>
 
        <div class="message">
            <div class="dp">
              <img src="../../imgUser/<?=$_SESSION['img']?>"
                    class="dpicn"
                    alt="dp">
              </div>
        </div>
 
    </header>
 
    <div class="main-container">
        <div class="navcontainer">
            <nav class="nav">
                <div class="nav-upper-options">
                    <a href="index.php" style="all:unset;"><div class="nav-option option2">
                        <img src="img/dashboard.jpg"
                            class="nav-img"
                            alt="dashboard">
                        <h3> Dashboard</h3>
                    </div></a>
                    <a href="devis.php" style="all:unset;"><div class="nav-option option1">
                        <img src="img/message.png"
                            class="nav-img"
                            alt="dashboard">
                        <h3> Devis</h3>
                    </div></a>
                    <a href="devis_manager.php" style="all:unset;"><div class="nav-option option2">
                        <img src="img/message.png"
                            class="nav-img"
                            alt="dashboard">
                        <h3> Deis</h3>
                    </div></a>
 
                    <a href="edit_profile_admin.php" style="all:unset;"><div class="nav-option option2">
                        <img src="img/edit.jpg" class="nav-img" alt="settings">
                        <h3> Settings</h3>
                    </div></a>

                    <a href="../deconnexion.php" style="all:unset;">
                        <div class="nav-option logout">
                        <img src="img/logout.jpg" class="nav-img" alt="logout">
                        <h3>Logout</h3>
                    </div></a>
 
                </div>
            </nav>
        </div>
        <div class="main">
            <h2>Filtring Produits</h2>   
            <div id="show_hide_inputs">
    <?php
    foreach ($products as $product) {
    ?>
    <?=$product['nameP']?> <input type="checkbox" name="productCheckbox" data-target="<?=$product['idP']?>">  <br>
    <?php }?>
</div>

<form method="POST" action="work.php">
<div id="Product">
<h2>Devies informations</h2>   
<?php
    $i = 1; // Reset the counter for each variable product
    $j=1;
foreach ($products as $product) {

    if ($product['hasVariables'] == 0) {
        echo '<div id="' . $product['idP'] . '">';
        echo  "<b>".$product['nameP'] . ' </b>|| Quantite:  <b><u>' . $product['qtyP'] . '</u></b>  PRIX UNITAIRE: <b>'.$product['prixP'] . "DH </b> ";
        echo '<input type="hidden" name="idProduct' . $j . '" value="' . $product['idP'] . '">';
        echo '<input class="custom-input" type="number" min="0" max="' . $product['qtyP'] . '" name="qtyProduct' . $j . '">';
        echo '</div>';
        $j++;
    } else {
        echo '<div id="' . $product['idP'] . '">';
        echo "<b>".$product['nameP'] . "</b> PRIX UNITAIRE: <b>".$product['prixP'] . "DH </b> ".'<br>';
        
        // Check if the product has variables (sizes)
        if ($product['hasVariables'] == 1) {

            // Fetch sizes associated with the current product
            $sql = "SELECT s.idSize, s.sizeValue, pd.qty , pd.idP
                    FROM `size` s
                    LEFT JOIN `product_detail` pd ON s.idSize = pd.idSize AND pd.idP = {$product['idP']} WHERE pd.qty IS NOT NULL";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                
                while ($size = mysqli_fetch_assoc($result)) {               
                    // Generate size labels and hidden input fields
                    echo '&nbsp;&nbsp;&nbsp;' . $size['sizeValue'] . ' || Quantite: <b><u>' . $size['qty'] . '</u></b>';
                    echo '<input type="hidden" name="idP' . $i . '" value="' . $size['idP'] . '">';
                    echo '<input type="hidden" name="idSize' . $i . '" value="' . $size['idSize'] . '">';
                    
                    // Generate input fields for quantity
                    echo '<input class="custom-input" type="number" min="0" max="' . $size['qty'] . '" name="qty' . $i . '">' . '<br>';
                    
                    $i++;
                }
            }
            echo '</div>';
        }
    }

}

?>
</div>

<script>
    const checkboxes = document.querySelectorAll('input[name="productCheckbox"]');
    const divsToHide = document.querySelectorAll('#Product > div');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            const targetID = this.getAttribute('data-target');
            const targetDiv = document.getElementById(targetID);
            if (targetDiv) {
                targetDiv.style.display = this.checked ? 'block' : 'none';
            }
        });
    });
</script>
<div id="societe">
    <h2>Societe informations</h2>
    Nom du Sosiete :<input type="text" name="buyer_name" required>
    mail_address du Sosiete :<input type="text" name="mail_address" required>
    phoneNumber du Sosiete :<input type="text" name="phoneNumber" required>
    company_name du Sosiete :<input type="text" name="company_name" required>
    address du Sosiete :<input type="text" name="address" required> 
    <hr><br>
</div>

Verifier the informations: <input type="checkbox" required name="">

<br><br>

<input type="submit" name="ok">
</form>
        </div>
    <script src="js/script.js"></script>
</body>
</html>
