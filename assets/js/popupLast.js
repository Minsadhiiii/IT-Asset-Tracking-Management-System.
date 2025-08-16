

document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById("popup-overlay");

    // Buttons to open popups
    const buttons = {
        category: document.getElementById("add-category-btn"),
        manufacturer: document.getElementById("add-manufacturer-btn"),
        office: document.getElementById("add-office-btn"),
        supplier: document.getElementById("add-supplier-btn"),
    };

    // Popups
    const popups = {
        category: document.getElementById("popup-box-category"),
        manufacturer: document.getElementById("popup-box-manufacturer"),
        office: document.getElementById("popup-box-office"),
        supplier: document.getElementById("popup-box-supplier"),
    };

    // Close buttons for popups
    const closeButtons = {
        category: document.getElementById("close-popup-category"),
        manufacturer: document.getElementById("close-popup-manufacturer"),
        office: document.getElementById("close-popup-office"),
        supplier: document.getElementById("close-popup-supplier"),
    };

    // Disable scrolling when popup is active
    const disableScrolling = () => {
        document.body.style.overflow = "hidden";
    };

    // Enable scrolling when popup is closed
    const enableScrolling = () => {
        document.body.style.overflow = "auto";
    };

    // Show a specific popup
    function showPopup(popup) {
        overlay.style.display = "flex";
        popup.style.display = "block";
        disableScrolling();
    }

    // Hide a specific popup
    function hidePopup(popup) {
        overlay.style.display = "none";
        popup.style.display = "none";
        enableScrolling();
    }

    // Attach click events to buttons for opening popups
    Object.keys(buttons).forEach(key => {
        buttons[key]?.addEventListener("click", (e) => {
            e.preventDefault(); // Prevent form submission
            showPopup(popups[key]);
        });
    });

    // Attach click events to close buttons for closing popups
    Object.keys(closeButtons).forEach(key => {
        closeButtons[key]?.addEventListener("click", () => hidePopup(popups[key]));
    });

    // Hide popup when clicking outside (on the overlay)
    overlay.addEventListener("click", () => {
        Object.keys(popups).forEach(key => hidePopup(popups[key]));
    });

    // Prevent form submission on confirm buttons
    const confirmButtons = {
        category: document.getElementById("confirm-add-category"),
        manufacturer: document.getElementById("confirm-add-manufacturer"),
        office: document.getElementById("confirm-add-office"),
        supplier: document.getElementById("confirm-add-supplier"),
    };

    Object.keys(confirmButtons).forEach(key => {
        confirmButtons[key]?.addEventListener("click", (e) => {

            
            hidePopup(popups[key]);
        });
    });
});
