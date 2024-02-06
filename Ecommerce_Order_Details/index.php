<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}



// Get the customer name and sub_total from the URL query parameters
if (isset($_GET['name']) && isset($_GET['sub_total'])) {
  $customerName = $_GET['name'];
  $subTotal = $_GET['sub_total'];
  
  // Fetch customer details based on the name and sub_total
  $sql = "SELECT address, contact_number FROM customer_orders WHERE name = '$customerName' AND sub_total = '$subTotal'";
  $result = mysqli_query($conn, $sql);

  if (!$result) {
    die("Error: " . $sql . "<br>" . mysqli_error($conn));
  }

  // Fetch the first row of the result (assuming there's only one matching row)
  $row = mysqli_fetch_assoc($result);

  // Extract shipping address and mobile from the row
  $shippingAddress = $row['address'];
  $shippingMobile = $row['contact_number'];
  
  
  $orderDetailsSql = "SELECT product_name, price, quantity, total_price FROM customer_orders WHERE name = '$customerName' AND sub_total = '$subTotal'";
  $orderDetailsResult = mysqli_query($conn, $orderDetailsSql);
} else {
  
  echo "Customer details not found.";
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecommerce Manage Order</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header">
    <div class="rectangle"></div>
    <div class="admin-panel-text">E-Commerce Admin Panel</div>
  </div>
    </div>

<!-- "Order Details" and "Home > Order Details" texts -->

    <div class="texts">
    <div class="order-details-text">Order Details</div>
    <div class="breadcrumb-text">Home &gt; Order Details</div>
  </div>
  <div>

<div hr class="heading-line">
  </div>
  <div>

<!-- Print Button -->
<button class="print-button" onclick="printTable()">
    <span class="button-text">Print</span>
</button>
</div>


<!-- "Customer Info" Heading -->
<div class="customer-info-heading">Customer Info</div>

<!-- Customer Info Form -->
<div class="customer-info-form">

   
<div class="form-group">
      <label for="shipping-name">Shipping Name:</label>
      <input type="text" id="shipping-name" name="shipping-name" value="<?php echo $customerName; ?>">
    </div>

    <div class="form-group">
      <label for="shipping-address">Shipping Address:</label>
      <input type="text" id="shipping-address" name="shipping-address" value="<?php echo $shippingAddress; ?>">
    </div>

    <div class="form-group">
      <label for="shipping-mobile">Shipping Mobile:</label>
      <input type="text" id="shipping-mobile" name="shipping-mobile" value="<?php echo $shippingMobile; ?>">
    </div>
  </div>


<!-- Table for Order Details -->
<table class="order-details" style="transform: translateY(40px);">
    <thead>
      <tr>
        <th style="width: 30%;">Product Name</th>
        <th style="width: 20%;">Product Price</th>
        <th style="width: 20%;">Quantity</th>
        <th style="width: 30%;">Product Subtotal</th>
      </tr>
    </thead>
    <tbody>
     <?php
      // Loop through the fetched order details and populate the table rows
      while ($orderRow = mysqli_fetch_assoc($orderDetailsResult)) {
        echo "<tr>";
        echo "<td>" . $orderRow['product_name'] . "</td>";
        echo "<td>Rs. " . $orderRow['price'] . "</td>";
        echo "<td>" . $orderRow['quantity'] . "</td>";
        echo "<td>Rs. " . $orderRow['total_price'] . "</td>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>


<!-- Table for Order Details -->

<div class="total-amount">
    <label for="total-amount">Total Amount:</label>
    <input type="text" id="total-amount" name="total-amount" value="<?php echo 'Rs. ' . $subTotal; ?>">
  </div>


<script>
  function printTable() {
    const table = document.querySelector('.order-details');
    if (table) {
      // Create a new window for printing
      const printWindow = window.open('', '_blank');

      
      let tableContent = '<html><head><title>Print Table</title>';
      tableContent += '<style>';
      tableContent += 'body { font-family: "Segoe UI", sans-serif; }';
      tableContent += 'table { width: 100%; border-collapse: collapse; }';
      tableContent += 'th, td { border: 1px solid black; padding: 8px; text-align: left; }';
      tableContent += 'th, td { color: black; }'; 
      tableContent += 'h1 { text-align: center; }';
      tableContent += 'img.logo { display: block; margin-left: 50px; width: 50px; height: 50px; float: left; }'; 
      tableContent += '.store-text { display: block; margin-left: 70px; }'; 
      tableContent += '.shipping-info { margin-left: 50px; }'; 
      tableContent += '.total-amount { margin-left: 50px; margin-top: 20px; }';
      tableContent += '</style>';
      tableContent += '</head><body>';
      tableContent += '<h1><img class="logo" src="https://i.ibb.co/jrp6hSp/Screenshot-1183.png" alt="Kumara Stores Logo"><span class="store-text">Kumara Stores</span></h1>'; 
      tableContent += '<div class="shipping-info">';
      tableContent += '<p><strong>Shipping Name:</strong> <?php echo $customerName; ?></p>';
      tableContent += '<p><strong>Shipping Address:</strong> <?php echo $shippingAddress; ?></p>';
      tableContent += '<p><strong>Shipping Mobile:</strong> <?php echo $shippingMobile; ?></p>';
      tableContent += '</div>';
      tableContent += '<table>';

      // Get the table headings (first row in the table)
      const tableHeadings = table.querySelector('thead tr');

      // Include table headings in the table
      tableContent += '<thead>';
      tableContent += '<tr>';
      tableHeadings.querySelectorAll('th').forEach(heading => {
        tableContent += '<th>';
        tableContent += heading.textContent; 
        tableContent += '</th>';
      });
      tableContent += '</tr>';
      tableContent += '</thead>';

      // Get all rows in the table body
      const rows = table.querySelectorAll('tbody tr');

      // Loop through rows and columns
      rows.forEach(row => {
        tableContent += '<tr>';
        row.querySelectorAll('td').forEach(column => {
          tableContent += '<td>';
          tableContent += column.textContent; 
          tableContent += '</td>';
        });
        tableContent += '</tr>';
      });

      tableContent += '</table>';
      tableContent += '<div class="total-amount">';
      tableContent += '<p><strong>Total Amount:</strong> <?php echo "Rs. " . $subTotal; ?></p>';
      tableContent += '</div>';
      tableContent += '</body></html>';

      // Write the table content to the new window and initiate the printing process
      printWindow.document.write(tableContent);
      printWindow.document.close();
      printWindow.print();
    }
  }
</script>






<!-- Sidebar -->

<div class="sidebar" style="transform: translateY(110px);">
    <ul class="menu">
      <li><img src="https://icon-library.com/images/meter-icon/meter-icon-1.jpg" alt="Dashboard"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Admin_Dashboard/">Dashboard</a></li>
      <li><img src="https://toppng.com/uploads/preview/eye-icon-11563577054kb8jtnflax.png" alt="Complaints"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Admin_Complaints/">Complaints</a></li>
      <li><img src="https://cdn-icons-png.flaticon.com/512/25/25645.png" alt="Add Slider"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Slider/">Add Slider</a></li>
      <li><img src="https://icon-library.com/images/free-file-icon/free-file-icon-28.jpg" alt="Manage Slider"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Slider/">Manage Slider</a></li>
      <li><img src="https://www.svgrepo.com//show/8335/list.svg" alt="Customers"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Customers/">Customers</a></li>
      <li><img src="https://cdn-icons-png.flaticon.com/512/55/55281.png" alt="Manage Order"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Manage_Order/">Manage Order</a></li>
      <li><img src="https://banner2.cleanpng.com/20180508/uyw/kisspng-power-symbol-computer-icons-5af247e6b7df19.0515539515258275587532.jpg" alt="Logout"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Admin_login/">Logout</a></li>
    </div>
    </ul>
  </div>
  

<!--Kumara Stores Logo-->
<div class="logo">
  <img src="https://i.ibb.co/jrp6hSp/Screenshot-1183.png" alt="Logo">
</div>
</div>


<script>
  // Disable zooming on the page
  function disableZoom() {
    document.addEventListener('keydown', function (event) {
      if (event.ctrlKey === true || event.metaKey) {
        event.preventDefault();
      }
    }, false);

    window.addEventListener('wheel', function (event) {
      if (event.ctrlKey === true || event.metaKey) {
        event.preventDefault();
      }
    }, { passive: false });

    document.addEventListener('gesturestart', function (e) {
      e.preventDefault();
    });
  }

  // function to disable zooming
  disableZoom();

</script>


</body>
</html>