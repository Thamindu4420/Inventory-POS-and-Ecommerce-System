<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


// Function to Check if the 'id' parameter exists in the URL (for delete action)
if (isset($_GET['delete_id'])) {
  $deleteId = $_GET['delete_id'];

  // Function to Perform the delete action 
  $sqlDelete = "DELETE FROM customers WHERE customer_id = ?";
  $stmtDelete = $conn->prepare($sqlDelete);
  $stmtDelete->bind_param("i", $deleteId);

  if ($stmtDelete->execute()) {
    // Delete successful
    header("Location: http://localhost/Kumara%20Stores%20Inventory_system/Customers/");
    exit;
  } else {
    // Error in SQL execution
    echo "Error deleting record: " . $stmtDelete->error;
  }

  $stmtDelete->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecommerce Manage Slider</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header">
    <div class="rectangle"></div>
    <div class="admin-panel-text">E-Commerce Admin Panel</div>
  </div>
    </div>

<!-- "Customers" and "Home > Customers" texts -->

    <div class="texts">
    <div class="customers-text">Customers</div>
    <div class="breadcrumb-text">Home &gt; Customers</div>
  </div>
  <div>

<div hr class="heading-line">
  </div>
  <div>

<!-- Print Button -->
<button class="print-button" onclick="printCustomersTable()">
    <span class="button-text">Print</span>
</button>
</div>
  <!-- Search text box -->
  <div class="search-box">
  <input type="text" id="searchInput" placeholder="Search Customer">
</div>

<script>
function searchCustomers() {
  // Get the search input value
  var input, filter, table, tr, td, i, j, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.querySelector(".customers");
  tr = table.getElementsByTagName("tr");

  // Start the loop from the second row (index 1) to avoid searching in headings
  for (i = 1; i < tr.length; i++) {
    var rowVisible = false; 

    // Loop through all columns in each row
    for (j = 0; j < tr[i].cells.length - 1; j++) {
      td = tr[i].getElementsByTagName("td")[j];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          
          tr[i].style.display = "";
          rowVisible = true;
          break; 
        }
      }
    }

    // If no column in the row matches the search, hide the row
    if (!rowVisible) {
      tr[i].style.display = "none";
    }
  }
}

// Attach the searchSupplier function to the "input" event of the search input
document.getElementById("searchInput").addEventListener("input", searchCustomers);
</script>



<!-- Table for Customers -->
<table class="customers" style="transform: translateY(40px);">
    <thead>
      <tr>
        <th style="width: 20%;">Name</th>
        <th style="width: 20%;">Email</th>
        <th style="width: 20%;">Address</th>
        <th style="width: 10%;">City</th>
        <th style="width: 10%;">Country</th>
        <th style="width: 10%;">Contact</th>
        <th class="action-header" style="width: 10%;">Action</th>
      </tr>
    </thead>
    <tbody>
    <?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// SQL query to fetch customer data from the database
$sql = "SELECT * FROM customers";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {

  // Loop through the results and populate the table rows
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['address'] . "</td>";
    echo "<td>" . $row['city'] . "</td>";
    echo "<td>" . $row['country'] . "</td>";
    echo "<td>" . $row['contact'] . "</td>";
    echo "<td class='action-column'>";
    echo "<a href='?delete_id=" . $row["customer_id"] . "' onclick='return confirm(\"Are you sure you want to delete this Customer?\");'>";
          echo "<button class='delete-button'>";
          echo "<img src='https://icons.veryicon.com/png/o/transport/shopping-mall/delete-127.png' alt='Delete'>";
          echo "</button>";
          echo "</a>";
    echo "</td>";
    echo "</tr>";
  }

  // Close the table
  echo "</tbody>";
  echo "</table>";

  // Free result set
  mysqli_free_result($result);
} else {
  echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
    </tbody>
  </table>


  <script>
  function printCustomersTable() {
    const table = document.querySelector('.customers');

    if (table) {
      // Clone the table to modify without affecting the original
      const printableTable = table.cloneNode(true);

      // Remove the Action column from the cloned table
      const actionColumnCells = printableTable.querySelectorAll('td.action-column');
      actionColumnCells.forEach(cell => {
        cell.remove();
      });

      // Remove the Action column heading from the cloned table
      const actionColumnHeading = printableTable.querySelector('th.action-header');
      if (actionColumnHeading) {
        const headerRow = actionColumnHeading.parentNode;
        headerRow.removeChild(actionColumnHeading);
      }

      // Create a new window for printing
      const printWindow = window.open('', '_blank');

      // Write the HTML content for the modified table
      let tableContent = '<html><head><title>Print Customers Table</title>';
      tableContent += '<style>';
      tableContent += 'body { font-family: "Segoe UI", sans-serif; }';
      tableContent += 'table { width: 100%; border-collapse: collapse; }';
      tableContent += 'th, td { border: 1px solid black; padding: 8px; text-align: left; }';
      tableContent += 'th { background-color: #a7e5ff; color: black; }'; 
      tableContent += 'td { color: black; }';
      tableContent += 'h1 { text-align: center; }';
      tableContent += 'img.logo { display: block; margin-left: 50px; width: 50px; height: 50px; float: left; }'; 
      tableContent += '.store-text { display: block; margin-left: 70px; }';
      tableContent += '</style>';
      tableContent += '</head><body>';
      tableContent += '<h1><img class="logo" src="https://i.ibb.co/jrp6hSp/Screenshot-1183.png" alt="Kumara Stores Logo"><span class="store-text">Kumara Stores</span></h1>'; 
      tableContent += printableTable.outerHTML; 

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