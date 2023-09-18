<?php
// Check if a button has been clicked and set the value of $theIdClicked
if (isset($_POST['theIdClicked'])) {
    $theIdClicked = $_POST['theIdClicked'];
    echo "Button with data-id $theIdClicked was clicked!";
} else {
    $theIdClicked = ""; // Initialize $theIdClicked if it hasn't been set yet
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Button Click Example</title>
</head>
<body>

<!-- HTML buttons with data-id attributes -->
<button class="myBtn" data-id="1" onclick="setIdClicked(1)">Open Modal 1</button>
<button class="myBtn" data-id="2" onclick="setIdClicked(2)">Open Modal 2</button>
<button class="myBtn" data-id="9" onclick="setIdClicked(9)">Open Modal 9</button>

<!-- JavaScript to set the value of theIdClicked -->
<script>
    var theIdClicked = <?php echo json_encode($theIdClicked); ?>;

    function setIdClicked(id) {
        theIdClicked = id;
        document.getElementById('theIdClickedInput').value = id; // Update a hidden input field
        document.getElementById('myForm').submit(); // Submit the form to update PHP variable
    }
</script>

<!-- Hidden form to send theIdClicked to PHP -->
<form id="myForm" method="post" style="display: none;">
    <input type="hidden" name="theIdClicked" id="theIdClickedInput">
</form>

</body>
</html>
