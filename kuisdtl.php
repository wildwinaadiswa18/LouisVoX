<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>E-Learning</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="../assets/img/sekolah/favicon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
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
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <style>
        .question-container {
            display: none;
        }
        .question-container.active {
            display: block;
        }
        .question-buttons button {
            width: 60px;
            height: 40px;
            margin: 5px;
            text-align: center;
        }

        .question-buttons {
            margin-top: 0;
            text-align: right;
            align-self: flex-start;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-success:disabled, .btn-danger:disabled {
            cursor: not-allowed;
        }
        #finish-button {
            margin-top: 20px;
            text-align: center;
        }
    </style>
  </head>
  <body>
    <?php require '../config.php'; ?>
    <div class="wrapper">
       <?php
        $menu = "Quiz";
        require 'menu.php';
       ?>

      <div class="main-panel">
         <?php require 'header.php'; ?>
        <div class="container">
          <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div class="page-header">
                    <h3 class="fw-bold mb-3">Kuis</h3>
                </div>
                <div class="ms-md-auto py-2 py-md-0">
                </div>
            </div>
            <?php
            if(isset($_POST['mulai']) && isset($_GET['id'])){
                $id_kuis = $_GET['id'];
                $_SESSION['jawab'] = ['id' => $id_kuis, 'jawab' => [], 'soal' => []];
                echo '<script type="text/javascript">';
                echo 'window.location.href="'.url("/siswa/kuisdtl.php?id=".$_SESSION['jawab']['id']).'";';
                echo '</script>';
            }else if(isset($_SESSION['jawab']) && !isset($_GET['id']) || $_GET['id'] == null){
                echo '<script type="text/javascript">';
                echo 'window.location.href="'.url("/siswa/kuisdtl.php?id=".$_SESSION['jawab']['id']).'";';
                echo '</script>';
            }
            $jawab = $_SESSION['jawab'];
            $id_kuis = $_GET['id'];
            ?>
            <div class="row">
                <?php
                    $qk = $conn->query("SELECT * FROM tbkuisdtl WHERE id_kuis = '$id_kuis' ORDER BY no ASC;");
                    $i = 1;
                    while($dk = $qk->fetch_assoc()){
                ?>
                <div id="question<?= $dk['no']; ?>" class="question-container <?= ($i == 1)? 'active': ''; ?>">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5 class="fw-bold"><?= $dk['no'].". ".$dk['soal']; ?></h5>
                            <div>
                                <input type="radio" id="soal<?= $dk['no']; ?>_jawaban1" name="jawab<?= $dk['no']; ?>" value="<?= $dk['a']; ?>" onclick="checkAnswer(<?= $dk['no']; ?>, 'A')" <?php if(isset($_SESSION['jawab']['jawab'][$i])){ echo 'disabled '; if($_SESSION['jawab']['jawab'][$i] == 'A'){ echo ' checked'; }} ?> >
                                <label for="soal<?= $dk['no']; ?>_jawaban1"><?= $dk['a']; ?></label><br>
                                <input type="radio" id="soal<?= $dk['no']; ?>_jawaban2" name="jawab<?= $dk['no']; ?>" value="<?= $dk['b']; ?>" onclick="checkAnswer(<?= $dk['no']; ?>, 'B')" <?php if(isset($_SESSION['jawab']['jawab'][$i])){ echo 'disabled '; if($_SESSION['jawab']['jawab'][$i] == 'B'){ echo ' checked'; }} ?> >
                                <label for="soal<?= $dk['no']; ?>_jawaban2"><?= $dk['b']; ?></label><br>
                                <input type="radio" id="soal<?= $dk['no']; ?>_jawaban3" name="jawab<?= $dk['no']; ?>" value="<?= $dk['c']; ?>" onclick="checkAnswer(<?= $dk['no']; ?>, 'C')" <?php if(isset($_SESSION['jawab']['jawab'][$i])){ echo 'disabled '; if($_SESSION['jawab']['jawab'][$i] == 'C'){ echo ' checked'; }} ?>>
                                <label for="soal<?= $dk['no']; ?>_jawaban3"><?= $dk['c']; ?></label><br>
                                <input type="radio" id="soal<?= $dk['no']; ?>_jawaban4" name="jawab<?= $dk['no']; ?>" value="<?= $dk['d']; ?>" onclick="checkAnswer(<?= $dk['no']; ?>, 'D')" <?php if(isset($_SESSION['jawab']['jawab'][$i])){ echo 'disabled '; if($_SESSION['jawab']['jawab'][$i] == 'D'){ echo ' checked'; }} ?>>
                                <label for="soal<?= $dk['no']; ?>_jawaban3"><?= $dk['d']; ?></label><br>
                            </div>
                        </div>
                        <div class="question-buttons"></div>
                    </div>
                </div>
            <?php 
                $i++;
                }
            ?>
          </div>
          <div id="finish-button">
              <button class="btn btn-primary" onclick="finishQuiz()">Selesai</button>
          </div>

          </div>
        </div>
      </div>
    </div>
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
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

    <script>
        // seesion php
        let answeredQuestions = <?= json_encode($jawab['jawab']) ?>;
        const totalQuestions = <?= $qk->num_rows; ?>;

        $(document).ready(function() {
            generateButtons(totalQuestions);
            refreshAnsweredQuestions();
            checkAllAnswered();
        });

        function refreshAnsweredQuestions() {
            $.ajax({
                url: '<?= url("/siswa/do-dtlkuis.php") ?>',
                type: 'GET',
                success: function(data, textStatus, xhr) {
                    let result = JSON.parse(data);

                    // Update answeredQuestions based on session data
                    answeredQuestions = result.jawab || {};

                    // Update the UI based on answeredQuestions
                    for (let questionNumber in answeredQuestions) {
                        if (answeredQuestions.hasOwnProperty(questionNumber)) {
                            const $buttons = $(`.question-buttons button[data-question="${questionNumber}"]`);
                            if (answeredQuestions[questionNumber]) {
                                $buttons.addClass('btn-success').prop('disabled', true);
                            } else {
                                $buttons.addClass('btn-danger').prop('disabled', true);
                            }
                        }
                    }
                    checkAllAnswered();
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }
        function checkAnswer(questionNumber, selectedAnswer) {
            const $buttons = $(`.question-buttons button[data-question="${questionNumber}"]`);
            answeredQuestions[selectedAnswer] = selectedAnswer;
            checkAllAnswered();
            for (let i = 1; i <= 4; i++) {
                $(`#soal${questionNumber}_jawaban${i}`).prop('disabled', true);
            }
            $.ajax({
                url: '<?= url("/siswa/do-dtlkuis.php")?>',
                type: 'POST',
                data: {jawab: selectedAnswer, no:questionNumber},
                success: function(data, textStatus, xhr) {
                    let hasil = data;
                    console.log(hasil);
                    $buttons.removeClass('btn-primary btn-success btn-danger');
                    if (hasil['hasil']) {
                        $buttons.addClass('btn-success').prop('disabled', true);
                    } else {
                        $buttons.addClass('btn-danger').prop('disabled', true);
                    }
                },error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }
        function checkAllAnswered() {
            if (Object.keys(answeredQuestions).length === totalQuestions) {
                $('#finish-button').show();
            }
        }
        function generateButtons(total) {
            $('.question-buttons').each(function() {
                $(this).empty();

                for (let i = 1; i <= total; i++) {
                    const $button = $('<button>')
                        .addClass('btn btn-primary')
                        .attr('data-question', i)
                        .text(i)
                        .on('click', function() {
                            showQuestion(i);
                        });

                    $(this).append($button);

                    if (i % 3 === 0) {
                        $(this).append('<br>');
                    }
                }
            });
        }
        function showQuestion(questionNumber) {
            $('.question-container').removeClass('active');
            $(`#question${questionNumber}`).addClass('active');

            if (answeredQuestions[questionNumber]) {
                $(`.question-buttons button[data-question="${questionNumber}"]`).each(function() {
                    $(this).removeClass('btn-primary');
                    $(this).addClass(answeredQuestions[questionNumber] === true ? 'btn-success' : 'btn-danger');
                    $(this).prop('disabled', true);
                });
            }
        }
        function finishQuiz() {
            const confirmFinish = confirm("Apakah Anda yakin semua jawaban sudah benar? Klik 'OK' untuk menyelesaikan kuis atau 'Cancel' untuk kembali memeriksa jawaban Anda.");

            if (confirmFinish) {
                $.ajax({
                    url: '<?= url("/siswa/do-dtlkuis.php")?>',
                    type: 'PUT',
                    data: "",
                    success: function(data, textStatus, xhr) {
                        console.log(data);
                        window.location.href = '<?= url('/siswa/kuisselesai.php'); ?>';
                    },error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }
        }


    </script>
  </body>
</html>
