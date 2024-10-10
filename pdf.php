<?php
require('fpdf/fpdf.php');
session_start();

// Check if the customer ID and invoice ID are set
if (!isset($_SESSION['customer_id']) || !isset($_GET['invoice_id'])) {
    die("Error: Customer ID or Invoice ID not found.");
}

// Database connection
include 'Connection.php';

// Fetch customer and invoice details
$customer_id = $_SESSION['customer_id'];
$invoice_id = $_GET['invoice_id'];

$customerQuery = $conn->prepare("SELECT Name, Address, mobile_number FROM customer WHERE id = ?");
$customerQuery->bind_param("i", $customer_id);
$customerQuery->execute();
$customerResult = $customerQuery->get_result();
$customer = $customerResult->fetch_assoc();

$invoiceQuery = $conn->prepare("SELECT invoice_number, total_invoice_amount, advance_paid, estimated_delivery_date FROM invoice WHERE id = ?");
$invoiceQuery->bind_param("i", $invoice_id);
$invoiceQuery->execute();
$invoiceResult = $invoiceQuery->get_result();
$invoice = $invoiceResult->fetch_assoc();

$orderQuery = $conn->prepare("SELECT product_type, size, sleeve_type, total_qty FROM orders WHERE invoice_id = ?");
$orderQuery->bind_param("i", $invoice_id);
$orderQuery->execute();
$orderResult = $orderQuery->get_result();

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Invoice Details', 0, 1, 'C');

// Add customer details
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Customer Details', 0, 1);
$pdf->Cell(50, 10, 'Name: ' . $customer['Name'], 0, 1);
$pdf->Cell(50, 10, 'Address: ' . $customer['Address'], 0, 1);
$pdf->Cell(50, 10, 'Mobile Number: ' . $customer['mobile_number'], 0, 1);

// Add invoice details
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Invoice Details', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Invoice Number: ' . $invoice['invoice_number'], 0, 1);
$pdf->Cell(50, 10, 'Total Invoice Amount: ' . $invoice['total_invoice_amount'], 0, 1);
$pdf->Cell(50, 10, 'Advance Paid: ' . $invoice['advance_paid'], 0, 1);
$pdf->Cell(50, 10, 'Estimated Delivery Date: ' . $invoice['estimated_delivery_date'], 0, 1);

// Add order details
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Order Details', 0, 1);
$pdf->SetFont('Arial', '', 12);
while ($order = $orderResult->fetch_assoc()) {
    $pdf->Cell(50, 10, 'Product Type: ' . $order['product_type'], 0, 1);
    $pdf->Cell(50, 10, 'Size: ' . $order['size'], 0, 1);
    $pdf->Cell(50, 10, 'Sleeve Type: ' . $order['sleeve_type'], 0, 1);
    $pdf->Cell(50, 10, 'Total Quantity: ' . $order['total_qty'], 0, 1);
    $pdf->Ln();
}

// Directly output the PDF to browser for download
$pdf->Output('D', 'invoice_' . $invoice['invoice_number'] . '.pdf');  // 'D' forces download

// Close the database connection
$conn->close();
?>
