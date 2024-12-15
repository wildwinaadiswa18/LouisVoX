<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>E-Learning</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="icon" href="../assets/img/sekolah/favicon.ico" type="image/x-icon" />
  <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: {
        families: ["Public Sans:300,400,500,600,700"]
      },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["../assets/css/fonts.min.css"],
      },
      active: function () {
        sessionStorage.fonts = true;
      },
    });
  </script>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/plugins.min.css" />
  <link rel="stylesheet" href="../assets/css/main.min.css" />
  <style>
    /* Styling Chatbot */
    #chatbot {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 300px;
      height: 400px;
      border: 1px solid #ccc;
      border-radius: 10px;
      background-color: white;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      display: none;
    }

    #chatbot-header {
      background-color: #007bff;
      color: white;
      padding: 10px;
      font-weight: bold;
      text-align: center;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    #chatbot-messages {
      padding: 10px;
      height: 300px;
      overflow-y: auto;
      border-bottom: 1px solid #ccc;
    }

    #chatbot-input {
      width: 100%;
      padding: 10px;
      border: none;
      border-top: 1px solid #ccc;
      border-bottom-left-radius: 10px;
      border-bottom-right-radius: 10px;
    }

    #chatbot-icon {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #007bff;
      color: white;
      padding: 10px;
      border-radius: 50%;
      cursor: pointer;
      font-size: 24px;
    }
  </style>
</head>

<body>
  <?php
  require '../config.php';

  // Query untuk mengambil jumlah tugas yang belum dikerjakan oleh siswa
  $current_time = new DateTime();
  $current_time = $current_time->format("Y-m-d H:i");
  $ttugas_query = $conn->query("SELECT * FROM `tbtugasdtl` ttd WHERE STR_TO_DATE(ttd.mulai, '%Y-%m-%d %H:%i') < STR_TO_DATE('$current_time', '%Y-%m-%d %H:%i') AND STR_TO_DATE(ttd.selesai, '%Y-%m-%d %H:%i') > STR_TO_DATE('$current_time', '%Y-%m-%d %H:%i');");

  // Cek apakah query berhasil dan mendapatkan hasil
  $ttugas = $ttugas_query ? $ttugas_query->num_rows : 0;
  ?>
  <div class="wrapper">
    <?php
    $menu = "index";
    require 'menu.php';
    ?>

    <div class="main-panel">
      <?php require 'header.php'; ?>

      <div class="container">
        <div class="page-inner">
          <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Dashboard</h3>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
              <!-- Optional align right content -->
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-sm-6 col-lg-4">
              <div class="text-decoration-none">
                <div class="card shadow-sm border-0">
                  <div class="card-body p-4 text-center">
                    <div class="h1 m-0 text-primary">
                      <i class="fas fa-tasks"></i> <?= $ttugas; ?>
                    </div>
                    <div class="text-muted mb-3">
                      <strong>Tugas yang belum kamu kerjakan</strong>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Add other information cards if necessary -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Chatbot Icon -->
  <div id="chatbot-icon" onclick="toggleChatbot()">
    <i class="fas fa-comments"></i>
  </div>

  <!-- Chatbot -->
  <div id="chatbot">
    <div id="chatbot-header">Chatbot Siswa</div>
    <div id="chatbot-messages">
      <div><b>Bot:</b> Halo! Apa yang bisa saya bantu terkait tugas atau jadwal Anda hari ini?</div>
    </div>
    <input type="text" id="chatbot-input" placeholder="Ketikkan pesan..." />
  </div>

  <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>

  <!-- Chatbot JavaScript -->
  <script>
    // Fungsi untuk membuka dan menutup chatbot
    function toggleChatbot() {
      var chatbot = document.getElementById('chatbot');
      chatbot.style.display = (chatbot.style.display === 'none' || chatbot.style.display === '') ? 'block' : 'none';
    }

    // Menangani input pengguna dan memberikan respons
    document.getElementById('chatbot-input').addEventListener('keypress', function (e) {
      if (e.key === 'Enter') {
        var userMessage = e.target.value;
        var chatbotMessages = document.getElementById('chatbot-messages');

        // Hapus percakapan sebelumnya
        chatbotMessages.innerHTML = '<div><b>Bot:</b> Halo! Apa yang bisa saya bantu terkait tugas atau jadwal Anda hari ini?</div>';

        // Tampilkan pesan pengguna
        var newMessage = document.createElement('div');
        newMessage.innerHTML = '<b>Anda:</b> ' + userMessage;
        chatbotMessages.appendChild(newMessage);

        // Respons chatbot berdasarkan pesan pengguna
        var botResponse = '';
        if (userMessage.toLowerCase().includes('tugas')) {
          botResponse = '<b>Bot:</b> Berikut adalah tugas yang belum Anda kerjakan: 1. Menyelesaikan tugas Matematika, 2. Menyusun laporan Kimia, 3. Mempersiapkan presentasi Bahasa Indonesia.';
        } else if (userMessage.toLowerCase().includes('jadwal')) {
          botResponse = '<b>Bot:</b> Jadwal pelajaran Anda hari ini adalah: Matematika (09:00 - 10:00), Bahasa Inggris (10:30 - 11:30), Sejarah (12:00 - 13:00).';
        } else if (userMessage.toLowerCase().includes('nilai')) {
          botResponse = '<b>Bot:</b> Untuk melihat nilai Anda, silakan login ke portal siswa atau tanyakan kepada guru Anda.';
        } else if (userMessage.toLowerCase().includes('terima kasih')) {
          botResponse = '<b>Bot:</b> Sama-sama! Semoga hari Anda menyenangkan! Jika ada yang perlu dibantu lagi, jangan ragu untuk bertanya!';
        } else if (userMessage.toLowerCase().includes('halo')) {
          botResponse = '<b>Bot:</b> Hai, selamat datang! Ada yang bisa saya bantu?';
        } else {
          botResponse = '<b>Bot:</b> Maaf, saya tidak mengerti pertanyaan Anda. Bisakah Anda mengulanginya?';
        }

        var botMessage = document.createElement('div');
        botMessage.innerHTML = botResponse;
        chatbotMessages.appendChild(botMessage);

        // Kosongkan input setelah pengiriman pesan
        e.target.value = '';

        // Gulir ke bawah
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
      }
    });
  </script>

  <!-- Optional external JS -->
  <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
  <script src="../assets/js/plugin/chart.js/chart.min.js"></script>
  <script src="../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
  <script src="../assets/js/plugin/chart-circle/circles.min.js"></script>
  <script src="../assets/js/plugin/datatables/datatables.min.js"></script>
  <script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
  <script src="../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
  <script src="../assets/js/plugin/jsvectormap/world.js"></script>
  <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>
  <script src="../assets/js/main.min.js"></script>
</body>

</html>
