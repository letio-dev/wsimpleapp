import h from "./helper"; // Impor module helper

window.dom = h.catchDOM();
const form = document.querySelector("form");
window.storeForm = {
    tracking_number: {
        value: null,
        required: true,
    },
    courier_service: {
        value: null,
    },
    recipient_name: {
        value: null,
        required: true,
    },
    tower: {
        value: null,
        required: true,
    },
    floor: {
        value: null,
        changeByUser: false,
    },
    unit: {
        value: null,
        required: true,
    },
    recipient_phone: {
        value: null,
    },
    notes: {
        value: null,
    },
};

// document.getElementById('cameraInput').addEventListener('change', function (e) {
//     const file = e.target.files[0];
//     if (!file) return;

//     // Tampilkan loading
//     // document.getElementById('labelText').value = 'Mendeteksi teks...';

//     Tesseract.recognize(
//         file,
//         'eng', // Bahasa OCR
//         {
//             logger: m => console.log(m) // opsional, lihat progress di console
//         }
//     ).then(({ data: { text } }) => {
//         // Hasil teks masuk ke form
//         // document.getElementById('labelText').value = text.trim();
//         console.log(text);
        
//     }).catch(err => {
//         console.error(err);
//         // document.getElementById('labelText').value = 'Gagal mendeteksi teks';
//     });
// });

function validateForm() {
    const isValid = Object.values(storeForm).every((field) =>
        field.required ? field.value && field.value.length > 0 : true
    );

    if (isValid) {
        dom.submitBtn.disabled = false;
        dom.submitBtn.classList.remove("bg-gray-400", "cursor-not-allowed");
        dom.submitBtn.classList.add("bg-blue-500", "hover:bg-blue-600");
    } else {
        dom.submitBtn.disabled = true;
        dom.submitBtn.classList.add("bg-gray-400", "cursor-not-allowed");
        dom.submitBtn.classList.remove("bg-blue-500", "hover:bg-blue-600");
    }

    return isValid;
}

validateForm();

document.querySelectorAll("input, select, textarea").forEach((el) => {
    el.addEventListener("input", (event) => {
        storeForm[event.target.name].value = event.target.value.trim();
        validateForm();
    });
});

document.querySelector('[name="floor"]').addEventListener("keyup", (event) => {
    const value = event.target.value.trim();
    storeForm.floor.changeByUser = value.length > 0;
});

document.querySelector('[name="unit"]').addEventListener("input", (event) => {
    if (storeForm.floor.changeByUser === false) {
        const unitValue = event.target.value.trim();
        updateInput("floor", unitValue.substr(0, 2));
    }
});

const updateInput = (name, value) => {
    const el = document.querySelector(`[name="${name}"]`);
    if (el) {
        el.value = value;
        el.dispatchEvent(new Event("input", { bubbles: true }));
    }
};

form.addEventListener("submit", function (event) {
    event.preventDefault(); // Mencegah reload halaman

    if (!validateForm()) return;

    axios
        .post(
            "/inputData",
            Object.fromEntries(
                Object.keys(storeForm).map((key) => [key, storeForm[key].value])
            )
        )
        .then((response) => {
            h.showToast(response.data.message, "success");

            form.reset(); // Reset form setelah submit berhasil
            resetStoreForm();
            validateForm(); // Validasi ulang setelah reset
        })
        .catch((error) => {
            h.showToast("Terjadi kesalahan!", "error");
        });
});

function resetStoreForm() {
    Object.keys(storeForm).forEach((key) => {
        storeForm[key].value = null;
    });
}
