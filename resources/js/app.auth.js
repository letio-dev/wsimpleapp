import h from "./helper";
import axios from "axios";

const dom = h.catchDOM();

dom.app_logout_btn.addEventListener("click", function (event) {
    event.preventDefault(); // Mencegah reload halaman

    axios
        .post("/logout")
        .then((response) => {
            if (response.data.success === true) {
                window.location.href = response.data.redirect;
            }
        })
        .catch((error) => {
            console.error(error);
        });
});