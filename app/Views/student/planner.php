<!DOCTYPE html>
<html lang="tr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Haftalık Program</title>

    <link
        rel="stylesheet"
        href="<?= base_url('student.css') ?>"
    >

</head>

<body class="planner-page">

    <?= view('layouts/student_sidebar') ?>

    <!-- TEMA DEKORASYONLARI -->
    <div
        class="planner-sakura-decoration"
        id="plannerSakuraDecoration"
        aria-hidden="true"
    ></div>

    <div
        class="planner-dark-atmosphere"
        id="plannerDarkAtmosphere"
        aria-hidden="true"
    ></div>

    <div
        class="planner-ocean-decoration"
        id="plannerOceanDecoration"
        aria-hidden="true"
    ></div>

    <main class="main-content">

        <div class="planner-layout">

            <!-- DARK TEMADA SAYFAYLA BİRLİKTE KAYAN DEKORASYONLAR -->
            <div
                class="planner-scroll-decoration"
                id="plannerScrollDecoration"
                aria-hidden="true"
            ></div>


            <!-- ================================= -->
            <!-- ORTA: HAFTALIK PLANLAYICI -->
            <!-- ================================= -->

            <section class="planner-section">

                <h1>📅 Haftalık Program</h1>

                <p>
                    <?= esc($weekStart) ?>
                    -
                    <?= esc($weekEnd) ?>
                </p>


                <?php

                $days = [
                    'Pazartesi',
                    'Salı',
                    'Çarşamba',
                    'Perşembe',
                    'Cuma',
                    'Cumartesi',
                    'Pazar'
                ];

                ?>


                <div class="week-grid">


                    <?php foreach ($days as $index => $day): ?>

                        <?php

                        $date = new \DateTime($weekStart);

                        $date->modify(
                            '+' . $index . ' days'
                        );

                        $dayDate =
                            $date->format('Y-m-d');


                        $dayEvents = array_filter(
                            $events,
                            function ($event) use ($dayDate) {

                                return $event['event_date']
                                    === $dayDate;
                            }
                        );

                        ?>


                        <div class="day-box">

                            <h2>
                                <?= $day ?>
                            </h2>

                            <p>
                                <?= esc($dayDate) ?>
                            </p>


                            <?php if (empty($dayEvents)): ?>

                                <p>
                                    Henüz görev yok.
                                </p>

                            <?php else: ?>


                                <?php foreach ($dayEvents as $event): ?>

                                    <div class="planner-event">

                                        <strong>
                                            <?= esc(
                                                $event['title']
                                            ) ?>
                                        </strong>


                                        <?php if (
                                            !empty(
                                                $event['start_time']
                                            )
                                        ): ?>

                                            <p>
                                                🕐
                                                <?= esc(
                                                    substr(
                                                        $event['start_time'],
                                                        0,
                                                        5
                                                    )
                                                ) ?>

                                                <?php if (
                                                    !empty(
                                                        $event['end_time']
                                                    )
                                                ): ?>

                                                    -
                                                    <?= esc(
                                                        substr(
                                                            $event['end_time'],
                                                            0,
                                                            5
                                                        )
                                                    ) ?>

                                                <?php endif; ?>

                                            </p>

                                        <?php endif; ?>


                                        <?php if (
                                            !empty(
                                                $event['description']
                                            )
                                        ): ?>

                                            <p>
                                                <?= esc(
                                                    $event['description']
                                                ) ?>
                                            </p>

                                        <?php endif; ?>


                                        <?php if (
                                            !empty(
                                                $event['reminder_at']
                                            )
                                        ): ?>

                                            <p>
                                                🔔
                                                <?= esc(
                                                    date(
                                                        'd.m.Y H:i',
                                                        strtotime(
                                                            $event['reminder_at']
                                                        )
                                                    )
                                                ) ?>
                                            </p>

                                        <?php endif; ?>


                                        <?php if (
                                            $event['is_completed']
                                        ): ?>

                                            <p>
                                                ✅ Tamamlandı
                                            </p>

                                        <?php else: ?>

                                            <p>
                                                ⏳ Devam ediyor
                                            </p>

                                        <?php endif; ?>


                                        <a
                                            href="<?= base_url(
                                                '/student/planner/toggle-event/'
                                                . $event['id']
                                            ) ?>"
                                        >
                                            ✔ Tamamlandı
                                        </a>

                                        |

                                        <a
                                            href="<?= base_url(
                                                '/student/planner/delete-event/'
                                                . $event['id']
                                            ) ?>"
                                        >
                                            🗑 Sil
                                        </a>

                                    </div>

                                <?php endforeach; ?>

                            <?php endif; ?>


                            <a
                                href="<?= base_url(
                                    '/student/planner/add-event?date='
                                    . $dayDate
                                ) ?>"
                            >
                                ➕ Görev Ekle
                            </a>

                        </div>


                    <?php endforeach; ?>


                </div>

            </section>


            <!-- ================================= -->
            <!-- SAĞ: TAKVİM + DON'T FORGET -->
            <!-- ================================= -->

            <aside class="planner-right">


                <!-- TAKVİM -->
              <section class="calendar-section">

    <h2>📅 Takvim</h2>

    <?php
    $monthNames = [
        1 => 'Ocak',
        2 => 'Şubat',
        3 => 'Mart',
        4 => 'Nisan',
        5 => 'Mayıs',
        6 => 'Haziran',
        7 => 'Temmuz',
        8 => 'Ağustos',
        9 => 'Eylül',
        10 => 'Ekim',
        11 => 'Kasım',
        12 => 'Aralık'
    ];

    $monthStart = new \DateTime(
        $calendarYear . '-' . $calendarMonth . '-01'
    );

    $daysInMonth = (int) $monthStart->format('t');

    // Pazartesi = 1, Pazar = 7
    $firstDayOfWeek = (int) $monthStart->format('N');

    // Önceki ay
    $previousMonth = clone $monthStart;
    $previousMonth->modify('-1 month');

    // Sonraki ay
    $nextMonth = clone $monthStart;
    $nextMonth->modify('+1 month');

    $todayDate = date('Y-m-d');
    ?>

    <div class="calendar-header">

        <a
            href="<?= base_url(
                '/student/planner?month=' .
                $previousMonth->format('m') .
                '&year=' .
                $previousMonth->format('Y')
            ) ?>"
        >
            ←
        </a>

        <strong>
            <?= $monthNames[$calendarMonth] . ' ' . $calendarYear ?>
        </strong>

        <a
            href="<?= base_url(
                '/student/planner?month=' .
                $nextMonth->format('m') .
                '&year=' .
                $nextMonth->format('Y')
            ) ?>"
        >
            →
        </a>

    </div>


    <div class="calendar-weekdays">
        <div>Pzt</div>
        <div>Sal</div>
        <div>Çar</div>
        <div>Per</div>
        <div>Cum</div>
        <div>Cmt</div>
        <div>Paz</div>
    </div>


    <div class="calendar-grid">

        <?php
        // Ayın başlangıcındaki boş günler
        for ($i = 1; $i < $firstDayOfWeek; $i++):
        ?>

            <div class="calendar-day empty"></div>

        <?php endfor; ?>


        <?php for ($day = 1; $day <= $daysInMonth; $day++): ?>

            <?php
            $dateString = sprintf(
                '%04d-%02d-%02d',
                $calendarYear,
                $calendarMonth,
                $day
            );

            $isToday = ($dateString === $todayDate);
            ?>

            <a
                href="<?= base_url(
                    '/student/planner/add-event?date=' . $dateString
                ) ?>"
                class="calendar-day <?= $isToday ? 'today' : '' ?>"
            >
                <?= $day ?>
            </a>

        <?php endfor; ?>

    </div>

</section>


                <!-- DON'T FORGET -->

                <section class="dont-forget-section">

                    <h2>
                        ⚠️ DON'T FORGET
                    </h2>


                    <?php if (empty($reminders)): ?>

                        <p>
                            Henüz önemli bir not yok.
                        </p>

                    <?php else: ?>


                        <?php foreach (
                            $reminders
                            as $reminder
                        ): ?>

                            <div>

                                <?php if (
                                    $reminder['is_completed']
                                ): ?>

                                    <s>
                                        <?= esc(
                                            $reminder['title']
                                        ) ?>
                                    </s>

                                <?php else: ?>

                                    <?= esc(
                                        $reminder['title']
                                    ) ?>

                                <?php endif; ?>


                                <a
                                    href="<?= base_url(
                                        '/student/planner/toggle-reminder/'
                                        . $reminder['id']
                                    ) ?>"
                                >
                                    ✔
                                </a>


                                <a
                                    href="<?= base_url(
                                        '/student/planner/delete-reminder/'
                                        . $reminder['id']
                                    ) ?>"
                                >
                                    🗑
                                </a>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>


                   <button
    type="button"
    id="showReminderForm"
>
    ➕ Önemli Ekle
</button>

<form
    id="reminderForm"
    action="<?= base_url('/student/planner/add-reminder') ?>"
    method="post"
    style="display: none; margin-top: 15px;"
>

    <input
        type="text"
        name="title"
        placeholder="Önemli bir şey yaz..."
        required
    >

    <button type="submit">
        Ekle
    </button>

</form>
                    

                </section>
<section class="upcoming-section">

    <h2>🟢 YAKINDA</h2>

    <?php if (empty($upcomingEvents)): ?>

        <p>Yaklaşan görev yok.</p>

    <?php else: ?>

        <?php foreach ($upcomingEvents as $event): ?>

            <div class="upcoming-event">

                <strong>
                    <?= esc($event['title']) ?>
                </strong>

                <p>
                    📅
                    <?= esc(
                        date(
                            'd.m.Y',
                            strtotime($event['event_date'])
                        )
                    ) ?>
                </p>

                <?php if (!empty($event['start_time'])): ?>

                    <p>
                        🕐
                        <?= esc(
                            substr($event['start_time'], 0, 5)
                        ) ?>

                        <?php if (!empty($event['end_time'])): ?>

                            -
                            <?= esc(
                                substr($event['end_time'], 0, 5)
                            ) ?>

                        <?php endif; ?>
                    </p>

                <?php endif; ?>

                <a
                    href="<?= base_url(
                        '/student/planner/toggle-event/' .
                        $event['id']
                    ) ?>"
                >
                    ✔ Tamamlandı
                </a>

                |

                <a
                    href="<?= base_url(
                        '/student/planner/delete-event/' .
                        $event['id']
                    ) ?>"
                >
                    🗑 Sil
                </a>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</section>

            </aside>


        </div>

    </main>
<script>
(function () {

    const sakuraDecoration =
        document.getElementById('plannerSakuraDecoration');

    const darkAtmosphere =
        document.getElementById('plannerDarkAtmosphere');

    const oceanDecoration =
        document.getElementById('plannerOceanDecoration');

    const scrollDecoration =
        document.getElementById('plannerScrollDecoration');


    function updatePlannerTheme(theme) {

        /* ========================================
           🌸 SAKURA
        ======================================== */

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

                sakuraDecoration.style.display = 'block';
            }


            if (darkAtmosphere) {
                darkAtmosphere.innerHTML = '';
                darkAtmosphere.style.display = 'none';
            }


            if (oceanDecoration) {
                oceanDecoration.innerHTML = '';
                oceanDecoration.style.display = 'none';
            }


            if (scrollDecoration) {
                scrollDecoration.innerHTML = '';
            }
        }


        /* ========================================
           🪦 DARK
        ======================================== */

        else if (theme === 'dark') {

            if (sakuraDecoration) {
                sakuraDecoration.innerHTML = '';
                sakuraDecoration.style.display = 'none';
            }


            if (darkAtmosphere) {

                darkAtmosphere.innerHTML = `
                    <span class="planner-bat planner-bat-1">🦇</span>
                    <span class="planner-bat planner-bat-2">🦇</span>
                    <span class="planner-bat planner-bat-3">🦇</span>
                    <span class="planner-bat planner-bat-4">🦇</span>
                `;

                darkAtmosphere.style.display = 'block';
            }


            if (oceanDecoration) {
                oceanDecoration.innerHTML = '';
                oceanDecoration.style.display = 'none';
            }


            if (scrollDecoration) {

                scrollDecoration.innerHTML = `
                    <div class="planner-tombstone planner-tombstone-1">
                        <span>RIP</span>
                    </div>

                    <div class="planner-tombstone planner-tombstone-2">
                        <span>RIP</span>
                    </div>

                    <div class="planner-tombstone planner-tombstone-3">
                        <span>RIP</span>
                    </div>
                `;
            }
        }


        /* ========================================
           🌊 OCEAN
        ======================================== */

        else {

            if (sakuraDecoration) {
                sakuraDecoration.innerHTML = '';
                sakuraDecoration.style.display = 'none';
            }


            if (darkAtmosphere) {
                darkAtmosphere.innerHTML = '';
                darkAtmosphere.style.display = 'none';
            }


            if (scrollDecoration) {
                scrollDecoration.innerHTML = '';
            }


            if (oceanDecoration) {

                oceanDecoration.innerHTML = `
                    <span class="planner-ocean-wave planner-ocean-wave-1"></span>
                    <span class="planner-ocean-wave planner-ocean-wave-2"></span>
                    <span class="planner-ocean-wave planner-ocean-wave-3"></span>

                    <span class="planner-ocean-bubble planner-bubble-1"></span>
                    <span class="planner-ocean-bubble planner-bubble-2"></span>
                    <span class="planner-ocean-bubble planner-bubble-3"></span>
                    <span class="planner-ocean-bubble planner-bubble-4"></span>
                    <span class="planner-ocean-bubble planner-bubble-5"></span>
                    <span class="planner-ocean-bubble planner-bubble-6"></span>
                `;

                oceanDecoration.style.display = 'block';
            }
        }
    }


    /* Sidebar'dan tema değişince */
    window.addEventListener('themeChanged', function (event) {
        updatePlannerTheme(event.detail.theme);
    });


    /* Sayfa ilk açıldığında kayıtlı temayı al */
    const currentTheme =
        localStorage.getItem('studentTheme') ||
        document.body.getAttribute('data-theme') ||
        'sakura';

    updatePlannerTheme(currentTheme);

})();
</script>

<script>
    const showReminderForm = document.getElementById('showReminderForm');
    const reminderForm = document.getElementById('reminderForm');

    showReminderForm.addEventListener('click', function () {

        if (reminderForm.style.display === 'none') {
            reminderForm.style.display = 'block';
            showReminderForm.textContent = '✖ Kapat';
        } else {
            reminderForm.style.display = 'none';
            showReminderForm.textContent = '➕ Önemli Ekle';
        }

    });
</script>
</body>

</html>