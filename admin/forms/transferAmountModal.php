<!-- Main modal -->
<div id="transfer-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full border-2 border-black">
    <div class="relative p-4 w-full max-w-md max-h-full">

        <!-- Modal content -->
        <div class="relative rounded-lg shadow bg-gray-700">

            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                <h3 class="text-xl font-semibold text-white">
                    Transfer Amount to Owner
                </h3>
                <button id="transferModalCloseBtn" type="button" class="end-2.5 text-gray-400 bg-transparent rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white" data-modal-hide="authentication-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form class="space-y-4" action="#">
                    <!-- alert div  -->
                    <div id="alertdiv"></div>
                    <!-- alert div  -->
                    <input type="hidden" name="managerid" id="managerid">
                    <input type="hidden" name="availAmount" id="availAmount">
                    <input type="hidden" name="gaadi_id" id="gaadi_id">
                    <div>
                        <label for="tamount" class="block mb-2 text-sm font-medium text-white">Amount</label>
                        <input type="number" name="tamount" id="tamount" class="bg-gray-50 border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 border-gray-500 placeholder-gray-700 text-gray-700" placeholder="Enter Amount" required />
                    </div>
                    <div>
                        <label for="modePayment" class="block mb-2 text-sm font-medium text-white">Mode of Payment <span class="text-yellow-500"> ( Select One Mode *)</span></label>
                        <select name="modePayment" id="modePayment" class="bg-gray-50 border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 border-gray-500 placeholder-gray-700 text-gray-700" placeholder="Enter Amount" >
                        <option value="1">Cash</option>
                        <option value="2">Direct Bank Transfer / UPI </option>
                        </select>
                    </div>
        
                    <button id="sendAmount" type="submit" class="w-full text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">Transfer Amount</button>
                    
                </form>
            </div>
        </div>
    </div>
</div> 
