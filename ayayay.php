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
</head>
<body>
<form method="POST" action="">
        
<?php
foreach ($products as $product) {
    if ($product['hasVariables'] == 0) {
        echo '<input type="checkbox" id="product_' . $product['idP'] . '" class="product-checkbox" name="products[]" value="' . $product['idP'] . '">' . $product['nameP'] . ' :<b>' . $product['qtyP'] . '</b>' . '<br>';
    } else {
        echo $product['nameP'] . " ID=".$product['idP'].'<br>';
    }
    // Check if the product has variables (sizes)
    if ($product['hasVariables'] == 1) {
        // Fetch sizes associated with the current product
        $sql = "SELECT s.idSize, s.sizeValue, pd.qty
                FROM `size` s
                LEFT JOIN `product_detail` pd ON s.idSize = pd.idSize AND pd.idP = {$product['idP']} WHERE pd.qty IS NOT NULL";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($size = mysqli_fetch_assoc($result)) {
                // Generate size checkboxes based on the qty (quantity) value
                echo '&nbsp;&nbsp;&nbsp;<input type="checkbox" id="size_' . $size['idSize'] . '" class="size-checkbox" name="' . $size['sizeValue'] . '[]" value="' . $size['idSize'] . '">' . $size['sizeValue'] . ' :<b>' . $size['qty'] . '</b>' . '<br>';

            }
        }
    }
}
?>
<input type="submit" name="ok">
</form>
<?php
if (isset($_POST['ok'])) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
}

?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Get all product checkboxes
    var productCheckboxes = document.querySelectorAll('.product-checkbox');

    // Add an event listener to each product checkbox
    productCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            if (this.checked) {
                // Checkbox is checked, create an input field
                var input = document.createElement('input');
                input.type = 'number';
                input.placeholder = 'Quantity ';
                input.className = 'product-input';
                input.name = 'product_inputs[]';
                input.min = '0';
                input.max = this.nextElementSibling.textContent;
                input.required = true;

                // Insert the input field after the checkbox
                this.parentNode.insertBefore(input, this.nextSibling);
            } else {
                // Checkbox is unchecked, remove the associated input field
                var input = this.nextSibling;
                if (input && input.classList.contains('product-input')) {
                    input.parentNode.removeChild(input);
                }
            }
        });
    });

    // Get all size checkboxes
    var sizeCheckboxes = document.querySelectorAll('.size-checkbox');
        var counter = 1; // Initialize a counter variable
    // Add an event listener to each size checkbox
    sizeCheckboxes.forEach(function (checkbox) {

        checkbox.addEventListener('change', function () {
            if (this.checked) {
                // Checkbox is checked, create an input field
                var input = document.createElement('input');
                input.type = 'number';
                input.placeholder = 'Quantity ';
                input.className = 'product-input';
                input.name = 'idP' + counter; // Set the name attribute dynamically
                input.min = '0';
                input.max = this.nextElementSibling.textContent;
                input.required = true;

                var inputV = document.createElement('input');
                inputV.type = 'text';
                inputV.placeholder = 'Quantity ';
                inputV.className = 'product-input';
                inputV.name = 'idP' + counter; // Set the name attribute dynamically
                inputV.min = '0';
                inputV.max = this.nextElementSibling.textContent;
                inputV.required = true;

                // Increment the counter
                counter++;

                // Insert the input field after the checkbox
                this.parentNode.insertBefore(input, this.nextSibling);
            } else {
                // Checkbox is unchecked, remove the associated input field
                var input = this.nextSibling;
                if (input && input.classList.contains('product-input')) {
                    input.parentNode.removeChild(input);
                }

                var inputV = this.nextSibling;
                if (inputV && inputV.classList.contains('product-input')) {
                    inputV.parentNode.removeChild(inputV);
                }
            }
        });

    });
});
</script>
</body>
</html>
