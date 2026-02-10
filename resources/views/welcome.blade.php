<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SWEETALS - Sweet Petals</title>
    <link rel="icon" href="{{ asset('img/logo.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=VT323&family=Nunito:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=4.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    <div class="container">
      <!-- Header -->
      <header class="header-banner">
        <img src="{{ asset('img/banner.webp') }}" alt="Sweetals Banner" class="banner-img" />
      </header>

      <form id="orderForm">
        <!-- Sender Info -->
        <section class="pixel-box section-green">
          <h2>Data Pengirim</h2>
          <div class="form-group checkbox-group">
            <input type="checkbox" id="isAnonymous" name="isAnonymous" />
            <label for="isAnonymous">Kirim sebagai Anonymous?</label>
          </div>

          <div id="senderIdentity">
            <div class="form-group">
              <label for="senderName">Nama Pengirim</label>
              <input
                type="text"
                id="senderName"
                name="senderName"
                placeholder="Nama Kamu"
              />
            </div>
          </div>

          <div id="anonymousIdentity" class="hidden">
            <div class="form-group">
              <label for="senderInitial">Inisial</label>
              <input
                type="text"
                id="senderInitial"
                name="senderInitial"
                placeholder="Contoh: A.R"
              />
            </div>
            <p class="note">
              *Identitas asli tetap dibutuhkan untuk konfirmasi (privasi
              terjaga)
            </p>
          </div>

          <div class="form-group">
            <label for="senderContact"
              >Nomor HP / Sosmed (Untuk Konfirmasi)</label
            >
            <input
              type="text"
              id="senderContact"
              name="senderContact"
              placeholder="0812..."
              required
            />
          </div>
        </section>

        <!-- Recipient Info -->
        <section class="pixel-box section-blue">
          <h2>Data Penerima</h2>
          <div class="form-group">
            <label for="recipientName">Nama Penerima</label>
            <input
              type="text"
              id="recipientName"
              name="recipientName"
              placeholder="Nama Dia"
              required
            />
          </div>
          <div class="form-group">
            <label for="recipientClass">Kelas / Alamat</label>
            <input
              type="text"
              id="recipientClass"
              name="recipientClass"
              placeholder="Contoh: XII AK 1"
              required
            />
          </div>
          <div class="form-group">
            <label for="recipientContact">Sosmed / No. HP (Opsional)</label>
            <input
              type="text"
              id="recipientContact"
              name="recipientContact"
              placeholder="Jika tau"
            />
          </div>
        </section>

        <!-- Bundling Selection -->
        <section class="pixel-box section-orange">
          <h2>Pilih Bundling</h2>
          <div class="bundling-options">
            <label class="bundle-card">
              <input
                type="radio"
                name="bundle"
                value="cloud9"
                data-price="35000"
                data-has-letter="true"
                required
              />
              <span class="bundle-content">
                <span class="bundle-title">1. Cloud Nine</span>
                <span class="bundle-desc">Chocolate + Flower + Letter</span>
                <span class="bundle-price">Rp 35.000</span>
              </span>
            </label>

            <label class="bundle-card">
              <input
                type="radio"
                name="bundle"
                value="floral"
                data-price="30000"
                data-has-letter="false"
              />
              <span class="bundle-content">
                <span class="bundle-title">2. Floral Bliss</span>
                <span class="bundle-desc">Chocolate + Flower</span>
                <span class="bundle-price">Rp 30.000</span>
              </span>
            </label>

            <label class="bundle-card">
              <input
                type="radio"
                name="bundle"
                value="petals"
                data-price="15000"
                data-has-letter="true"
              />
              <span class="bundle-content">
                <span class="bundle-title">3. Petals & Prose</span>
                <span class="bundle-desc">Flower + Letter</span>
                <span class="bundle-price">Rp 15.000</span>
              </span>
            </label>

            <label class="bundle-card">
              <input
                type="radio"
                name="bundle"
                value="sugar"
                data-price="10000"
                data-has-letter="true"
              />
              <span class="bundle-content">
                <span class="bundle-title">4. Sugar Script</span>
                <span class="bundle-desc">Letter + 2 Candies</span>
                <span class="bundle-price">Rp 10.000</span>
              </span>
            </label>
          </div>
        </section>

        <!-- Letter Content (Dynamic) -->
        <section id="letterSection" class="pixel-box section-pink hidden">
          <h2>Isi Surat 💌</h2>
          <div class="form-group">
            <label for="messsageContent">Tulis pesan manismu di sini:</label>
            <textarea
              id="messageContent"
              name="messageContent"
              rows="5"
              placeholder="Dear..."
            ></textarea>
          </div>
        </section>

        <!-- Payment -->
        <section class="pixel-box section-purple">
          <h2>Pembayaran</h2>

          <div class="price-display">
            <span>Total:</span>
            <span id="totalPrice">Rp 0</span>
          </div>

          <div class="payment-terms">
            <h3>Ketentuan Pembayaran :</h3>
            <ul>
              <li>Pengirim wajib melakukan pembayaran ke nomer rekening, QRIS ataupun diberikan kepada salah satu pengurus OSIS (Apabila cash).</li>
              <li>Setiap transaksi pembayaran diharuskan melampirkan bukti baik dalam bentuk screenshot maupun foto serah terima.</li>
              <li>Bukti pembayaran dapat dilampirkan dengan cara diunggah pada kolom di bawah.</li>
              <li>Pesanan akan diproses apabila pihak penyedia barang sudah menerima bukti transaksi.</li>
            </ul>
          </div>

          <div class="form-group">
            <label>Metode Pembayaran</label>
            <input
              type="hidden"
              id="paymentMethod"
              name="paymentMethod"
              required
            />

            <div class="payment-grid">
              <div class="payment-option" data-value="transfer">TRANSFER</div>
              <div class="payment-option" data-value="qris">QRIS</div>
              <div class="payment-option" data-value="cash">CASH</div>
            </div>

            <div id="details-transfer" class="payment-details-box">
              <h3>Transfer Bank</h3>
              <p>BCA: 1234567890 (Abizar)</p>
              <p>Mandiri: 0987654321 (Abizar)</p>
            </div>

            <div id="details-qris" class="payment-details-box">
              <h3>Scan QRIS</h3>
              <img src="{{ asset('img/qris.jpeg') }}" alt="QRIS Code" class="qris-image" />
              <p style="text-align: center; font-size: 0.8rem; margin-top: 5px;">Scan untuk membayar</p>
            </div>

            <div id="details-cash" class="payment-details-box">
              <h3>Cash / COD</h3>
              <p>Uang bisa diserahkan secara langsung dari pihak pembeli kepada pihak penjual</p>
            </div>
          </div>

          <div class="form-group">
            <label>Bukti Pembayaran</label>
            <div class="upload-box" id="uploadBox">
              <input
                type="file"
                id="paymentProof"
                name="paymentProof"
                accept="image/*"
                hidden
              />
              <div class="upload-placeholder" id="uploadPlaceholder">
                <span style="font-size: 2rem">📷</span>
                <p>Klik untuk Upload Bukti</p>
                <p style="font-size: 0.8rem; color: #666">
                  (Support: JPG, PNG)
                </p>
              </div>
              <img id="imagePreview" class="image-preview hidden" />
            </div>
          </div>
        </section>

        <button type="submit" class="pixel-btn submit-btn">
          Send your order 💖
        </button>
      </form>

      <footer>
        <p>© 2026 OSSAGA. All rights reserved.</p>
      </footer>
    </div>

    <!-- Custom Pop-up Modal -->
    <div id="customModal" class="modal-overlay hidden">
      <div class="modal-box pixel-box">
        <div class="modal-content">
          <div id="modalIcon" class="modal-icon">⚠️</div>
          <h2 id="modalTitle">PERINGATAN!</h2>
          <p id="modalMessage">Mohon isi form dengan benar!</p>
          <button id="modalCloseBtn" class="pixel-btn modal-btn">OK</button>
        </div>
      </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
  </body>
</html>
