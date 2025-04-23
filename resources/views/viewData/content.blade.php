<div class="w-full md:w-[500px]">

    <div class="flex flex-wrap -mx-2 mb-2 gap-y-3">
        <div class="w-full md:w-1/2 px-2">
            <label for="tower" class="block text-sm font-medium">Tower <span class="text-red-500">*</span></label>
            <select id="tower" name="tower" required
                class="py-2 px-3 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                <option value="" hidden>Pilih Tower</option>
                <option value="BASELLA">BASELLA</option>
                <option value="AZOLLA">AZOLLA</option>
                <option value="CALDESIA">CALDESIA</option>
                <option value="DAVALLIA">DAVALLIA</option>
            </select>
        </div>

        <!-- Unit -->
        <div class="w-full md:w-1/2 px-2">
            <label for="unit" class="block text-sm font-medium">Unit <span class="text-red-500">*</span></label>
            <input type="text" id="unit" name="unit" required
                class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
        </div>
    </div>

    <!-- Find Button -->
    <button jid="findBtn" type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:outline-hidden focus:bg-blue-200 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-400 dark:bg-blue-800/30 dark:hover:bg-blue-800/20 dark:focus:bg-blue-800/20"
        @disabled(true)>
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        Cari
    </button>

</div>


<table jid="trxTable" class="table table-striped table-bordered table-hover dt-responsive" width="100%"></table>

<div jid="divTable"></div>
