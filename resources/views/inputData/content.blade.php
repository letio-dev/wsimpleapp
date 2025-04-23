<h1 class="text-xl font-bold">Input Data</h1>

<h3>Scanner OCR</h3>

<!-- Kamera (desktop) -->
<video id="video" width="320" height="240" autoplay style="display:none;"></video>
<button id="captureBtn" style="display:none;">Ambil & Scan</button>

<!-- Kamera (mobile) -->
<input type="file" id="uploadInput" accept="image/*" capture="environment" style="display:none;">

<!-- Hasil -->
<canvas id="canvas" style="display:none;"></canvas>
<input type="text" id="outputText" placeholder="Hasil OCR...">
<div id="progress"></div>

<form novalidate class="space-y-4">
    @csrf

    {{-- <label for="cameraInput">Ambil Foto Label:</label><br>
    <input type="file" id="cameraInput" accept="image/*" capture="environment"> --}}

    <!-- No. Resi -->
    <div class="mb-4">
        <label for="tracking_number_ed" class="block text-sm font-medium">No. Resi <span
                class="text-red-500">*</span></label>
        <input type="text" id="tracking_number_ed" name="tracking_number" required
            class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
    </div>

    <!-- Ekspedisi -->
    <div class="mb-4">
        <label for="courier_service_ed" class="block text-sm font-medium">Ekspedisi</label>
        <input type="text" id="courier_service_ed" name="courier_service" list="courier_service-list"
            class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
        <datalist id="courier_service-list">
            <option value="JNE">
            <option value="SHOPEE">
            <option value="ANTARAJA">
        </datalist>
    </div>

    <div class="flex flex-wrap -mx-2 mb-4 gap-y-3">
        <!-- Nama Penerima -->
        <div class="w-full md:w-1/2 px-2">
            <label for="recipient_name_ed" class="block text-sm font-medium">Nama Penerima <span
                    class="text-red-500">*</span></label>
            <input type="text" id="recipient_name_ed" name="recipient_name" required
                class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
        </div>

        <!-- No. HP -->
        <div class="w-full md:w-1/2 px-2">
            <label for="recipient_phone_ed" class="block text-sm font-medium">No. Telepon</label>
            <input type="tel" id="recipient_phone_ed" name="recipient_phone" pattern="[0-9]+"
                class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
        </div>
    </div>

    <div class="flex flex-wrap -mx-2 mb-4 gap-y-3">
        <!-- Tower -->
        <div class="w-full md:w-5/12 px-2">
            <label for="tower_ed" class="block text-sm font-medium">Tower <span class="text-red-500">*</span></label>
            <select id="tower_ed" name="tower" required
                class="py-2 px-3 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                <option value="" hidden>Pilih Tower</option>
                <option value="BASELLA">BASELLA</option>
                <option value="AZOLLA">AZOLLA</option>
                <option value="CALDESIA">CALDESIA</option>
                <option value="DAVALLIA">DAVALLIA</option>
            </select>
        </div>

        <!-- Unit -->
        <div class="w-full md:w-5/12 px-2">
            <label for="unit_ed" class="block text-sm font-medium">Unit <span class="text-red-500">*</span></label>
            <input type="text" id="unit_ed" name="unit" required
                class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
        </div>

        <!-- Lantai -->
        <div class="w-full md:w-2/12 px-2">
            <label for="floor_ed" class="block text-sm font-medium">Lantai</label>
            <input type="text" id="floor_ed" name="floor" required
                class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                tabindex="-1">
        </div>
    </div>

    <!-- Catatan -->
    <div class="mb-4">
        <label for="notes_ed" class="block text-sm font-medium">Catatan</label>
        <textarea id="notes_ed" name="notes" rows="4"
            class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"></textarea>
    </div>

    <!-- Submit Button -->
    <button jid="submitBtn" type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600"
        @disabled(true)>
        Submit
    </button>
</form>
