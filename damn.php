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
        /* Reset default margin and padding for the entire page */
        body {
            margin: 0;
            padding: 0;

        }

        /* Apply a background color to the body */
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Style for the form container */
        .form-container {
            width: 80%;
            max-width: 800px;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Style for the product items */
        .product-item {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        /* Style for the input field */
        .custom-input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #ccc;
            background-color: white;
            color: #333;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Style when input field is filled */
        .filled {
            background-color: #4CAF50; /* Green background */
            color: white; /* White text */
        }

        /* Style for the "Verify the information" section */
        .verify-section {
            margin-top: 20px;
        }

        /* Style for the submit button */
        .custom-button {
            padding: 10px 20px;
            font-size: 18px;
            background-color: #4CAF50; /* Green */
            color: white;
            border: none;
            cursor: pointer;
        }

        /* Style for the checkbox label */
        .checkbox-label {
            font-size: 16px;
            color: #333; /* Dark gray */
        }

        /* Style for the checkbox */
        .custom-checkbox {
            margin-right: 5px;
            vertical-align: middle;
        }
    </style>
</head>
<body>

<form method="POST" action="work.php">
<h2>Devies informations</h2>   
<?php
    $i = 1; // Reset the counter for each variable product
    $j=1;
foreach ($products as $product) {

    if ($product['hasVariables'] == 0) {
        echo  "<b>".$product['nameP'] . ' </b>|| Quantite:  <b><u>' . $product['qtyP'] . '</u></b>  PRIX UNITAIRE: <b>'.$product['prixP'] . "DH </b> ";
        echo '<input type="hidden" name="idProduct' . $j . '" value="' . $product['idP'] . '">';
        echo '<input class="custom-input" type="number" min="0" max="' . $product['qtyP'] . '" name="qtyProduct' . $j . '"><hr>';
        $j++;
    } else {
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
            echo "<hr>";
        }
    }

}

?>
<h2>Societe informations</h2>
Nom du Sosiete :<input type="text" name="nameSosiete" required>
Fix du Sosiete :<input type="text" name="telSosiete" required>
<hr><br>


Verifier the informations: <input type="checkbox" required name="">

<br><br>

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