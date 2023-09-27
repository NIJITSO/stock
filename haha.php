<!DOCTYPE html>
<html>
<head>
    <title>Product Selection</title>
</head>
<body>
    <?php
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selectedProduct = $_POST["product"];
        $selectedSize = $_POST["size"];

        // You can now process the selected product and size as needed, e.g., insert them into another table or perform some action.
        // Make sure to handle validation and database interactions securely.

        // Redirect or display a confirmation message as needed.
        echo "Selected Product ID: " . $selectedProduct . "<br>";
        if (!empty($selectedSize)) {
            echo "Selected Size ID: " . $selectedSize;
        } else {
            echo "No Size Selected";
        }
    }
    ?>

    <form method="post" action="">
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
                <?php
                // Assuming you have a database connection established
                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Retrieve sizes from the database
                $sql = "SELECT idSize, sizeValue FROM size";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $sizeId = $row["idSize"];
                        $sizeValue = $row["sizeValue"];
                        
                        echo "<option value='$sizeId'>$sizeValue</option>";
                    }
                }

                $conn->close();
                ?>
            </select>
        </div>

        <input type="submit" value="Submit">
    </form>

    <script>
        // JavaScript to show/hide the sizes input based on product selection
        document.getElementById("product").addEventListener("change", function () {
            var productSelect = document.getElementById("product");
            var sizesDiv = document.getElementById("sizesDiv");

            if (productSelect.value !== "") {
                var selectedOption = productSelect.options[productSelect.selectedIndex];
                var hasVariables = selectedOption.getAttribute("data-hasvariables");

                if (hasVariables === "1") {
                    sizesDiv.style.display = "block";
                } else {
                    sizesDiv.style.display = "none";
                }
            } else {
                sizesDiv.style.display = "none";
            }
        });
    </script>
</body>
</html>
