<?php
require('../set.php');
session_start();

// Initialize variables for form values
$productName = "";
$hasVariables = "no"; // Default to "No"
$selectedSizes = [];
$quantities = [];

if (isset($_SESSION['updateVariable'])) {
    $sql = "SELECT p.idP, p.nameP, s.idSize, s.sizeValue, pd.qty
            FROM product_detail pd
            JOIN product p ON pd.idP = p.idP
            JOIN size s ON pd.idSize = s.idSize
            WHERE p.idP = '{$_SESSION['updateVariable']}'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);

    // Set the values based on database data
    $productName = $data['nameP'];
    $hasVariables = "yes"; // Assuming "Yes" is selected by default
    $selectedSizes = [];
    $quantities = [];

    // Retrieve selected sizes and quantities from the database
    do {
        $selectedSizes[] = $data['idSize'];
        $quantities[$data['idSize']] = $data['qty'];
    } while ($data = mysqli_fetch_assoc($result));
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve values from the submitted form
    $selectedOption = $_POST['variable'];
    $productName = $_POST['title'];
    $quantity = $_POST['quantite'];
    $selectedSizes = $_POST['size'];

    // Retrieve quantities for selected size options
    foreach ($selectedSizes as $sizeId) {
        $quantityValue = $_POST['quantite'][$sizeId];
        $quantities[$sizeId] = $quantityValue;
    }

    // Now, you have all the submitted data in variables, and the default values are not assumed.

    // You can perform database operations or other processing based on this data.

    // For example, you can insert this data into your database.
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }

    form {
        max-width: 400px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ccc;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 16px;
    }

    input[type="radio"] {
        margin-right: 10px;
    }

    #extraCheckboxes {
        margin-top: 10px;
    }

    .ss {
        margin-right: 5px;
    }

    input[type="submit"] {
        background-color: #007BFF;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>
    <title>Update un Produit</title>
</head>
<body>
<!-- Hidden form to send theIdClicked to PHP -->
<form id="myForm" method="post">
    produits have variables:
    No<input type="radio" id="noRadio" name="variable" value="no" <?php if ($hasVariables === "no") echo 'checked'; ?> />
    Yes<input type="radio" id="yesRadio" name="variable" value="yes" <?php if ($hasVariables === "yes") echo 'checked'; ?> /><br>
    name Product:<input type="text" name="title" required value="<?php echo $productName; ?>"><br>
    quantite:<input type="number" min="0" name="quantite" id="quantityInput" required disabled><br>

    <!-- Container for extra checkboxes -->
    <div id="extraCheckboxes">
        <label>Extra Values:</label><br>
        <?php
        $sql = "SELECT * FROM `size`";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <input class="ss" type="checkbox" name="size[]" value="<?= $row['idSize'] ?>"
                       smiya="<?= $row['sizeValue'] ?>" <?php if (in_array($row['idSize'], $selectedSizes)) echo 'checked'; ?>>
                <?= $row['sizeValue'] ?><br>
            <?php }
        } ?>
    </div>

    <!-- Container for dynamic extra value inputs -->
    <div id="dynamicExtraInputs"></div>

    <input type="submit" name="ok" value="OK">
</form>

<script>
// Get references to the radio buttons, the container for extra checkboxes, and the quantity input
const noRadio = document.getElementById('noRadio');
const yesRadio = document.getElementById('yesRadio');
const extraCheckboxes = document.getElementById('extraCheckboxes');
const quantityInput = document.getElementById('quantityInput');
const dynamicExtraInputs = document.getElementById('dynamicExtraInputs');
const extraCheckboxesList = extraCheckboxes.querySelectorAll('input[type="checkbox"]');

// Function to update dynamic extra value inputs
function updateDynamicExtraInputs() {
    dynamicExtraInputs.innerHTML = ''; // Clear existing dynamic inputs

    extraCheckboxesList.forEach(function (checkbox) {
        const sizeId = checkbox.value;
        if (checkbox.checked) {
            const input = document.createElement('input');
            input.type = 'number';
            input.required = true;
            input.min = '0';
            input.name = 'quantite[' + sizeId + ']'; // Use checkbox value as a unique identifier

            // Access the smiya attribute using getAttribute
            const smiya = checkbox.getAttribute('smiya');

            // Pre-fill input field with quantity from the database based on checkbox value
            const quantityFromDatabase = <?= json_encode($quantities) ?>[sizeId] || 0;
            input.value = quantityFromDatabase;

            dynamicExtraInputs.appendChild(document.createTextNode(smiya + ': '));
            dynamicExtraInputs.appendChild(input);
            dynamicExtraInputs.appendChild(document.createElement('br'));
        }
    });

    // Check the selected radio button and update visibility of extra inputs
    if (yesRadio.checked) {
        extraCheckboxes.style.display = 'block';
        quantityInput.disabled = true; // Disable quantity input when Yes is selected
        dynamicExtraInputs.style.display = 'block';
    } else {
        extraCheckboxes.style.display = 'none';
        quantityInput.disabled = false; // Enable quantity input when No is selected
        dynamicExtraInputs.style.display = 'none';
    }
}

// Initialize the dynamic inputs when the page loads and whenever checkboxes or radio buttons change
updateDynamicExtraInputs();

// Add event listeners to the extra checkboxes
extraCheckboxesList.forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        updateDynamicExtraInputs();
    });
});

// Add event listeners to the radio buttons to show/hide extra checkboxes and disable quantity input
noRadio.addEventListener('change', function () {
    updateDynamicExtraInputs();
});

yesRadio.addEventListener('change', function () {
    updateDynamicExtraInputs();
});

</script>

</body>
</html>
