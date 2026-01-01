// not being used right now 


    document.getElementById('downloadInvoice').addEventListener('click', function(e) {
        e.preventDefault();
        const invoiceElement = "<h1>TamannaKhadyan</h1>";
        const options = {
          margin: 1,
          filename: 'invoice.pdf',
          image: { type: 'jpeg', quality: 0.98 },
          html2canvas: { scale: 2 },
          jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        console.log(invoiceElement);
  
        // Then call html2pdf with the element and options
        html2pdf().from(invoiceElement).set(options).save();
      });