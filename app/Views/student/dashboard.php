<!DOCTYPE html>
<html lang="tr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Student Dashboard</title>

    <link
        rel="stylesheet"
        href="<?= base_url('student.css') ?>"
    >

</head>


<body class="dashboard-page">


    <?= view('layouts/student_sidebar') ?>


    <!-- ==============================
         TEMA DEKORASYONLARI
         ============================== -->

    <div
        class="dashboard-sakura-decoration"
        id="dashboardSakuraDecoration"
        aria-hidden="true"
    ></div>


    <div
        class="dashboard-dark-decoration"
        id="dashboardDarkDecoration"
        aria-hidden="true"
    ></div>


    <div
        class="dashboard-ocean-decoration"
        id="dashboardOceanDecoration"
        aria-hidden="true"
    ></div>


    <main class="main-content dashboard-main">


        <!-- ==============================
             KARŞILAMA
             ============================== -->

        <section class="dashboard-welcome">

            <div class="dashboard-welcome-text">

                <p class="dashboard-eyebrow">
                    ÖĞRENCİ PANELİ
                </p>


                <h1>
                    Hoş geldin,
                    <?= esc($username ?? 'Öğrenci') ?>! 👋
                </h1>


                <p class="dashboard-welcome-description">
                    Bugün kendin için küçük bir adım atmaya ne dersin?
                    Kitaplarını takip et, programını düzenle ve
                    Öğrenci Asistanı'ndan yardım al.
                </p>

            </div>


            <div class="dashboard-welcome-icon">
                🎓
            </div>

        </section>



        <!-- ==============================
             HIZLI ERİŞİM
             ============================== -->

        <section class="dashboard-section">

            <div class="dashboard-section-heading">

                <p class="dashboard-eyebrow">
                    GENEL DURUM
                </p>

                <h2>
                    Öğrenci hayatına hızlıca göz at
                </h2>

            </div>


            <div class="dashboard-quick-grid">


                <!-- =========================
                     KİTAPLAR
                     ========================= -->

                <a
                    href="<?= base_url('/student/library') ?>"
                    class="dashboard-card dashboard-card-library"
                >

                    <div class="dashboard-card-icon">
                        📚
                    </div>


                    <div class="dashboard-card-content">

                        <h3>
                            Kitaplığım
                        </h3>


                        <p>

                            Toplam
                            <strong>
                                <?= esc($totalBooks ?? 0) ?>
                            </strong>
                            kitap

                            <br>

                            📖
                            <?= esc($readingBooks ?? 0) ?>
                            okunuyor

                            ·

                            ✅
                            <?= esc($completedBooks ?? 0) ?>
                            tamamlandı

                        </p>

                    </div>


                    <span class="dashboard-card-arrow">
                        →
                    </span>

                </a>



                <!-- =========================
                     BUGÜNÜN PROGRAMI
                     ========================= -->

                <a
                    href="<?= base_url('/student/planner') ?>"
                    class="dashboard-card dashboard-card-planner"
                >

                    <div class="dashboard-card-icon">
                        📅
                    </div>


                    <div class="dashboard-card-content">

                        <h3>
                            Bugünün Programı
                        </h3>


                        <p>

                            Bugün

                            <strong>
                                <?= esc(count($todayEvents ?? [])) ?>
                            </strong>

                            görev var.

                            <br>

                            ⏳
                            <strong>
                                <?= esc($todayPendingEvents ?? 0) ?>
                            </strong>

                            görev bekliyor.

                        </p>

                    </div>


                    <span class="dashboard-card-arrow">
                        →
                    </span>

                </a>



                <!-- =========================
                     CHATBOT
                     ========================= -->

                <a
                    href="<?= base_url('/student/chatbot') ?>"
                    class="dashboard-card dashboard-card-chatbot"
                >

                    <div class="dashboard-card-icon">
                        🤖
                    </div>


                    <div class="dashboard-card-content">

                        <h3>
                            Öğrenci Asistanı
                        </h3>


                        <p>
                            Ders, ödev, sınav ve çalışma
                            konusunda yardım al.
                        </p>

                    </div>


                    <span class="dashboard-card-arrow">
                        →
                    </span>

                </a>


            </div>

        </section>



        <!-- ==============================
             BUGÜN
             ============================== -->

        <section class="dashboard-section dashboard-today-section">


            <div class="dashboard-section-heading">

                <p class="dashboard-eyebrow">
                    BUGÜN
                </p>


                <h2>
                    Küçük adımlar, büyük ilerlemeler. 🌱
                </h2>

            </div>


            <div class="dashboard-today-grid">


                <!-- =========================
                     KİTAP
                     ========================= -->

                <div class="dashboard-today-card">

                    <span class="dashboard-today-icon">
                        📖
                    </span>


                    <div>

                        <h3>
                            Kitap okumaya devam et
                        </h3>


                        <p>

                            Kitaplığında

                            <strong>
                                <?= esc($readingBooks ?? 0) ?>
                            </strong>

                            kitap okuyorsun.

                            Bugün birkaç sayfa okumayı
                            deneyebilirsin.

                        </p>

                    </div>

                </div>



                <!-- =========================
                     PROGRAM
                     ========================= -->

                <div class="dashboard-today-card">

                    <span class="dashboard-today-icon">
                        📝
                    </span>


                    <div>

                        <h3>
                            Bugünkü görevlerin
                        </h3>


                        <p>

                            Bugün

                            <strong>
                                <?= esc($todayPendingEvents ?? 0) ?>
                            </strong>

                            tamamlanmamış görevin bulunuyor.

                            Programına göz atabilirsin.

                        </p>

                    </div>

                </div>



                <!-- =========================
                     HATIRLATICI
                     ========================= -->

                <div class="dashboard-today-card">

                    <span class="dashboard-today-icon">
                        🔔
                    </span>


                    <div>

                        <h3>
                            Önemli hatırlatıcılar
                        </h3>


                        <p>

                            Şu anda

                            <strong>
                                <?= esc(count($pendingReminders ?? [])) ?>
                            </strong>

                            tamamlanmamış önemli
                            hatırlatıcın var.

                        </p>

                    </div>

                </div>


            </div>

        </section>



        <!-- ==============================
             BUGÜNKÜ GÖREVLER
             ============================== -->

        <?php if (!empty($todayEvents)): ?>

            <section class="dashboard-section">

                <div class="dashboard-section-heading">

                    <p class="dashboard-eyebrow">
                        BUGÜNÜN GÖREVLERİ
                    </p>

                    <h2>
                        Programında neler var?
                    </h2>

                </div>


                <div class="dashboard-today-grid">


                    <?php foreach ($todayEvents as $event): ?>

                        <div class="dashboard-today-card">

                            <span class="dashboard-today-icon">
                                <?= !empty($event['is_completed'])
                                    ? '✅'
                                    : '⏰'
                                ?>
                            </span>


                            <div>

                                <h3>
                                    <?= esc($event['title']) ?>
                                </h3>


                                <p>

                                    <?php if (!empty($event['start_time'])): ?>

                                        🕐
                                        <?= esc(
                                            substr(
                                                $event['start_time'],
                                                0,
                                                5
                                            )
                                        ) ?>

                                    <?php endif; ?>


                                    <?php if (!empty($event['description'])): ?>

                                        <br>

                                        <?= esc($event['description']) ?>

                                    <?php endif; ?>


                                    <?php if (!empty($event['is_completed'])): ?>

                                        <br>
                                        <strong>
                                            Tamamlandı ✓
                                        </strong>

                                    <?php endif; ?>

                                </p>

                            </div>

                        </div>

                    <?php endforeach; ?>


                </div>

            </section>

        <?php endif; ?>



        <!-- ==============================
             ÖNEMLİ HATIRLATICILAR
             ============================== -->

        <?php if (!empty($pendingReminders)): ?>

            <section class="dashboard-section">

                <div class="dashboard-section-heading">

                    <p class="dashboard-eyebrow">
                        HATIRLATICILAR
                    </p>

                    <h2>
                        Unutmaman gerekenler 🔔
                    </h2>

                </div>


                <div class="dashboard-today-grid">


                    <?php foreach (
                        array_slice($pendingReminders, 0, 3)
                        as $reminder
                    ): ?>

                        <div class="dashboard-today-card">

                            <span class="dashboard-today-icon">
                                🔔
                            </span>


                            <div>

                                <h3>
                                    <?= esc($reminder['title']) ?>
                                </h3>


                                <p>
                                    Önemli hatırlatıcı
                                </p>

                            </div>

                        </div>

                    <?php endforeach; ?>


                </div>

            </section>

        <?php endif; ?>


    </main>



    <!-- ==============================
         TEMA JAVASCRIPT
         ============================== -->

    <script>

    (function () {


        const sakuraDecoration =
            document.getElementById(
                'dashboardSakuraDecoration'
            );


        const darkDecoration =
            document.getElementById(
                'dashboardDarkDecoration'
            );


        const oceanDecoration =
            document.getElementById(
                'dashboardOceanDecoration'
            );



        function updateDashboardTheme(theme) {


            /* =========================
               🌸 SAKURA
               ========================= */

            if (theme === 'sakura') {


                if (sakuraDecoration) {

                    sakuraDecoration.innerHTML = `
                        <span>🌸</span>
                        <span>🌸</span>
                        <span>🌸</span>
                        <span>🌸</span>
                        <span>🌸</span>
                        <span>🌸</span>
                        <span>🌸</span>
                        <span>🌸</span>
                    `;

                    sakuraDecoration.style.display =
                        'block';

                }


                if (darkDecoration) {

                    darkDecoration.innerHTML = '';

                    darkDecoration.style.display =
                        'none';

                }


                if (oceanDecoration) {

                    oceanDecoration.innerHTML = '';

                    oceanDecoration.style.display =
                        'none';

                }

            }



            /* =========================
               🪦 DARK
               ========================= */

            else if (theme === 'dark') {


                if (sakuraDecoration) {

                    sakuraDecoration.innerHTML = '';

                    sakuraDecoration.style.display =
                        'none';

                }


                if (darkDecoration) {

                    darkDecoration.innerHTML = `

                        <span class="dashboard-bat dashboard-bat-1">
                            🦇
                        </span>

                        <span class="dashboard-bat dashboard-bat-2">
                            🦇
                        </span>

                        <span class="dashboard-bat dashboard-bat-3">
                            🦇
                        </span>

                        <span class="dashboard-bat dashboard-bat-4">
                            🦇
                        </span>

                    `;

                    darkDecoration.style.display =
                        'block';

                }


                if (oceanDecoration) {

                    oceanDecoration.innerHTML = '';

                    oceanDecoration.style.display =
                        'none';

                }

            }



            /* =========================
               🌊 OCEAN
               ========================= */

            else {


                if (sakuraDecoration) {

                    sakuraDecoration.innerHTML = '';

                    sakuraDecoration.style.display =
                        'none';

                }


                if (darkDecoration) {

                    darkDecoration.innerHTML = '';

                    darkDecoration.style.display =
                        'none';

                }


                if (oceanDecoration) {

                    oceanDecoration.innerHTML = `

                        <span class="dashboard-ocean-wave wave-1"></span>

                        <span class="dashboard-ocean-wave wave-2"></span>

                        <span class="dashboard-bubble bubble-1"></span>
                        <span class="dashboard-bubble bubble-2"></span>
                        <span class="dashboard-bubble bubble-3"></span>
                        <span class="dashboard-bubble bubble-4"></span>
                        <span class="dashboard-bubble bubble-5"></span>
                        <span class="dashboard-bubble bubble-6"></span>

                    `;

                    oceanDecoration.style.display =
                        'block';

                }

            }

        }



        window.addEventListener(
            'themeChanged',
            function (event) {

                updateDashboardTheme(
                    event.detail.theme
                );

            }
        );



        const currentTheme =
            localStorage.getItem('studentTheme') ||
            document.body.getAttribute('data-theme') ||
            'sakura';


        updateDashboardTheme(
            currentTheme
        );


    })();

    </script>


</body>

</html>