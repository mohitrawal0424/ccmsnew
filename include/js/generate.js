jQuery(document).ready(function () {
    $('#downloadInvoice').click(function (e) {
        e.preventDefault();

        let custName = document.querySelector("#custName").innerText;
        $("#receipt").removeClass("hidden");

        html2canvas(document.querySelector("#receipt")).then((canvas) => {
            let base64image = canvas.toDataURL('image/png');
            let pdf = new jsPDF('p', 'mm', [800, 1131]);
            // Calculate dimensions to cover the full page
            let imgWidth = 800; // Width of the PDF page
            let imgHeight = (canvas.height * imgWidth) / canvas.width; // Maintain aspect ratio
            // Add the image to cover the full page
            pdf.addImage(base64image, 'PNG', 0, 0, imgWidth, imgHeight);
            pdf.save(custName+'.pdf');
        });
    });
});
