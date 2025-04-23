import h from "./helper"; // Impor module helper

window.h = h;
window.dom = h.catchDOM();
window.storeForm = {
    year: {
        value: null,
        required: true,
    },
    month: {
        value: null,
    },
};

function validateForm(form = null, submitButton = null) {
    form = form || storeForm;
    submitButton = submitButton || dom.submitBtn;

    const isValid = Object.values(form).every((field) =>
        field.required ? field.value && field.value.length > 0 : true
    );

    submitButton.disabled = !isValid;

    return isValid;
}

validateForm(null, dom.downloadBtn);

document.querySelectorAll("input, select, textarea").forEach((el) => {
    el.addEventListener("input", (event) => {
        storeForm[event.target.name].value = event.target.value.trim();
        validateForm(null, dom.downloadBtn);
    });
});

dom.downloadBtn.addEventListener("click", function () {
    dom.downloadBtn.disabled = true;
    dom.downloadBtn.firstElementChild.outerHTML = `<span class="animate-spin inline-block size-4 border-[2px] border-current border-t-transparent text-blue rounded-full" role="status" aria-label="loading"></span>`;

    axios
        .post(
            "/downloadData",
            Object.fromEntries(
                Object.keys(storeForm).map((key) => [key, storeForm[key].value])
            ),
            {
                responseType: "blob",
            }
        )
        .then((response) => {
            const blob = new Blob([response.data], {
                type: response.headers["content-type"],
            });

            let filename = "download.xlsx";
            const cd = response.headers["content-disposition"];
            if (cd && cd.includes("filename=")) {
                filename = cd.split("filename=")[1].replace(/"/g, "");
            }

            const link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;
            link.click();
            window.URL.revokeObjectURL(link.href);
        })
        .catch((error) => {
            h.showToast("Terjadi kesalahan!", "error");
        })
        .finally(() => {
            dom.downloadBtn.disabled = false;
            dom.downloadBtn.firstElementChild.outerHTML = `<svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg>`;
        });
});
