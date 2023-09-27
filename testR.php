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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkbox Filter</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="search">
        <input type="text" id="searchInput" name="">
    </div>
    <div id="show_hide_inputs">
        <?php
        foreach ($products as $product) {
        ?>
        <div class="product-row">
            <label><?=$product['nameP']?></label> <input type="checkbox" name="productCheckbox" data-target="<?=$product['idP']?>">  <br>
        </div>
        <?php }?>
    </div>

    <script>
        $(document).ready(function () {
            // Hide all product rows initially
            $('.product-row').hide();

            $('#searchInput').on('input', function () {
                var searchText = $(this).val().trim().toLowerCase();

                // Hide all product rows
                $('.product-row').hide();

                // Show product rows that have at least one character in common with the search text
                if (searchText !== "") {
                    $('.product-row').each(function () {
                        var label = $(this).find('label').text().toLowerCase();
                        if (label.indexOf(searchText) !== -1) {
                            $(this).show();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
