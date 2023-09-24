<?php
require('set.php');
session_start();

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
<html>
<head>
    <title>Product Checkbox Generator</title>
    <style>
        /* Default style for the input field */
        .custom-input {
            padding: 10px;
            font-size: 16px;
            border: 2px solid #ccc;
            background-color: white;
            color: #333;
        }

        /* Style when input field is filled */
        .filled {
            background-color: #4CAF50; /* Green background */
            color: white; /* White text */
        }
    </style>
</head>
<body>

<form method="POST" action="work.php">
        
<?php
    $i = 1; // Reset the counter for each variable product
    $j=1;
foreach ($products as $product) {

    if ($product['hasVariables'] == 0) {
        echo  $product['nameP'] . ' || Quantite:  <b><u>' . $product['qtyP'] . '</u></b>  PRIX UNITAIRE: <b>'.$product['prixP'] . "DH </b> ";
        echo '<input type="hidden" name="idProduct' . $j . '" value="' . $product['idP'] . '">';
        echo '<input class="custom-input" type="number" min="0" max="' . $product['qtyP'] . '" name="qtyProduct' . $j . '"><hr>';
        $j++;
    } else {
        echo "<b>".$product['nameP'] . " ID=".$product['idP']."</b> PRIX UNITAIRE: <b>".$product['prixP'] . "DH </b> ".'<br>';
        
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
            echo "<hr>";
        }
    }

}

?>
Verifier the informations: <input type="checkbox" required name="">
<input type="submit" name="ok">
</form>
    <script>
        const inputElements = document.querySelectorAll(".custom-input");

        // Function to check if the input is filled and apply styles accordingly
        function checkInput(inputElement) {
            if (inputElement.value.trim() !== "") {
                inputElement.classList.add("filled");
            } else {
                inputElement.classList.remove("filled");
            }
        }

        // Add an event listener to each input field to check for changes
        inputElements.forEach(inputElement => {
            inputElement.addEventListener("input", () => {
                checkInput(inputElement);
            });
        });
    </script>
</body>
</html>