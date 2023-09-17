<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
</head>
<body>

<h2>Modal Example</h2>
<?php
require('set.php');
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
while ($row = mysqli_fetch_assoc($result)) {
?>
<!-- Trigger/Open The Modal -->
<button class="myBtn" data-id="<?=$row['idP']?>">Open Modal</button>
<?php }} ?>

<!-- The Modal -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">

    <span class="close">&times;</span>
    <p>You clicked <span id="clickedId"></span></p>

    <table>
      <tr>
        <th>idP</th>
        <th>nameP</th>
        <th>sizeValue</th>
        <th>qty</th>
      </tr>
      <?php
      $q="SELECT p.idP AS `idX` ,p.nameP AS `nameX` , s.sizeValue AS `sizeValueX`, pd.qty AS `qtyX`
          FROM product_detail pd
          JOIN product p ON pd.idP = p.idP
          JOIN size s ON pd.idSize = s.idSize
          WHERE p.idP=2";
          $result2 = mysqli_query($conn, $q);
          if (mysqli_num_rows($result2) > 0) {
          while ($row2 = mysqli_fetch_assoc($result2)) {
      ?>
      <tr>
        <th><?=$row2['idX']?></th>
        <th><?=$row2['nameX']?></th>
        <th><?=$row2['sizeValueX']?></th>
        <th><?=$row2['qtyX']?></th>
      </tr>
      <?php }} ?>
    </table>
  </div>
</div>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// Function to open the modal with the clicked ID
function openModal(id) {
  var modalContent = document.getElementById("clickedId");
  modalContent.textContent = id;
  modal.style.display = "block";
}

// Add click event listeners to all buttons with class "myBtn"
var buttons = document.querySelectorAll(".myBtn");
buttons.forEach(function(button) {
  button.addEventListener("click", function() {
    var id = this.getAttribute("data-id");
    openModal(id);
  });
});

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

</body>
</html>
