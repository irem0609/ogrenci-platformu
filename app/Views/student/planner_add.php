<!DOCTYPE html>
<html lang="tr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Görev Ekle</title>

    <link
        rel="stylesheet"
        href="<?= base_url('student.css') ?>"
    >

</head>

<body>

    <?= view('layouts/student_sidebar') ?>

    <main class="main-content">

        <h1>➕ Görev Ekle</h1>

        <form
            action="<?= base_url('/student/planner/add-event') ?>"
            method="post"
        >

            <!-- GÜN / TARİH -->

            <div>

                <label for="event_date">
                    Tarih
                </label>

                <input
                    type="date"
                    id="event_date"
                    name="event_date"
                    value="<?= esc($selectedDate ?? date('Y-m-d')) ?>"
                    required
                >

            </div>

            <br>


            <!-- GÖREV ADI -->

            <div>

                <label for="title">
                    Görev
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    placeholder="Örn: Matematik çalış"
                    required
                >

            </div>

            <br>


            <!-- BAŞLANGIÇ -->

            <div>

                <label for="start_time">
                    Başlangıç Saati
                </label>

                <input
                    type="time"
                    id="start_time"
                    name="start_time"
                >

            </div>

            <br>


            <!-- BİTİŞ -->

            <div>

                <label for="end_time">
                    Bitiş Saati
                </label>

                <input
                    type="time"
                    id="end_time"
                    name="end_time"
                >

            </div>

            <br>


            <!-- AÇIKLAMA -->

            <div>

                <label for="description">
                    Açıklama
                </label>

                <br>

                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    placeholder="Görev hakkında not..."
                ></textarea>

            </div>

            <br>


            <!-- HATIRLATICI -->

            <div>

                <label for="reminder_at">
                    🔔 Hatırlatıcı
                </label>

                <br>

                <input
                    type="datetime-local"
                    id="reminder_at"
                    name="reminder_at"
                >

            </div>

            <br>


            <button type="submit">
                📅 Görevi Kaydet
            </button>

        </form>

        <br>

        <a href="<?= base_url('/student/planner') ?>">
            ← Haftalık Programa Dön
        </a>

    </main>

</body>

</html>