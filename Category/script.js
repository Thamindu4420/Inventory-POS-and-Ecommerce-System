function printTable() {
    const table = document.querySelector('.category-table');
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
  
      // Get the table headings (th elements)
      const headings = table.querySelectorAll('th:nth-child(1), th:nth-child(2)'); 
  
      // Add the table headings to the tableContent
      tableContent += '<tr>';
      headings.forEach(heading => {
        tableContent += heading.outerHTML;
      });
      tableContent += '</tr>';
  
      // Get all rows in the table body
      const rows = table.querySelectorAll('tr');
  
      // Add each row to the tableContent
      rows.forEach(row => {
        tableContent += '<tr>';
        const columns = row.querySelectorAll('td:nth-child(1), td:nth-child(2)'); 
        columns.forEach(column => {
          tableContent += column.outerHTML;
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
