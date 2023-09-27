<!DOCTYPE html>
<html>
<head>
    <title>Product Selection</title>
</head>
<body>
    <?php
    require('set.php');
    $i = 1; // Reset the counter for each variable product
    $j=1;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selectedProduct = $_POST["product"];
        $selectedSize = $_POST["size"];

        // You can now process the selected product and size as needed, e.g., insert them into another table or perform some action.
        // Make sure to handle validation and database interactions securely.

        // Redirect or display a confirmation message as needed.
        echo "Selected Product ID: " . $selectedProduct . "<br>";
        if (!empty($selectedSize)) {
            echo "Selected Size ID: " . $selectedSize . "<br><hr>";
            $sql = "SELECT s.idSize, s.sizeValue, pd.qty , pd.idP
                    FROM `size` s
                    LEFT JOIN `product_detail` pd ON s.idSize = pd.idSize AND pd.idP = $selectedProduct WHERE pd.qty IS NOT NULL AND s.idSize = $selectedSize";
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
        } else {
            $sql = "SELECT * FROM `product` WHERE idP = $selectedProduct";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                
                while ($product = mysqli_fetch_assoc($result)) {               
                    // Generate size labels and hidden input fields
                    echo  "<b>".$product['nameP'] . ' </b>|| Quantite:  <b><u>' . $product['qtyP'] . '</u></b>  PRIX UNITAIRE: <b>'.$product['prixP'] . "DH </b> ";
                    echo '<input type="hidden" name="idProduct' . $j . '" value="' . $product['idP'] . '">';
                    echo '<input class="custom-input" type="number" min="0" max="' . $product['qtyP'] . '" name="qtyProduct' . $j . '"><hr>';
                    $j++;
                }
            }
        }
    }
    ?>

    <form method="post" action="work.php">
        <label for="product">Select a Product:</label>
        <select name="product" id="product">
            <?php
            require('set.php');

            // Retrieve products from the database
            $sql = "SELECT idP, nameP, hasVariables FROM product";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $productId = $row["idP"];
                    $productName = $row["nameP"];
                    $hasVariables = $row["hasVariables"];
                    
                    echo "<option value='$productId' data-hasvariables='$hasVariables'>$productName</option>";
                }
            }

            $conn->close();
            ?>
        </select>

        <!-- Create the sizes input if the selected product has variables -->
        <div id="sizesDiv" style="display: none;">
            <label for="size">Select Size:</label>
            <select name="size" id="size">
                <!-- Options will be added dynamically using AJAX -->
            </select>
        </div>

        <input type="submit" value="Submit">
    </form>

    <script>
document.getElementById("product").addEventListener("change", function () {
    var productSelect = document.getElementById("product");
    var sizesDiv = document.getElementById("sizesDiv");
    var sizeSelect = document.getElementById("size");

    if (productSelect.value !== "") {
        var productId = productSelect.value;

        // Make an AJAX request to fetch sizes for the selected product
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_sizes.php?product_id=" + productId, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Clear and populate the size select element with the retrieved data
                sizeSelect.innerHTML = xhr.responseText;

                // Show or hide the size select based on whether sizes were retrieved
                sizesDiv.style.display = sizeSelect.options.length > 0 ? "block" : "none";
            }
        };

        xhr.send();
    } else {
        // If no product is selected, hide the size select
        sizesDiv.style.display = "none";
    }
});
    </script>
</body>
</html>
