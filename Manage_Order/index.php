<?php
include "db_connect.php";


if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders</title>
  <link rel="stylesheet" href="style.css">

  

</head>
<body>
<div class="header">
    <div class="rectangle"></div>
</div>
<div class="content">
  <!-- "Manage Order" and "Home > Orders" texts -->
  <div class="texts">
    <div class="manage-order-text">Manage Orders</div>
    <div class="breadcrumb-text">Home &gt; Orders</div>
  </div>
  <div>
  <!-- Add Order Button -->
  <a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Order/">
  <button class="add-order-button">
    <span class="button-text">Add Order</span>
  </button>
  </a>
<div>
  <!-- Print Button -->
  <button class="print-button" onclick="printTable()">
    <span class="button-text">Print</span>
  </button>
</div>
  <!-- Search text box -->
  <div class="search-box">
  <input type="text" id="searchInput" placeholder="Search Order">
</div>

<script>
function searchOrder() {
  // Get the search input value
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.querySelector(".orders-table");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows and hide those that do not match the search query
  for (i = 0; i < tr.length; i++) {
    var tdId = tr[i].getElementsByTagName("td")[0]; // Order ID column
    var tdClient = tr[i].getElementsByTagName("td")[1]; // Client column
    var tdPaymentStatus = tr[i].getElementsByTagName("td")[4]; // Payment Status column

    if (tdId || tdClient || tdPaymentStatus) {
      var idText = tdId.textContent || tdId.innerText;
      var clientText = tdClient.textContent || tdClient.innerText;
      var paymentStatusText = tdPaymentStatus.textContent || tdPaymentStatus.innerText;

      // Function to Check if the search query matches any of the columns
      if (
        idText.toUpperCase().indexOf(filter) > -1 ||
        clientText.toUpperCase().indexOf(filter) > -1 ||
        paymentStatusText.toUpperCase().indexOf(filter) > -1
      ) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

// Attach the searchOrder function to the "input" event of the search input
document.getElementById("searchInput").addEventListener("input", searchOrder);
</script>


<!-- Table -->
<table class="orders-table" style="transform: translateY(40px);">
  <thead>
    <tr>
      <th style="width: 15%;">Bill.No</th>
      <th style="width: 30%;">Client</th>
      <th style="width: 15%;">Contact</th>
      <th style="width: 15%;">Amount</th>
      <th style="width: 15%;">Payment Status</th>
      <th style="width: 10%;">Action</th>
    </tr>
  </thead>
  <tbody>

  <tr>
  <?php
// Query to fetch orders from the database
$sql = "SELECT order_id, client, contact, net_amount, payment_status FROM orders";
$result = mysqli_query($conn, $sql);

// Check if any orders were found
if (mysqli_num_rows($result) > 0) {
    // Fetch and display each order
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["order_id"] . "</td>";
        echo "<td>" . $row["client"] . "</td>";
        echo "<td>" . $row["contact"] . "</td>";
        echo "<td>" . $row["net_amount"] . "</td>";
        echo "<td>" . $row["payment_status"] . "</td>";
        echo '<td>

        <a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Order/?edit=' . $row["order_id"] . '">
        <button class="edit-button">
          <img class="button-icon" src="https://www.freeiconspng.com/thumbs/edit-icon-png/edit-editor-pen-pencil-write-icon--4.png" alt="Edit">
        </button>
      </a>

        <button class="delete-button" data-order-id="' . $row["order_id"] . '">
        <img class="button-icon" src="https://icons.veryicon.com/png/o/transport/shopping-mall/delete-127.png" alt="Delete">
      </button>
              </td>';
        echo "</tr>";
    }
} else {
    // No orders found
    echo "<tr><td colspan='6'>No orders available.</td></tr>";
}

// Close the database connection
mysqli_close($conn);
  ?>
    </tr>
  </tbody>
</table>

<script>

// Attach a click event listener to all delete buttons
var deleteButtons = document.querySelectorAll(".delete-button");
deleteButtons.forEach(function (button) {
    button.addEventListener("click", function () {
        // Retrieve the order ID from the data attribute
        var orderId = button.getAttribute("data-order-id");
        if (confirm("Are you sure you want to delete this order?")) {
            // Send the order ID to the server for deletion
            deleteOrder(orderId);
        }
    });
});

// Function to send the order ID to the server for deletion
function deleteOrder(orderId) {
    // Send an AJAX request to the server to delete the order
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete_order.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Check the response from the server
            if (xhr.responseText === "success") {
                // Display a success message
                alert("Order deleted successfully.");
                // Reload the page to update the table
                location.reload();
            } else {
                alert("Failed to delete the order.");
            }
        }
    };
    xhr.send("order_id=" + orderId);
}


function printTable() {
  const table = document.querySelector('.orders-table');
  if (table) {
    // Create a new window for printing
    const printWindow = window.open('', '_blank');

    // Write the HTML content for the table header and rows
    let tableContent = '<html><head><title>Print Table</title>';
    tableContent += '<style>';
    tableContent += 'body { font-family: "Segoe UI", sans-serif; }';
    tableContent += 'table { width: 100%; border-collapse: collapse; }';
    tableContent += 'th, td { border: 1px solid black; padding: 8px; text-align: left; }';
    tableContent += 'th, td { color: black; }'; 
    tableContent += 'h1 { text-align: center; }';
    tableContent += 'img.logo { display: block; margin-left: 50px; width: 50px; height: 50px; float: left; }'; 
    tableContent += '.store-text { display: block; margin-left: 70px; }'; 
    tableContent += '</style>';
    tableContent += '</head><body>';
    tableContent += '<h1><img class="logo" src="https://i.ibb.co/jrp6hSp/Screenshot-1183.png" alt="Kumara Stores Logo"><span class="store-text">Kumara Stores</span></h1>'; 
    tableContent += '<table>';

    // Get all rows in the table body
    const rows = table.querySelectorAll('tr');

    // Loop through rows and columns
    rows.forEach(row => {
      tableContent += '<tr>';
      const columns = row.querySelectorAll('td'); 
      columns.forEach(column => {
        tableContent += '<td>';
        tableContent += column.textContent; 
        tableContent += '</td>';
      });
      tableContent += '</tr>';
    });

    tableContent += '</table></body></html>';

    // Write the table content to the new window and initiate the printing process
    printWindow.document.write(tableContent);
    printWindow.document.close();
    printWindow.print();
  }
}



</script>





<!-- Side Bar -->
<div class="sidebar" style="transform: translateY(98px);">
  <ul class="menu">
    <li><img src="https://icon-library.com/images/meter-icon/meter-icon-1.jpg" alt="Dashboard"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Dashboard/">Dashboard</a></li>
    <li><img src="https://www.nicepng.com/png/full/204-2049036_download-3-cube-icon.png" alt="Items"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Items/index.php">Items</a></li>
    <li><img src="https://www.nicepng.com/png/full/204-2049036_download-3-cube-icon.png" alt="Category"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Category/">Category</a></li>
    <li><img src="https://toppng.com/uploads/preview/open-warehouse-icon-font-awesome-11563302767pao8zak6mz.png" alt="Warehouse"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Warehouse/">Warehouse</a></li>
    <li><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5afpx3wsQgzXLHss8vgGV55nP5_B6fdhK6w&usqp=CAU" alt="Elements"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Elements/">Elements</a></li>
    <li class="submenu">
      <img src="https://www.svgrepo.com/show/57782/closed-box.svg" alt="Products"><a href="#">Products</a>
      <span class="dropdown-icon">&#9660;</span>
      <ul class="sub-menu">
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Add Products"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Product/">Add Products</a></li>
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Manage Products"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Product/">Manage Products</a></li>
      </ul>
    </li>
    <li class="submenu">
      <img src="https://cdn3.iconfinder.com/data/icons/pyconic-icons-3-1/512/dollar-512.png" alt="Orders"><a href="#">Orders</a>
      <span class="dropdown-icon">&#9660;</span>
      <ul class="sub-menu">
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Add Orders"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Order/">Add Order</a></li>
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Manage Orders"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Order/">Manage Orders</a></li>
      </ul>
    </li>
    <li class="submenu">
      <img src="https://cdn-icons-png.flaticon.com/512/2118/2118701.png" alt="Members"><a href="#">Members</a>
      <span class="dropdown-icon">&#9660;</span>
      <ul class="sub-menu">
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Add Members"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Member/">Add Members</a></li>
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Manage Members"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Member/">Manage Members</a></li>
      </ul>
    </li>
    <li class="submenu">
      <img src="https://www.freeiconspng.com/thumbs/recycle-icon-png/black-recycle-icon-png-2.png" alt="Suppliers"><a href="#">Suppliers</a>
      <span class="dropdown-icon">&#9660;</span>
      <ul class="sub-menu">
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Add Supplier"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Supplier/">Add Supplier</a></li>
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Manage Suppliers"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Supplier/">Manage Suppliers</a></li>
      </ul>
    </li>
    <li><img src="https://www.iconpacks.net/icons/1/free-building-icon-1062-thumb.png" alt="Invoice"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Invoice/">Invoice</a></li>
    <div>
    <li><img src="https://banner2.cleanpng.com/20180508/uyw/kisspng-power-symbol-computer-icons-5af247e6b7df19.0515539515258275587532.jpg" alt="Logout"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Login/">Logout</a></li>
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