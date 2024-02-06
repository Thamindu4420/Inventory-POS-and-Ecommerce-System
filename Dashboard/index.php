<?php
include "db_connect.php";


if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// SQL query to count Paid orders
$sqlPaidOrders = "SELECT COUNT(*) AS paid_order_count FROM orders WHERE payment_status = 'Paid'";

// Execute the query
$resultPaidOrders = mysqli_query($conn, $sqlPaidOrders);


if ($resultPaidOrders) {
    $rowPaidOrders = mysqli_fetch_assoc($resultPaidOrders);
    $paidOrderCount = $rowPaidOrders['paid_order_count'];
} else {
    // Handle the query error
    $paidOrderCount = 0;
}


// SQL query to count Unpaid orders
$sqlUnpaidOrders = "SELECT COUNT(*) AS unpaid_order_count FROM orders WHERE payment_status = 'Unpaid'";


$resultUnpaidOrders = mysqli_query($conn, $sqlUnpaidOrders);


if ($resultUnpaidOrders) {
    $rowUnpaidOrders = mysqli_fetch_assoc($resultUnpaidOrders);
    $unpaidOrderCount = $rowUnpaidOrders['unpaid_order_count'];
} else {
    // Handle the query error
    $unpaidOrderCount = 0;
}



// SQL query to count total active items
$sqlTotalActiveItems = "SELECT COUNT(*) AS total_item_count FROM items WHERE status = 'active'";


$resultTotalActiveItems = mysqli_query($conn, $sqlTotalActiveItems);


if ($resultTotalActiveItems) {
    $rowTotalActiveItems = mysqli_fetch_assoc($resultTotalActiveItems);
    $totalActiveItemCount = $rowTotalActiveItems['total_item_count'];

    // Store the total active item count in a session variable
    $_SESSION['total_active_items'] = $totalActiveItemCount;
} else {
    // Handle the query error
    $_SESSION['total_active_items'] = 0;
}




// SQL query to count total categories
$sqlTotalActiveCategories = "SELECT COUNT(*) AS total_category_count FROM category WHERE status = 'active'";


$resultTotalActiveCategories = mysqli_query($conn, $sqlTotalActiveCategories);


if ($resultTotalActiveCategories) {
    $rowTotalActiveCategories = mysqli_fetch_assoc($resultTotalActiveCategories);
    $totalActiveCategoryCount = $rowTotalActiveCategories['total_category_count'];

    
    $_SESSION['total_active_categories'] = $totalActiveCategoryCount;
} else {
    
    $_SESSION['total_active_categories'] = 0;
}



// SQL query to count total elements
$sqlTotalActiveElements = "SELECT COUNT(*) AS total_element_count FROM elements WHERE status = 'active'";


$resultTotalActiveElements = mysqli_query($conn, $sqlTotalActiveElements);


if ($resultTotalActiveElements) {
    $rowTotalActiveElements = mysqli_fetch_assoc($resultTotalActiveElements);
    $totalActiveElementCount = $rowTotalActiveElements['total_element_count'];

    // Store the total active element count in a session variable
    $_SESSION['total_active_elements'] = $totalActiveElementCount;
} else {
    
    $_SESSION['total_active_elements'] = 0;
}



// SQL query to count total products
$sqlTotalProducts = "SELECT COUNT(*) AS total_product_count FROM products";


$resultTotalProducts = mysqli_query($conn, $sqlTotalProducts);


if ($resultTotalProducts) {
    $rowTotalProducts = mysqli_fetch_assoc($resultTotalProducts);
    $totalProductCount = $rowTotalProducts['total_product_count'];

    // Store the total product count in a session variable
    $_SESSION['total_products'] = $totalProductCount;
} else {
    
    $_SESSION['total_products'] = 0;
}



// SQL query to count total warehouses
$sqlTotalActiveWarehouses = "SELECT COUNT(*) AS total_warehouse_count FROM warehouse WHERE status = 'active'";


$resultTotalActiveWarehouses = mysqli_query($conn, $sqlTotalActiveWarehouses);


if ($resultTotalActiveWarehouses) {
    $rowTotalActiveWarehouses = mysqli_fetch_assoc($resultTotalActiveWarehouses);
    $totalActiveWarehouseCount = $rowTotalActiveWarehouses['total_warehouse_count'];

    // Store the total active warehouse count in a session variable
    $_SESSION['total_active_warehouses'] = $totalActiveWarehouseCount;
} else {
    
    $_SESSION['total_active_warehouses'] = 0;
}



// SQL query to calculate total sales amount, extracting numeric part and converting to decimal
$sqlTotalSales = "SELECT SUM(CAST(SUBSTRING(net_amount, 4) AS DECIMAL(10, 2))) AS total_sales_amount FROM orders";


$resultTotalSales = mysqli_query($conn, $sqlTotalSales);


if ($resultTotalSales) {
    $rowTotalSales = mysqli_fetch_assoc($resultTotalSales);
    $totalSalesAmount = $rowTotalSales['total_sales_amount'];

    
    if ($totalSalesAmount !== null) {
        
        $formattedTotalSales = number_format($totalSalesAmount, 2); 
    } else {
        
        $formattedTotalSales = '0.00'; 
    }
} else {
    
    $formattedTotalSales = '0.00'; 
}



// SQL query to count total members
$sqlTotalMembers = "SELECT COUNT(*) AS total_member_count FROM users";


$resultTotalMembers = mysqli_query($conn, $sqlTotalMembers);


if ($resultTotalMembers) {
    $rowTotalMembers = mysqli_fetch_assoc($resultTotalMembers);
    $totalMemberCount = $rowTotalMembers['total_member_count'];
} else {
   
    $totalMemberCount = 0;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header">
  <div class="cart-icon">
        <a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Admin_Login/">
            <img src="https://cdn-icons-png.flaticon.com/512/25/25619.png" alt="Cart Icon">
        </a>
    </div>
    <div class="rectangle"></div>
</div>

  <div class="sidebar">
    <ul class="menu">
      <li><img src="https://icon-library.com/images/meter-icon/meter-icon-1.jpg" alt="Dashboard"><a href="">Dashboard</a></li>
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
  <div class="texts">
    <div class="dashboard-text">
      <span class="dashboard-title">Dashboard</span>
      <span class="dashboard-subtitle">Home&gt;Dashboard</span>
    </div>
  </div>
</div>

<!--Kumara Stores Logo-->
<div class="logo">
  <img src="https://i.ibb.co/jrp6hSp/Screenshot-1183.png" alt="Logo">
</div>
</div>

 <!-- The "Total Items" box -->
<div class="info-box total-items-box">
    <div class="total-items">
        <p class="total-items-text">
            <?php
            
            if (isset($_SESSION['total_active_items'])) {
                echo $_SESSION['total_active_items'];
            } else {
                echo '0';
            }
            ?>
            <br>Total Items
        </p>
    </div>
    <div class="more-info total-items-more-info">
        <div class="more-info-strip" onclick="window.location.href='http://localhost/Kumara%20Stores%20Inventory_system/Items/index.php';">
            <p class="more-info-text">More Info</p>
            <img class="more-info-icon" src="https://cdn-icons-png.flaticon.com/512/44/44522.png" alt="More Info Icon">
        </div>
    </div>
</div>



<!-- The "Total Category" box -->
<div class="info-box total-category-box">
  <div class="total-category">
    <p class="total-category-text">
      <?php
        
        if (isset($_SESSION['total_active_categories'])) {
          echo $_SESSION['total_active_categories'];
        } else {
          echo '0';
        }
      ?><br>Total Categories
    </p>
  </div>
  <div class="more-info total-category-more-info">
    <div class="more-info-strip" onclick="window.location.href='http://localhost/Kumara%20Stores%20Inventory_system/Category/';">
      <p class="more-info-text">More Info</p>
      <img class="more-info-icon" src="https://cdn-icons-png.flaticon.com/512/44/44522.png" alt="More Info Icon">
    </div>
  </div>
</div>



<!-- The "Total Elements" box -->
<div class="info-box total-elements-box">
  <div class="total-elements">
    <p class="total-elements-text">
      <?php
        
        if (isset($_SESSION['total_active_elements'])) {
          echo $_SESSION['total_active_elements'];
        } else {
          echo '0';
        }
      ?><br>Total Elements
    </p>  
  </div>
  <div class="more-info total-elements-more-info"> 
    <div class="more-info-strip" onclick="window.location.href='http://localhost/Kumara%20Stores%20Inventory_system/Elements/';">
      <p class="more-info-text">More Info</p>
      <img class="more-info-icon" src="https://cdn-icons-png.flaticon.com/512/44/44522.png" alt="More Info Icon">
    </div>
  </div>
</div>



<!-- The "Total Sales" box -->
<div class="info-box total-sales-box">
  <div class="total-sales">
    <p class="total-sales-text"> Rs. <?php echo $formattedTotalSales; ?><br>Total Sales</p> 
  </div>
  <div class="more-info total-sales-more-info"> 
    <div class="more-info-strip" onclick="window.location.href='http://localhost/Kumara%20Stores%20Inventory_system/Manage_Order/';">
      <p class="more-info-text">More Info</p>
      <img class="more-info-icon" src="https://cdn-icons-png.flaticon.com/512/44/44522.png" alt="More Info Icon">
    </div>
  </div>
</div>

<!-- The "Total Products" box -->
<div class="info-box total-products-box">
  <div class="total-products">
    <p class="total-products-text">
    <?php
      
      if (isset($_SESSION['total_products'])) {
        echo $_SESSION['total_products'];
      } else {
        echo '0';
      }
      ?>
      <br>Total Products
    </p>   
  </div>
  <div class="more-info total-products-more-info"> 
  <div class="more-info-strip" onclick="window.location.href='http://localhost/Kumara%20Stores%20Inventory_system/Manage_Product/';">
      <p class="more-info-text">More Info</p>
      <img class="more-info-icon" src="https://cdn-icons-png.flaticon.com/512/44/44522.png" alt="More Info Icon">
    </div>
  </div>
</div>

<!-- The "Paid Orders" box -->
<div class="info-box paid-orders-box">
  <div class="paid-orders">
    <p class="paid-orders-text"><?php echo $paidOrderCount; ?><br>Paid Orders</p> 
  </div>
  <div class="more-info paid-orders-more-info"> 
    <div class="more-info-strip" onclick="window.location.href='http://localhost/Kumara%20Stores%20Inventory_system/Manage_Order/';">
      <p class="more-info-text">More Info</p>
      <img class="more-info-icon" src="https://cdn-icons-png.flaticon.com/512/44/44522.png" alt="More Info Icon">
    </div>
  </div>
</div>

<!-- The "Unpaid Orders" box -->
<div class="info-box unpaid-orders-box">
  <div class="unpaid-orders">
    <p class="unpaid-orders-text"><?php echo $unpaidOrderCount; ?><br>Unpaid Orders</p> 
  </div>
  <div class="more-info unpaid-orders-more-info"> 
    <div class="more-info-strip" onclick="window.location.href='http://localhost/Kumara%20Stores%20Inventory_system/Manage_Order/';">
      <p class="more-info-text">More Info</p>
      <img class="more-info-icon" src="https://cdn-icons-png.flaticon.com/512/44/44522.png" alt="More Info Icon">
    </div>
  </div>
</div>
<!-- The "Total Members" box -->
<div class="info-box total-members-box">
  <div class="total-members">
    <p class="total-members-text"><?php echo $totalMemberCount; ?><br>Total Members</p> 
  </div>
  <div class="more-info total-members-more-info"> 
    <div class="more-info-strip" onclick="window.location.href='http://localhost/Kumara%20Stores%20Inventory_system/Manage_Member/';">
      <p class="more-info-text">More Info</p>
      <img class="more-info-icon" src="https://cdn-icons-png.flaticon.com/512/44/44522.png" alt="More Info Icon">
    </div>
  </div>
</div>

<!-- The "Total Warehouse" box -->
<div class="info-box total-warehouse-box">
  <div class="total-warehouse">
    <p class="total-warehouse-text">
      <?php
        
        if (isset($_SESSION['total_active_warehouses'])) {
          echo $_SESSION['total_active_warehouses'];
        } else {
          echo '0';
        }
      ?><br>Total Warehouse
    </p>
  </div>
  <div class="more-info total-warehouse-more-info"> 
    <div class="more-info-strip" onclick="window.location.href='http://localhost/Kumara%20Stores%20Inventory_system/Warehouse/index.php';">
      <p class="more-info-text">More Info</p>
      <img class="more-info-icon" src="https://cdn-icons-png.flaticon.com/512/44/44522.png" alt="More Info Icon">
    </div>
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
