<?php
require('set.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Button Click Example</title>
</head>
<body>

<!-- Hidden form to send theIdClicked to PHP -->
<form id="myForm" method="post">
    produits have variables:
    No<input type="radio" id="noRadio" name="variable" value="no" checked />
    Yes<input type="radio" id="yesRadio" name="variable" value="yes" /><br>
    name Product:<input type="text" name="title" required><br>
    quantite:<input type="number" min="0" name="quantite" id="quantityInput" required><br>

    <!-- Container for extra checkboxes -->
    <div id="extraCheckboxes" style="display: none;">
        <label>Extra Values:</label><br>
        <?php
        $sql = "SELECT * FROM `size`";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <input class="ss" type="checkbox" name="size[]" value="<?=$row['idSize']?>" smiya="<?=$row['sizeValue']?>"> <?=$row['sizeValue']?><br>
    <?php }}?>
    </div>

    <!-- Container for dynamic extra value inputs -->
    <div id="dynamicExtraInputs"></div>

    <input type="submit" name="ok" value="OK">
</form>
<?php
if (isset($_POST['title'])) {
    $title=$_POST['title'];
}

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
if (isset($_POST['ok'])) {
    if ($_POST['variable']=='no') {
        $insert="INSERT INTO `product` (`idP`, `nameP`, `descP`, `qtyP`, `hasVariables`) VALUES (NULL, '$title', NULL, {$_POST['quantite']}, 0)";
        $result = mysqli_query($conn, $insert);
    }else{
        $insert="INSERT INTO `product` (`idP`, `nameP`, `descP`, `qtyP`, `hasVariables`) VALUES (NULL, '$title', NULL, NULL, 1)";
        $result = mysqli_query($conn, $insert);
        $lastInsertedId = mysqli_insert_id($conn);
        $size=$_POST['size'];
        $quantite=$_POST['quantite'];
        print_r($size);
        if ($result) {
                for ($i = 0; $i < count($size); $i++) {
                    // Insert into "order_product_quantity" with the order_id
                    $sql = "INSERT INTO `product_detail` (`idP`, `idSize`, `qty`) VALUES ($lastInsertedId, $size[$i], $quantite[$i])";
                    
                    if (!mysqli_query($conn, $sql)) {
                        echo "Error inserting product: " . mysqli_error($conn);
                    }
                } 
        }
    }
}
?>
<script>
    // Get references to the radio buttons, the container for extra checkboxes, and the quantity input
    const noRadio = document.getElementById('noRadio');
    const yesRadio = document.getElementById('yesRadio');
    const extraCheckboxes = document.getElementById('extraCheckboxes');
    const quantityInput = document.getElementById('quantityInput');
    const dynamicExtraInputs = document.getElementById('dynamicExtraInputs');

    // Add event listeners to the radio buttons to show/hide extra checkboxes and disable quantity input
    noRadio.addEventListener('change', function () {
        extraCheckboxes.style.display = 'none';
        quantityInput.disabled = false; // Enable quantity input when No is selected
    });

    yesRadio.addEventListener('change', function () {
        extraCheckboxes.style.display = 'block';
        quantityInput.disabled = true; // Disable quantity input when Yes is selected
    });

    // Add event listeners to the extra checkboxes
    const extraCheckboxesList = extraCheckboxes.querySelectorAll('input[type="checkbox"]');
    extraCheckboxesList.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            updateDynamicExtraInputs();
        });
    });

    // Function to update dynamic extra value inputs
    function updateDynamicExtraInputs() {
        dynamicExtraInputs.innerHTML = ''; // Clear existing dynamic inputs

        extraCheckboxesList.forEach(function (checkbox) {
            if (checkbox.checked) {
                const input = document.createElement('input');
                input.type = 'number';
                input.required = true;
                input.min = '0';
                input.name = 'quantite[]'; // Use idSize as a unique identifier

                // Access the smiya attribute using getAttribute
                const smiya = checkbox.getAttribute('smiya');

                dynamicExtraInputs.appendChild(document.createTextNode(smiya + ': '));
                dynamicExtraInputs.appendChild(input);
                dynamicExtraInputs.appendChild(document.createElement('br'));
            }
        });
    }

</script>

</body>
</html>
