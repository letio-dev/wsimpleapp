import h from "../helper"; // Impor module helper

window.dom = h.catchDOM();
const form = document.querySelector("form");
window.storeForm = {
    username: {
        value: null,
        required: true,
    },
    password: {
        value: null,
        required: true,
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

validateForm();

document.querySelectorAll("input, select, textarea").forEach((el) => {
    el.addEventListener("input", (event) => {
        storeForm[event.target.name].value = event.target.value.trim();
        validateForm();
    });
});

form.addEventListener("submit", function (event) {
    event.preventDefault(); // Mencegah reload halaman

    if (!validateForm()) return;
    dom.submitBtn.disabled = true;

    const result = Object.entries(storeForm).reduce(
        (r, [k, v]) => ((r[k] = v.value), r),
        {}
    );

    axios
        .post("/login", result)
        .then((response) => {
            if (response.data.success === true) {
                window.location.href = response.data.redirect;

                form.reset();
                return;
            }

            h.showToast(response.data.error);
        })
        .catch((error, a, b) => {
            const response = error.response.data;

            dom.submitBtn.disabled = false;
            h.showToast(response.error, "error");
        });
});
