<?php 
 
require_once "db.php";
require_once "auth.php";

if (isset($_GET["q"])) {
  // an invoice was picked on new-payment.php: return its details
  $invoice_query = db_query($conn, "SELECT * from `invoicesView` where `invoiceNumber`=?", [$_GET['q']]);
  $record = $invoice_query ? mysqli_fetch_array($invoice_query, MYSQLI_BOTH) : null;
  if (!$record) {
    exit;
  }

  $tenantId = htmlspecialchars($record['tenantID']);
  $invoicedate = htmlspecialchars($record['dateOfInvoice']);
  $dueDate = htmlspecialchars($record['dateDue']);
  $amountDue = htmlspecialchars($record['amountDue']);

  echo "
  <label>Invoice Date: <i>$invoicedate</i> </label><br>
  <label>Invoice Due Date: <i>$dueDate</i> </label><br>
  <label>Expected Amount: <i>KSh. $amountDue</i> </label><br>
    <br>

  <div class='form-group hidden'>
        <label for='amount'>Expected Amount: </label>
      <div class='input-group'>
          <div class='input-group-addon'><i class='fa fa-usd'></i></div>
          <input type='text' name='amountDue' class='form-control' id='amount' value='$amountDue' readonly=''> 
      </div>
  </div>

  <div class='form-group hidden'>
        <label for='tenID'>Tetant ID.: </label>
      <div class='input-group'>
          <div class='input-group-addon'><i class='fa fa-user'></i></div>
          <input type='text' name='tenID' class='form-control' id='tenID' value='$tenantId' readonly=''> 
      </div>
  </div>


    ";

	
}

	

?>