<?php

require('../set.php');
session_start();
if (!isset($_SESSION['id']) || $_SESSION['role'] !== "admin") {
    header('Location: ../Authentification/');
}

require('fpdf/fpdf.php'); // Include the FPDF library

if (isset($_GET['order_id'])) {
    $orderID = $_GET['order_id'];
    $order = "SELECT * FROM `orders` WHERE order_id = $orderID";
    $exec = mysqli_query($conn, $order);
    $orderData = mysqli_fetch_assoc($exec);
}

// Create a PDF object
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Add content to the PDF
$pdf->Cell(0, 10, 'Order Nr: ' . $orderID, 0, 1, 'C');
$pdf->Ln(10);
$pdf->Cell(0, 10, 'Sosiete', 0, 1, 'L');
$pdf->Cell(0, 10, 'buyer_name: ' . $orderData['buyer_name'], 0, 1, 'L');
$pdf->Cell(0, 10, 'mail_address: ' . $orderData['mail_address'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Fix: ' . $orderData['phoneNumber'], 0, 1, 'L');
$pdf->Cell(0, 10, 'company_name: ' . $orderData['company_name'], 0, 1, 'L');
$pdf->Cell(0, 10, 'address: ' . $orderData['address'], 0, 1, 'L');

$pdf->Ln(10);
$pdf->Cell(0, 10, 'Detait de Devis No: ' . $orderID, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 12);

$pdf->Ln(10);

$pdf->Cell(20, 10, 'idP', 1);
$pdf->Cell(40, 10, 'nameP', 1);
$pdf->Cell(30, 10, 'Sizes', 1);
$pdf->Cell(30, 10, 'PU (DH)', 1);
$pdf->Cell(20, 10, 'QTY', 1);
$pdf->Cell(30, 10, 'PU * QTY', 1);
$pdf->Ln();


        $total = 0; // Initialize the total variable
        $q = "SELECT
                    od.id_OPQ,
                    o.order_id orderId,
                    p.idP AS idProduct,
                    p.nameP AS ProductName,
                    s.sizeValue AS Size,
                    p.prixP AS PricePerUnit,
                    od.Qty AS Quantity
                FROM
                    order_detail od
                INNER JOIN
                    orders o ON od.order_id = o.order_id
                INNER JOIN
                    product p ON od.idP = p.idP
                LEFT JOIN
                    size s ON od.idSize = s.idSize
                WHERE
                    o.order_id = $orderID
                    AND s.idSize IS NULL";
        $res = mysqli_query($conn, $q);
                $q2 = "SELECT
                        od.id_OPQ,
                        o.order_id orderId,
                        p.idP AS idProduct,
                        p.nameP AS ProductName,
                        s.sizeValue AS Size,
                        p.prixP AS PricePerUnit,
                        od.Qty AS Quantity
                    FROM
                        order_detail od
                    INNER JOIN
                        orders o ON od.order_id = o.order_id
                    INNER JOIN
                        product p ON od.idP = p.idP
                    LEFT JOIN
                        size s ON od.idSize = s.idSize
                    WHERE
                        o.order_id = $orderID
                        AND s.idSize IS NOT NULL";
        $res2 = mysqli_query($conn, $q2);

        while ($d = mysqli_fetch_assoc($res)) {
		    $subtotal = $d['PricePerUnit'] * $d['Quantity']; // Calculate the subtotal for this row
		    $total += $subtotal; // Add to the total

		    $pdf->Cell(20, 10, $d['idProduct'], 1);
		    $pdf->Cell(40, 10, $d['ProductName'], 1);
		    $pdf->Cell(30, 10, '-----', 1);
		    $pdf->Cell(30, 10, $d['PricePerUnit'] . ' DH', 1);
		    $pdf->Cell(20, 10, $d['Quantity'] . ' DH', 1);
		    $pdf->Cell(30, 10, $subtotal . ' DH', 1);
		    $pdf->Ln();
		}

		while ($d2 = mysqli_fetch_assoc($res2)) {
		    $subtotal = $d2['PricePerUnit'] * $d2['Quantity']; // Calculate the subtotal for this row
		    $total += $subtotal; // Add to the total

		    $pdf->Cell(20, 10, $d2['idProduct'], 1);
		    $pdf->Cell(40, 10, $d2['ProductName'], 1);
		    $pdf->Cell(30, 10, $d2['Size'], 1);
		    $pdf->Cell(30, 10, $d2['PricePerUnit'] . ' DH', 1);
		    $pdf->Cell(20, 10, $d2['Quantity'] . ' DH', 1);
		    $pdf->Cell(30, 10, $subtotal . ' DH', 1);
		    $pdf->Ln();
		}

		$pdf->Ln(10);
		$pdf->Cell(0, 10, 'TOTAL: ' . $total . ' DH', 0, 1, 'R');

		// Output the PDF to the browser
		$pdf->Output();
		        
        ?>

