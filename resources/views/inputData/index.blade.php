@extends('layouts.app')

@section('title', 'Input Data')

@push('styles')
    @vite(['resources/css/inputData.css'])
@endpush

@section('content')
    @include('inputData.content')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@6/dist/tesseract.min.js"></script>
    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');
        const outputText = document.getElementById('outputText');
        const progress = document.getElementById('progress');
        const captureBtn = document.getElementById('captureBtn');
        const uploadInput = document.getElementById('uploadInput');

        function isMobileDevice() {
            return /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
        }

        if (isMobileDevice()) {
            // Kalau dari HP, tampilkan input file dan sembunyikan kamera desktop
            video.style.display = 'none';
            captureBtn.style.display = 'none';
            uploadInput.style.display = 'block';
        } else {
            // Kalau dari Desktop, nyalakan kamera
            uploadInput.style.display = 'none';
            video.style.display = 'block';
            captureBtn.style.display = 'inline-block';

            navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment'
                    }
                })
                .then(stream => video.srcObject = stream)
                .catch(err => console.error('Gagal membuka kamera:', err));
        }

        // Button Capture untuk Desktop
        captureBtn.addEventListener('click', () => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0);
            const image = canvas.toDataURL();
            runOCR(image);
        });

        // Upload dari Mobile
        uploadInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0);
                    const image = canvas.toDataURL();
                    runOCR(image);
                };
                img.src = event.target.result;
            };
            if (file) reader.readAsDataURL(file);
        });

        // OCR pakai Tesseract.js v6 (UMD)
        async function runOCR(imageBase64) {
            outputText.value = 'Memproses OCR...';
            progress.innerText = 'Memuat...';

            sendToLaravel(imageBase64);

            const worker = await Tesseract.createWorker('ind', 1, {
                logger: m => {}, // Add logger here
            });

            (async () => {
                const {
                    data: {
                        text
                    }
                } = await worker.recognize(imageBase64);
                console.log(text);
                await worker.terminate();
            })();
        }

        async function sendToLaravel(imageBase64) {
            console.log('Sedang diproses di server...');

            const imageInput = document.getElementById('uploadInput');

            const formData = new FormData();
            formData.append('image', imageInput.files[0]);

            try {
                const res = await axios.post('/inputDataOCR', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                console.log(res.data);
                
            } catch (err) {
                console.error(err);
            }
        }
    </script>

    @vite(['resources/js/inputData.js'])
@endpush
