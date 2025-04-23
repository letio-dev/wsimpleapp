import Toastify from "toastify-js";

// Fungsi untuk menampilkan toast
function showToast(message, type = "info", options = {}) {
    const defaultOptions = {
        duration: 3000,
        placement: "top-right",
        close: true,
    };

    const { duration, placement, close } = { ...defaultOptions, ...options };

    const positionMap = {
        "top-left": { gravity: "top", position: "left" },
        "top-center": { gravity: "top", position: "center" },
        "top-right": { gravity: "top", position: "right" },
        center: { gravity: "center", position: "center" },
        "bottom-left": { gravity: "bottom", position: "left" },
        "bottom-center": { gravity: "bottom", position: "center" },
        "bottom-right": { gravity: "bottom", position: "right" },
    };

    const toastOptions = {
        text: `
            <div class="flex p-4">
                <div class="mr-2">${getIcon(type)}</div>
                    <div class="text-sm text-gray-700 dark:text-neutral-400">${message}</div>
                    <div class="ms-auto">
                    <button onclick="tostifyCustomClose(this)" type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100 dark:text-white" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                    </button>
                </div>
            </div>
        `,
        duration: duration,
        className:
            "hs-toastify-on:opacity-100 opacity-0 fixed -top-37.5 right-5 z-90 transition-all duration-300 w-80 bg-white text-sm text-gray-700 border border-gray-200 rounded-xl shadow-lg [&>.toast-close]:hidden dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400",
        close: close,
        gravity: positionMap[placement]?.gravity || "top",
        position: positionMap[placement]?.position || "right",
        //   style: {
        //     background: {
        //       success: "#38a169",
        //       error: "#e53e3e",
        //       warning: "#dd6b20",
        //       info: "#3182ce",
        //     }[type] || "#3182ce",
        //     borderRadius: "8px",
        //     padding: "12px 16px",
        //     color: "#fff",
        //   },
        escapeMarkup: false,
    };

    Toastify(toastOptions).showToast();
}

function showToast2(message, type = "info", options = {}) {
    const defaultOptions = {
        duration: 3000, // Durasi toast muncul dalam milidetik
        placement: "top-right", // Posisi toast: top-right, top-left, bottom-right, bottom-left, center
        close: true,
    };

    const { duration, placement, close } = { ...defaultOptions, ...options };

    const typeClasses = {
        success: "border-teal-500 text-teal-500",
        error: "border-red-500 text-red-500",
        warning: "border-yellow-500 text-yellow-500",
        info: "border-blue-500 text-blue-500",
    };

    const positionMap = {
        "top-left": "top-4 left-4",
        "top-center": "top-4 left-1/2 transform -translate-x-1/2",
        "top-right": "top-4 right-4",
        center: "top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2",
        "bottom-left": "bottom-4 left-4",
        "bottom-center": "bottom-4 left-1/2 transform -translate-x-1/2",
        "bottom-right": "bottom-4 right-4",
    };

    // Buat elemen toast
    const toast = document.createElement("div");
    toast.className = `fixed z-50 max-w-xs bg-white border rounded-xl shadow-lg p-4 flex items-center justify-between space-x-3 ${
        typeClasses[type] || typeClasses.info
    }`;

    // Tambahkan posisi dengan `classList.add`
    toast.classList.add(...positionMap[placement].split(" "));

    const icon = document.createElement("span");
    icon.innerHTML = getIcon(type);
    icon.className = "text-lg";

    const text = document.createElement("p");
    text.className = "text-sm text-gray-700";
    text.textContent = message;

    toast.appendChild(icon);
    toast.appendChild(text);
    let closeButton;
    if (close) {
        closeButton = document.createElement("button");
        closeButton.innerHTML = "&times;";
        closeButton.className = "text-gray-500 text-xl ml-auto";
        closeButton.onclick = () => toast.remove();
        toast.appendChild(closeButton);
    }

    document.body.appendChild(toast);

    setTimeout(() => toast.remove(), duration);
}

// Fungsi untuk mendapatkan ikon berdasarkan tipe pesan
function getIcon(type) {
    const icons = {
        normal: `<svg class="shrink-0 size-4 text-blue-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
        </svg>`,
        success: `<svg class="shrink-0 size-4 text-teal-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
        </svg>`,
        error: `<svg class="shrink-0 size-4 text-red-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"></path>
        </svg>`,
        warning: `<svg class="shrink-0 size-4 text-yellow-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"></path>
        </svg>`,
    };

    return icons[type] || icons.normal;
}

window.tostifyCustomClose = (el) => {
    const parent = el.closest(".toastify");
    const close = parent.querySelector(".toast-close");

    close.click();
};

// Fungsi untuk menghasilkan string acak
function generateRandomString(length = 10) {
    const characters =
        "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    let result = "";
    for (let i = 0; i < length; i++) {
        result += characters.charAt(
            Math.floor(Math.random() * characters.length)
        );
    }
    return result;
}

HTMLElement.prototype.detachTemp = function () {
    if (!this._parent && this.parentNode.nodeType === 1) {
        this._parent = this.parentNode;
        this._index = Array.from(this._parent.children).indexOf(this); // Simpan posisi asli
    }
    this.remove();
    return this;
};

HTMLElement.prototype.reattach = function (parent = null, index = null) {
    let targetParent = parent || this._parent;
    let targetIndex = index ?? this._index;

    if (targetParent && targetParent.nodeType === 1) {
        if (!targetParent.contains(this)) {
            if (targetIndex !== null) {
                targetParent.insertBefore(
                    this,
                    targetParent.children[targetIndex] || null
                );
            } else {
                targetParent.appendChild(this);
            }
        }
    }
    return this;
};

let elementsCollection = {};

function boundDOM(selector) {
    let substring;
    if (selector instanceof HTMLElement) {
        selector.removeAttribute("jid");
        return selector;
    } else {
        if (selector.startsWith("#")) {
            let element = document.querySelector(selector);
            if (element) element.removeAttribute("id");
            return element;
        } else if (selector.startsWith(".")) {
            let elements = document.querySelectorAll(selector);
            let className = selector.substring(1);
            elements.forEach((el) => el.classList.remove(className));
            return elements;
        } else {
            let elements = document.querySelectorAll(selector);
            substring = selector.substring(1, selector.indexOf("="));
            elements.forEach((el) => el.removeAttribute(substring));
            return elements;
        }
    }
}

function catchDOM(selector = null, elements = {}) {
    elements = Object.assign(elements, elementsCollection);

    if (selector) {
        elements[selector] = boundDOM(selector);
    } else {
        document.querySelectorAll("[jid]").forEach((element) => {
            const id = element.getAttribute("jid");
            elements[id] = boundDOM(element);
        });
    }

    elementsCollection = Object.assign(elementsCollection, elements);

    return elements;
}

const modal = (() => {
    function show(options = {}) {
        const {
            modalId = `modal-${Date.now()}-${Math.floor(
                Math.random() * 10000
            )}`,
            title = "",
            body = "",
            footer = "",
            size = "md",
            centered = false,
            backdrop = "default", // atau 'static'
        } = options;

        // Map ukuran
        const sizeMap = {
            sm: "sm:max-w-sm",
            md: "sm:max-w-lg",
            lg: "sm:max-w-xl",
            xl: "sm:max-w-2xl",
        };

        const sizeClass = sizeMap[size] || sizeMap.md;
        const alignClass = centered ? "flex items-center" : "";
        const dom = {};

        let instance = null;
        const modal = document.createElement("div");
        modal.className = `hs-overlay hs-overlay-modal hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none`;
        modal.setAttribute("role", "dialog");
        modal.setAttribute("tabindex", "-1");
        modal.setAttribute("id", modalId);
        modal.setAttribute("aria-labelledby", modalId + "-label");

        if (backdrop === "static") {
            modal.className += "[--overlay-backdrop:static]";
            modal.setAttribute("data-hs-overlay-keyboard", "false");
        }

        const animationTarget = document.createElement("div");
        animationTarget.className = `hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 ${sizeClass} sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] ${alignClass}`;

        const modalCard = document.createElement("div");
        modalCard.className =
            "w-full flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70";

        const header = document.createElement("div");
        header.className =
            "flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700";

        const h3 = document.createElement("h3");
        h3.className = "font-bold text-gray-800 dark:text-white";
        h3.textContent = title;

        const closeBtn = document.createElement("button");
        closeBtn.type = "button";
        closeBtn.className =
            "size-8 inline-flex justify-center items-center text-gray-800 rounded-full hover:bg-gray-200 dark:text-neutral-400 dark:hover:bg-neutral-600";
        closeBtn.setAttribute("aria-label", "Close");
        closeBtn.setAttribute("data-hs-overlay", `#${modalId}`);
        closeBtn.textContent = "✕";

        header.appendChild(h3);
        header.appendChild(closeBtn);

        const bodyEl = document.createElement("div");
        bodyEl.className = "p-4 overflow-y-auto";
        if (typeof body === "string") {
            bodyEl.innerHTML = body;
        } else if (body instanceof HTMLElement) {
            bodyEl.appendChild(body);
        }

        let footerEl = null;
        if (footer) {
            footerEl = document.createElement("div");
            footerEl.className =
                "flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700";

            const content =
                typeof footer === "function"
                    ? footer({
                          id: modalId,
                          modal,
                          instance,
                          close: () => hide(modal),
                      })
                    : footer;

            if (typeof content === "string") {
                footerEl.innerHTML = content;
            } else if (content instanceof HTMLElement) {
                footerEl.appendChild(content);
                dom.footer[content.name] = content;
            } else if (Array.isArray(content)) {
                content.forEach((el) => {
                    if (el instanceof HTMLElement) {
                        (dom.footer ??= {})[el.name] = el;
                        footerEl.appendChild(el);
                    }
                });
            }
        }

        modalCard.appendChild(header);
        modalCard.appendChild(bodyEl);
        if (footerEl) modalCard.appendChild(footerEl);

        animationTarget.appendChild(modalCard);
        modal.appendChild(animationTarget);
        document.body.appendChild(modal);

        instance = new HSOverlay(modal);
        modal.__instance = instance;
        instance.open();

        instance.on("close", () => {
            modal.remove();
        });

        return { id: modalId, modal, instance, close: () => hide(modal), dom };
    }

    function hide(target = null) {
        let modals = [];

        if (!target) {
            modals = document.querySelectorAll(".hs-overlay-modal");
        } else if (typeof target === "string") {
            const el = document.getElementById(target);
            if (el) modals.push(el);
        } else if (target instanceof HTMLElement) {
            modals.push(target);
        }

        modals.forEach((modal) => {
            const instance = modal.__instance; // ambil dari property sendiri
            if (instance && typeof instance.close === "function") {
                instance.close();
            }

            // Hapus dari DOM setelah animasi
            modal.addEventListener(
                "transitionend",
                () => {
                    modal.remove();
                },
                { once: true }
            );

            // Optional: fallback jika transitionend gak ke-trigger
            setTimeout(() => modal.remove(), 500);
        });
    }

    return { show, hide };
})();

function formatTanggalIndo(tanggalStr) {
    const hariIndo = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];
    const bulanIndo = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "Mei",
        "Jun",
        "Jul",
        "Agu",
        "Sep",
        "Okt",
        "Nov",
        "Des",
    ];

    const tanggalObj = new Date(tanggalStr.replace(" ", "T"));

    const hari = hariIndo[tanggalObj.getDay()];
    const tanggal = String(tanggalObj.getDate()).padStart(2, "0");
    const bulan = bulanIndo[tanggalObj.getMonth()];
    const tahun = String(tanggalObj.getFullYear()).slice(-2);
    const jam = String(tanggalObj.getHours()).padStart(2, "0");
    const menit = String(tanggalObj.getMinutes()).padStart(2, "0");

    return `${hari}, ${tanggal} ${bulan} ${tahun} - ${jam}:${menit}`;
}

function cloneDeep(obj) {
    if (obj === null || typeof obj !== "object") return obj;
    if (Array.isArray(obj)) return obj.map(cloneDeep);

    const cloned = {};
    for (let key in obj) {
        if (obj.hasOwnProperty(key)) {
            cloned[key] = cloneDeep(obj[key]);
        }
    }
    return cloned;
}

// Ekspor semua fungsi dalam satu objek
export default {
    showToast,
    generateRandomString,
    catchDOM,
    modal,
    formatTanggalIndo,
    cloneDeep,
};
