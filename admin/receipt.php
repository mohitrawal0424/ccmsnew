<?php 

function receipt ($dataArray) {

?>
<!-- recipt  -->
<div id="receipt" class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto my-4 sm:my-10 hidden">
                <div class="sm:w-11/12 lg:w-3/4 mx-auto">
                  <div class="flex flex-col p-4 sm:p-10 bg-white shadow-md rounded-xl">
                    
                    <div class="flex justify-between">
                      <div>
                        <h1 class="mt-2 text-lg md:text-xl font-semibold text-blue-600">Tamanna Khaadya Bhandar</h1>
                      </div>
                      <div class="text-end">
                        <h2 class="text-2xl md:text-3xl font-semibold text-gray-800">Invoice #<?php echo $dataArray['gaadi']['id'] ?></h2>
                      </div>
                    
                    </div>
                 
                    <div class="mt-8 grid sm:grid-cols-2 gap-3">
                      <div>
                        <h3 class="text-lg font-semibold text-gray-800">Customer Name: <?php echo $dataArray['gaadi']['recName'] ?></h3>
                        <h3 class="text-lg font-semibold text-gray-800">Gaadi Name: <?php echo $dataArray['gaadi']['name'] ?></h3>
                      </div>
                     
              
                      <div class="sm:text-end space-y-2">
                       
                        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                          <dl class="grid sm:grid-cols-5 gap-x-3">
                            <dt class="col-span-3 font-semibold text-gray-800">Invoice date: </dt>
                            <dd class="col-span-2 text-gray-500"><?php echo date('d-m-y') ?></dd>
                          </dl>
                          <dl class="grid sm:grid-cols-5 gap-x-3">
                            <dt class="col-span-3 font-semibold text-gray-800">GST: </dt>
                            <dd class="col-span-2 text-gray-500">10BUGPK4850B1Z8</dd>
                          </dl>
                          
                        </div>
                      </div>
                    </div>
                  
                    <div class="mt-6">
                      <div class="border border-gray-500 p-4 rounded-lg space-y-4">
                        <div class="hidden sm:grid sm:grid-cols-5">
                          <div class="sm:col-span-2 text-xs font-medium text-gray-500 uppercase">Item</div>
                          <div class="text-start text-xs font-medium text-gray-500 uppercase">Qty</div>
                          <div class="text-start text-xs font-medium text-gray-500 uppercase">Price</div>
                          <div class="text-end text-xs font-medium text-gray-500 uppercase">Amount</div>
                        </div>
                    <?php 
                    foreach($dataArray['productlist'] as $key=> $product){ ?>
                   
                        <div class="hidden sm:block border-b border-gray-500"></div>
                        <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                              <div class="col-span-full sm:col-span-2">
                                <p class="font-medium text-gray-800"><?php echo $product['name'] ?></p>
                              </div>
                              <div>
                                <p class="text-gray-800"><?php echo $product['nos'] ?></p>
                              </div>
                              <div>
                                <p class="text-gray-800"><?php echo $product['priceofOne'] ?></p>
                              </div>
                        
                              <div>
                                <p class="sm:text-end text-gray-800"><?php echo $product['price'] ?></p>
                              </div>
                            </div>
                            <div class="sm:hidden border-b border-gray-500"></div>
                            <?php }
                    ?>
                    </div>
                    </div>
                
                    <div class="mt-8 flex sm:justify-end">
                      <div class="w-full max-w-2xl sm:text-end space-y-2">
              
                        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                          <dl class="grid sm:grid-cols-5 gap-x-3">
                            <dt class="col-span-3 font-semibold text-gray-800">Total Bill:</dt>
                            <dd class="col-span-2 text-gray-500"><?php echo $dataArray['gaadi']['totalbill'] ?></dd>
                          </dl>
              
                          <dl class="grid sm:grid-cols-5 gap-x-3">
                            <dt class="col-span-3 font-semibold text-gray-800">Discount:</dt>
                            <dd class="col-span-2 text-gray-500"><?php echo $dataArray['gaadi']['discount'] ?></dd>
                          </dl>
                          <?php if($dataArray['gaadi']['amountpaidTotal']){ ?>
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                            <dt class="col-span-3 font-semibold text-gray-800">Amount Paid:</dt>
                            <dd class="col-span-2 text-gray-500"><?php echo $dataArray['gaadi']['amountpaidTotal'] ?></dd>
                          </dl>
                          <?php } ?>
                          <?php if($dataArray['gaadi']['gaadiExpanse']){ ?>
                            <dl class="grid sm:grid-cols-5 gap-x-3">
                            <dt class="col-span-3 font-semibold text-gray-800">Expanse:</dt>
                            <dd class="col-span-2 text-gray-500"><?php echo $dataArray['gaadi']['gaadiExpanse'] ?></dd>
                          </dl>
                          <?php } ?>
                          <dl class="grid sm:grid-cols-5 gap-x-3">
                            <dt class="col-span-3 font-semibold text-gray-800">Remaining Amount:</dt>
                            <dd class="col-span-2 text-gray-500"><?php echo $dataArray['gaadi']['remAmount'] ?></dd>
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

<?php }
?>