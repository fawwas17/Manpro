<?php
ob_start();

require_once '../Composer/vendor/tecnickcom/tcpdf/tcpdf.php';

// Koneksi database
require_once "../core.php";
require_once "../koneksi.php";

// Fungsi untuk menghasilkan laporan PDF
function generateLaporanPdf($oid, $returnContent = false)
{
  global $mysqli;

  // Query for order and user details
  $sqlOrder = "SELECT o.*, u.username, u.contact_no FROM `order` o JOIN user u ON o.uid = u.uid WHERE o.oid = ?";
  $stmt = $mysqli->prepare($sqlOrder);
  $stmt->bind_param('i', $oid);
  $stmt->execute();
  $result = $stmt->get_result();
  $order = $result->fetch_assoc();

  // Query for order items
  $sqlItems = "SELECT oi.*, p.productname FROM orderitem oi JOIN product p ON oi.pid = p.pid WHERE oi.oid = ?";
  $stmt = $mysqli->prepare($sqlItems);
  $stmt->bind_param('i', $oid);
  $stmt->execute();
  $result = $stmt->get_result();
  $order_items = array();
  while ($row_item = $result->fetch_assoc()) {
    $order_items[] = $row_item;
  }

  // Set up
  $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf->SetCreator('TCPDF');
  $pdf->SetAuthor('Paws Store');
  $pdf->SetTitle('Laporan Belanja');
  $pdf->SetSubject('Laporan Belanja');
  $pdf->SetKeywords('laporan, belanja, paws, store');
  $pdf->AddPage();

  // Title
  $pdf->SetFont('Helvetica', 'B', 24);
  $pdf->Cell(0, 10, 'Laporan Belanja', 0, 1, 'C');
  $pdf->Ln(10);

  // order details
  $pdf->SetFont('Helvetica', '', 12);
  $pdf->Cell(55, 10, '', 0, 0, 'L');
  $pdf->Cell(90, 10, 'User ID: ' . $order['uid'], 0, 0, 'L');
  $pdf->Cell(90, 10, 'Tanggal: ' . $order['time'], 0, 1, 'L');

  $pdf->Cell(55, 10, '', 0, 0, 'L');
  $pdf->Cell(90, 10, 'Nama: ' . $order['username'], 0, 0, 'L');

  // Check the payment method
  if ($order['payment_method'] === 'Postpaid') {
    $pdf->Cell(90, 10, 'No Kartu: -', 0, 1, 'L');
    $pdf->Cell(90, 10, 'Metode: COD', 0, 0, 'L');
  } else {
    $pdf->Cell(90, 10, 'No Kartu: ' . $order['acc_number'], 0, 1, 'L');
    $pdf->Cell(55, 10, '', 0, 0, 'L');
    $pdf->Cell(90, 10, 'Bank: ' . $order['bank'], 0, 0, 'L');
  }

  $pdf->Cell(90, 10, 'Alamat: ' . $order['address'], 0, 1, 'L');
  $pdf->Cell(55, 10, '', 0, 0, 'L');
  $pdf->Cell(90, 10, 'No HP: ' . $order['contact_no'], 0, 0, 'L');
  $pdf->Cell(90, 10, 'Cara Bayar: ' . $order['payment_method'], 0, 1, 'L');

  $pdf->Ln(10);

  // table header
  $pdf->Cell(55, 10, '', 0, 0, 'L');
  $pdf->SetFont('Helvetica', 'B', 12);
  $pdf->Cell(10, 10, 'No', 1, 0, 'C');
  $pdf->Cell(80, 10, 'Nama Produk (ID)', 1, 0, 'C');
  $pdf->Cell(40, 10, 'Jumlah', 1, 0, 'C');
  $pdf->Cell(50, 10, 'Sub Total', 1, 1, 'C');

  // table content
  $pdf->SetFont('Helvetica', '', 12);
  $no = 1;
  $total = 0;
  foreach ($order_items as $item) {
    $pdf->Cell(55, 10, '', 0, 0, 'L');
    $pdf->Cell(10, 10, $no++, 1, 0, 'C');
    $pdf->Cell(80, 10, $item['productname'] . ' - ' . $item['pid'], 1, 0, 'L');
    $pdf->Cell(40, 10, $item['qty'], 1, 0, 'C');
    $pdf->Cell(50, 10, 'Rp ' . number_format($item['item_price'] * $item['qty'], 2, ',', '.'), 1, 1, 'R');
    $total += $item['item_price'] * $item['qty'];
  }

  // Total
  $pdf->Ln(10);
  $pdf->SetFont('Helvetica', 'B', 12);
  $pdf->Cell(235, 10, 'Rp ' . number_format($total, 2, ',', '.'), 0, 1, 'R');

  // Save or Output PDF
  if ($returnContent) {
    return $pdf->Output('', 'S');
  } else {
    $pdf->Output('laporan_' . $oid . '.pdf', 'I');
  }
}
?>