// not being used right now 


// function generateInvoice(vehicleDetails, products) {

document
  .getElementById("downloadInvoice")
  .addEventListener("click", function (e) {
    e.preventDefault();

    window.jsPDF = window.jspdf.jsPDF;
    let companyName = "Tamanna Khaadya Bhandar";
    let gstNo = "GST No.: 10BUGPK4850B1Z8";

    const pdf = new jsPDF("p", "mm", "a4");
    
    // Add company name (centered)
    const pageSize = pdf.internal.pageSize;
    const pageWidth = pageSize.getWidth();
    pdf.setFontSize(18);
    pdf.text(companyName, pageWidth / 2, 15, { align: "center" });

    // Add GST number (right side)
    pdf.setFontSize(10);
    pdf.text(gstNo, pageWidth - 15, pageSize.getHeight() - 10, { align: "right" });

    // Add table for products
    let products = [
      { name: "Product 1", price: "500 INR" },
      { name: "Product 2", price: "600 INR" },
      { name: "Product 3", price: "700 INR" }
    ];

    const tableHeaders = ["Product", "Price"];
    const tableData = products.map(product => [product.name, product.price]);

    pdf.autoTable({
      startY: 40,
      head: [tableHeaders],
      body: tableData,
      theme: "grid",
      margin: { top: 20 },
      styles: {
        fontSize: 10,
        cellPadding: 2,
        valign: 'middle'
      },
      columnStyles: {
        0: { cellWidth: 80 },
        1: { cellWidth: 40, halign: 'right' }
      }
    });

    pdf.save("invoice.pdf");
  });
