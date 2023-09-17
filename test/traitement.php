<?php
require("../set.php");

session_start();
$idT = $_SESSION['id'];
$passT = $_SESSION['pass'];

if (isset($_POST['ok'])) {
  $met = "SELECT * FROM `users` WHERE idUser = '$idT'";
  $res = mysqli_query($conn, $met);
  if (mysqli_num_rows($res) > 0) {
    $client = mysqli_fetch_assoc($res);
  }

  // Handle image upload
  if ($_FILES['fileInput']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['fileInput']['tmp_name'];
    $fileName = $_FILES['fileInput']['name'];
    $destination = "../../imgUser/" . $fileName;

    // Delete the old image if it exists
    if (!empty($client['imgUser'])) {
      $oldImage = "../../imgUser/" . $client['imgUser'];
      if (file_exists($oldImage)) {
        unlink($oldImage);
      }
    }

    // Move uploaded file to the desired destination
    if (move_uploaded_file($file, $destination)) {
      // Update the image name in the database
      $updateQuery = "UPDATE `users` SET imgUser = '$fileName' WHERE idUser = '$idT'";
      mysqli_query($conn, $updateQuery);

      // Update the $client array with the new image name
      $client['imgUser'] = $fileName;
      $_SESSION['img']=$fileName;
    }

  }

  $update = "UPDATE `users` SET `fullname` = '{$_POST['fullname']}', `birthday` = '{$_POST['birthday']}' WHERE `users`.`idUser` = '$idT'";
  $exec = mysqli_query($conn, $update);
  header("Location: edit_profile_admin.php");
  exit;
} else if (isset($_POST['passUpdate'])) {
  $oldpass = $_POST['oldpass'];
  $newpass = $_POST['newpass'];
  $newpasscheck = $_POST['newpasscheck'];

  if ($passT == $oldpass && $newpass == $newpasscheck) {
    $_SESSION['id'] = $idT;
    $_SESSION['pass'] = $newpass;
    $update = "UPDATE `users` SET `pass` = '{$_POST['newpass']}' WHERE `users`.`idUser` = '$idT'";
    $exec = mysqli_query($conn, $update);
    header("Location: edit_profile_admin.php");
    exit;
  } else {
    header("Location: edit_profile_admin.php");
    exit;
  }
}
?>
