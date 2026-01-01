<div id="receipt">
<div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto my-4 sm:my-10">
  <div class="sm:w-11/12 lg:w-3/4 mx-auto">
    <div class="flex flex-col p-4 sm:p-10 bg-white shadow-md rounded-xl">
      
      <div class="flex justify-between">
        <div>
          <h1 class="mt-2 text-lg md:text-xl font-semibold text-blue-600">Tamanna Khaadya Bhandar</h1>
        </div>
        <div class="text-end">
          <h2 class="text-2xl md:text-3xl font-semibold text-gray-800">Invoice #id</h2>
        </div>
      
      </div>
   
      <div class="mt-8 grid sm:grid-cols-2 gap-3">
        <div>
          <h3 class="text-lg font-semibold text-gray-800">Customer Name</h3>
          <h3 class="text-lg font-semibold text-gray-800">Shop Name</h3>
        </div>
       

        <div class="sm:text-end space-y-2">
         
          <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
            <dl class="grid sm:grid-cols-5 gap-x-3">
              <dt class="col-span-3 font-semibold text-gray-800">Invoice date:</dt>
              <dd class="col-span-2 text-gray-500">03/10/2018</dd>
            </dl>
            <dl class="grid sm:grid-cols-5 gap-x-3">
              <dt class="col-span-3 font-semibold text-gray-800">Due date:</dt>
              <dd class="col-span-2 text-gray-500">03/11/2018</dd>
            </dl>
          </div>
        </div>
      </div>
    
      <div class="mt-6">
        <div class="border border-gray-500 p-4 rounded-lg space-y-4">
          <div class="hidden sm:grid sm:grid-cols-5">
            <div class="sm:col-span-2 text-xs font-medium text-gray-500 uppercase">Item</div>
            <div class="text-start text-xs font-medium text-gray-500 uppercase">Qty</div>
            <div class="text-end text-xs font-medium text-gray-500 uppercase">Amount</div>
          </div>

          <div class="hidden sm:block border-b border-gray-500"></div>

          <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
            <div class="col-span-full sm:col-span-2">
              <p class="font-medium text-gray-800">Design UX and UI</p>
            </div>
            <div>
              <p class="text-gray-800">1</p>
            </div>
          
            <div>
              <p class="sm:text-end text-gray-800">$500</p>
            </div>
          </div>
          <div class="sm:hidden border-b border-gray-500"></div>
        </div>
      </div>
  
      <div class="mt-8 flex sm:justify-end">
        <div class="w-full max-w-2xl sm:text-end space-y-2">

          <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
            <dl class="grid sm:grid-cols-5 gap-x-3">
              <dt class="col-span-3 font-semibold text-gray-800">Total Bill:</dt>
              <dd class="col-span-2 text-gray-500">$2750.00</dd>
            </dl>

            <dl class="grid sm:grid-cols-5 gap-x-3">
              <dt class="col-span-3 font-semibold text-gray-800">Discount:</dt>
              <dd class="col-span-2 text-gray-500">$2750.00</dd>
            </dl>

            <dl class="grid sm:grid-cols-5 gap-x-3">
              <dt class="col-span-3 font-semibold text-gray-800">Amount paid:</dt>
              <dd class="col-span-2 text-gray-500">$2789.00</dd>
            </dl>

            <dl class="grid sm:grid-cols-5 gap-x-3">
              <dt class="col-span-3 font-semibold text-gray-800">Due balance:</dt>
              <dd class="col-span-2 text-gray-500">$0.00</dd>
            </dl>
          </div>

        </div>
      </div>

      <div class="mt-8 sm:mt-12">
        <h4 class="text-lg font-semibold text-gray-800">Thank you!</h4>
        <p class="text-gray-500">If you have any questions concerning this invoice, use the following contact information:</p>
        <div class="mt-2">
          <p class="block text-sm font-medium text-gray-800">+91 7488545475</p>
        </div>
      </div>

      <p class="mt-5 text-sm text-gray-500">© Tamanna Khaadya Bhandar.</p>
    </div>

  </div>
</div>
</div>





















<!-- <div id="companyDetails" class="m-2 p-2 grid justify-center hidden">
                <h1 class="text-2xl">Tammanna Khadyan Bhandar</h1>
                <h2 class="">GST No.: 10BUGPK4850B1Z8</h2>
                <h2 class="">Invoice Cum Bill</h2>
</div>

<div class="bg-white border rounded-lg shadow-lg px-6 py-8 max-w-md mx-auto mt-8">
    <h1 class="font-bold text-2xl my-4 text-center text-blue-600">KRP Services</h1>
    <hr class="mb-2">
    <div class="flex justify-between mb-6">
        <h1 class="text-lg font-bold">Invoice</h1>
        <div class="text-gray-700">
            <div>Date: <?php echo date('d-m-Y') ?></div>
            <div>Time: <?php echo date('d-m-Y') ?></div>
            <div>Invoice #: INV12345</div>
        </div>
    </div>
    <?php
    $recId = 3;
                        include("../include/connect.php");
                        $sql = "SELECT g.*,s.name as recName FROM `counter` as g 
                            INNER JOIN `customer` as s ON g.receiverid = s.id
                            WHERE g.id = ?";
                        $stmt = $conn->prepare($sql);
                        if ($stmt) {
                            $stmt->bind_param("i", $recId);
                            if ($stmt->execute()) {
                                $result = $stmt->get_result(); // Get the result set
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $discount = $row['discount'];
                                    $amountpaid = $row['amountpaid']; ?>
                                    
                                    <div class="mb-8">
                                    <h2 class="text-lg font-bold mb-4">Bill To: <?php echo $row['']?></h2>
                                    <div class="text-gray-700 mb-2">John Doe</div>
                                    <div class="text-gray-700 mb-2">123 Main St.</div>
                                    <div class="text-gray-700 mb-2">Anytown, USA 12345</div>
                                    <div class="text-gray-700">johndoe@example.com</div>
                                    </div>

                             <?php   }
                            } else {
                                echo 'Something Error';
                            }
                        }
                        ?>
    
    <table class="w-full mb-8">
        <thead>
            <tr>
                <th class="text-left font-bold text-gray-700">Description</th>
                <th class="text-right font-bold text-gray-700">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-left text-gray-700">Product 1</td>
                <td class="text-right text-gray-700">$100.00</td>
            </tr>
            <tr>
                <td class="text-left text-gray-700">Product 2</td>
                <td class="text-right text-gray-700">$50.00</td>
            </tr>
            <tr>
                <td class="text-left text-gray-700">Product 3</td>
                <td class="text-right text-gray-700">$75.00</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="text-left font-bold text-gray-700">Total</td>
                <td class="text-right font-bold text-gray-700">$225.00</td>
            </tr>
        </tfoot>
    </table>
    <div class="text-gray-700 mb-2">Thank you for your business!</div>
    <div class="text-gray-700 text-sm">Please remit payment within 30 days.</div>
</div> -->