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
<?php
foreach ($products as $product) {
    if ($product['hasVariables'] == 0) {
    echo '<input type="checkbox" id="product_' . $product['idP'] . '">' . $product['nameP'] . '<br>';
    }else{
        echo '' . $product['nameP'] . '<br>';
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
                echo '&nbsp;&nbsp;&nbsp;<input type="checkbox" id="size_' . $size['idSize'] . '" >' . $size['sizeValue'] . '<br>';
            }
        }
    }
}
?>
</body>
</html>