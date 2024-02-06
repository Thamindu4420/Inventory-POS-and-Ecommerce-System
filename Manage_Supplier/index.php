<?php

include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


// Fetch data from the suppliers table
$sql = "SELECT * FROM suppliers"; 
$result = mysqli_query($conn, $sql);

// Create an array to store the retrieved data
$supplierData = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $supplierData[] = $row;
    }
}


// Check if the POST request contains the supplier ID to delete
if (isset($_POST["deleteSupplierId"])) {
  $deleteSupplierId = mysqli_real_escape_string($conn, $_POST["deleteSupplierId"]);

  // Perform the deletion query
  $deleteSql = "DELETE FROM suppliers WHERE supplier_id = '$deleteSupplierId'";

  if (mysqli_query($conn, $deleteSql)) {
    // Deletion was successful
    echo "success";
  } else {
    // Deletion failed
    echo "error";
  }

  // End the script execution after processing the deletion
  exit();
}

?>






<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Suppliers</title>
  <link rel="stylesheet" href="style.css">

</head>

<body>
<div class="header">
    <div class="rectangle"></div>
</div>
<div class="content">

  <!-- "Manage Supplier" and "Home > Supplier" texts -->
  <div class="texts">
    <div class="manage-supplier-text">Manage Supplier</div>
    <div class="breadcrumb-text">Home &gt; Supplier</div>
  </div>

  <div hr class="heading-line">
  </div>


<!-- Add Supplier Button -->
<a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Supplier/">
  <button class="add-supplier-button">
    <span class="button-text">Add Supplier</span>
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
  <input type="text" id="searchInput" placeholder="Search Supplier">
</div>

<script>
function searchSupplier() {
  // Get the search input value
  var input, filter, table, tr, td, i, j, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.querySelector(".supplier-table");
  tr = table.getElementsByTagName("tr");

  
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


document.getElementById("searchInput").addEventListener("input", searchSupplier);
</script>


<!-- Table -->
<table class="supplier-table" style="transform: translateY(40px);">
  <thead>
    <tr>
      <th style="width: 10%;">Company</th>
      <th style="width: 20%;">Supplier Name</th>
      <th style="width: 11.6%;">Contact Number</th>
      <th style="width: 11.6%;">Supply Date</th>
      <th style="width: 11.6%;">Quantity</th>
      <th style="width: 11.6%;">Amount</th>
      <th style="width: 11.6%;">Payment Status</th>
      <th style="width: 11.6%;">Action</th>
    </tr>
  </thead>
  <tbody>

  <?php
        // Loop through the supplier data and generate table rows
        foreach ($supplierData as $supplier) {
            echo "<tr>";
            echo "<td>" . $supplier['company'] . "</td>";
            echo "<td>" . $supplier['supplier_name'] . "</td>";
            echo "<td>" . $supplier['contact_number'] . "</td>";
            echo "<td>" . $supplier['supply_date'] . "</td>";
            echo "<td>" . $supplier['quantity'] . "</td>";
            echo "<td>" . $supplier['amount'] . "</td>";
            echo "<td>" . $supplier['payment_status'] . "</td>";
            echo "<td class='action-column'>
                        <a href='http://localhost/Kumara%20Stores%20Inventory_system/Add_Supplier/?edit=" . $supplier["supplier_id"] . "'>
                        <button class='edit-button'>
                        <img class='button-icon' src='https://www.freeiconspng.com/thumbs/edit-icon-png/edit-editor-pen-pencil-write-icon--4.png' alt='Edit'>
                          </button>
                     </a>
                     <button class='delete-button' onclick='deleteSupplier(" . $supplier["supplier_id"] . ")'>
                         <img class='button-icon' src='https://icons.veryicon.com/png/o/transport/shopping-mall/delete-127.png' alt='Delete'>
                     </button>
                 </td>";
            echo "</tr>";
        }
        ?>

  </tbody>
</table>

<script>

function printTable() {
  const table = document.querySelector('.supplier-table');

  if (table) {
    // Clone the table to modify without affecting the original
    const printableTable = table.cloneNode(true);

    // Remove the Action column from the cloned table
    const actionColumnCells = printableTable.querySelectorAll('td.action-column');
    actionColumnCells.forEach(cell => {
      cell.remove();
    });

    // Remove the Action column heading from the cloned table
    const actionColumnHeading = printableTable.querySelector('th.action-column');
    if (actionColumnHeading) {
      const headerRow = actionColumnHeading.parentNode;
      headerRow.removeChild(actionColumnHeading);
    }

    // Create a new window for printing
    const printWindow = window.open('', '_blank');

    // Write the HTML content for the modified table
    let tableContent = '<html><head><title>Print Supplier Table</title>';
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



 // Function to delete a supplier
 function deleteSupplier(supplierId) {
      // Confirm with the user before deleting
      if (confirm("Are you sure you want to delete this supplier?")) {
        // Send an AJAX request to delete the supplier
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "", true); // Leave the URL empty to send the request to the same page
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
            // Check the response from the server
            if (xhr.responseText === "success") {
              // Supplier deleted successfully, you can remove the table row
              var row = document.querySelector(".supplier-table tr[data-supplier-id='" + supplierId + "']");
              if (row) {
                row.parentNode.removeChild(row);
              }
            } else {
              alert("Failed to delete supplier. Please try again later.");
            }
          }
        };
        xhr.send("deleteSupplierId=" + supplierId);
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
    <script src="script.js"></script>
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
