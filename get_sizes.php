<?php
require('set.php');

if (isset($_GET["product_id"])) {
    $productId = $_GET["product_id"];
    $sizesHtml = "";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT s.idSize, s.sizeValue 
                            FROM `size` s
                            LEFT JOIN `product_detail` pd 
                            ON s.idSize = pd.idSize AND pd.idP = ? 
                            WHERE pd.qty IS NOT NULL");

    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sizeId = $row["idSize"];
            $sizeValue = $row["sizeValue"];
            $sizesHtml .= "<option value='$sizeId'>$sizeValue</option>";
        }
    }

    $stmt->close();
    $conn->close();

    echo $sizesHtml;
}
?>
