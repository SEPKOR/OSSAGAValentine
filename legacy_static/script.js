document.addEventListener("DOMContentLoaded", function () {
  // DOM Elements
  const isAnonymousCheckbox = document.getElementById("isAnonymous");
  const senderIdentityDiv = document.getElementById("senderIdentity");
  const anonymousIdentityDiv = document.getElementById("anonymousIdentity");

  // Inputs to toggle requirement
  const senderNameInput = document.getElementById("senderName");
  const senderInitialInput = document.getElementById("senderInitial");

  const bundleRadios = document.querySelectorAll('input[name="bundle"]');
  const letterSection = document.getElementById("letterSection");
  const messageInput = document.getElementById("messageContent");
  const totalPriceDisplay = document.getElementById("totalPrice");

  const orderForm = document.getElementById("orderForm");

  // 1. Logic: Toggle Anonymous
  isAnonymousCheckbox.addEventListener("change", function () {
    if (this.checked) {
      // Jika Anonymous checked
      senderIdentityDiv.classList.add("hidden");
      anonymousIdentityDiv.classList.remove("hidden");
      // Update required attributes
      senderNameInput.removeAttribute("required");
      senderInitialInput.setAttribute("required", "true");
    } else {
      // Jika tidak Anonymous
      senderIdentityDiv.classList.remove("hidden");
      anonymousIdentityDiv.classList.add("hidden");
      // Update required attributes
      senderInitialInput.removeAttribute("required");
      senderNameInput.setAttribute("required", "true");
    }
  });

  // 2. Logic: Bundle Selection & Letter Visibility & Price Update
  bundleRadios.forEach((radio) => {
    radio.addEventListener("change", function () {
      const price = parseInt(this.dataset.price);
      const hasLetter = this.dataset.hasLetter === "true";

      // Update Total Price
      totalPriceDisplay.textContent = "Rp " + price.toLocaleString("id-ID");

      // Show/Hide Letter Section
      if (hasLetter) {
        letterSection.classList.remove("hidden");
        messageInput.setAttribute("required", "true");
      } else {
        letterSection.classList.add("hidden");
        messageInput.removeAttribute("required");
        messageInput.value = ""; // Clear message if hidden
      }
    });
  });

  // Payment Logic
  const paymentOptions = document.querySelectorAll(".payment-option");
  const paymentInput = document.getElementById("paymentMethod");
  const detailsBoxes = document.querySelectorAll(".payment-details-box");

  paymentOptions.forEach((option) => {
    option.addEventListener("click", function () {
      // Remove active class from all
      paymentOptions.forEach((opt) => opt.classList.remove("active"));
      detailsBoxes.forEach((box) => box.classList.remove("active"));

      // Add active to clicked
      this.classList.add("active");

      // Set Hidden Input Value
      const value = this.dataset.value;
      paymentInput.value = value;

      // Show Details
      const detailId = `details-${value}`;
      document.getElementById(detailId).classList.add("active");
    });
  });

  // Upload Preview Logic
  const uploadBox = document.getElementById("uploadBox");
  const fileInput = document.getElementById("paymentProof");
  const previewImg = document.getElementById("imagePreview");
  const placeholder = document.getElementById("uploadPlaceholder");

  // Trigger file input when clicking box
  uploadBox.addEventListener("click", () => fileInput.click());

  // Handle file selection
  fileInput.addEventListener("change", function (e) {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();

      reader.onload = function (e) {
        previewImg.src = e.target.result;
        previewImg.classList.add("visible");
        placeholder.classList.add("hidden");
      };

      reader.readAsDataURL(file);
    }
  });

  // Modal Elements
  const modalOverlay = document.getElementById("customModal");
  const modalIcon = document.getElementById("modalIcon");
  const modalTitle = document.getElementById("modalTitle");
  const modalMessage = document.getElementById("modalMessage");
  const modalCloseBtn = document.getElementById("modalCloseBtn");

  // Function to show modal
  function showModal(type, title, message) {
    modalTitle.textContent = title;
    modalMessage.innerText = message; // Use innerText to preserve newlines

    if (type === "warning") {
      modalIcon.textContent = "⚠️";
      modalTitle.style.color = "var(--accent-red)";
    } else if (type === "success") {
      modalIcon.textContent = "💖";
      modalTitle.style.color = "var(--primary-pink)";
    }

    modalOverlay.classList.remove("hidden");
  }

  // Close Modal Event
  modalCloseBtn.addEventListener("click", () => {
    modalOverlay.classList.add("hidden");
  });

  // Close if clicked outside box
  modalOverlay.addEventListener("click", (e) => {
    if (e.target === modalOverlay) {
      modalOverlay.classList.add("hidden");
    }
  });

  // 3. Form Submission (Simulated)
  orderForm.addEventListener("submit", function (e) {
    e.preventDefault();

    // Collect Data
    const formData = new FormData(orderForm);
    const data = Object.fromEntries(formData.entries());

    // Basic Validation
    if (!data.bundle) {
      showModal("warning", "PERINGATAN!", "Pilih bundle dulu ya!");
      return;
    }

    if (!data.paymentMethod) {
      showModal("warning", "PERINGATAN!", "Pilih cara bayar dulu!");
      return;
    }

    // Just an alert for now
    // Short success message as requested (max 8 words)
    showModal(
      "success",
      "TERKIRIM!",
      "Pesanan berhasil! Kirim screenshot ke admin.",
    );
    // orderForm.reset();
  });
});
