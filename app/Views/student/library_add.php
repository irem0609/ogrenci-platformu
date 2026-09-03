<!DOCTYPE html>
<html lang="tr">

<head>

    <meta charset="UTF-8">

    <title>Kitap Ekle</title>

    <link
        rel="stylesheet"
        href="<?= base_url('student.css') ?>"
    >

</head>

<body>

    <?= view('layouts/student_sidebar') ?>

    <main class="main-content">

        <h1>➕ Kitap Ekle</h1>

        <form
            action="<?= base_url('/student/library/add') ?>"
            method="post"
        >

            <div>

                <label for="title">
                    Kitap Adı
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    required
                >

            </div>

            <br>

            <div>

                <label for="author">
                    Yazar
                </label>

                <input
                    type="text"
                    id="author"
                    name="author"
                    required
                >

            </div>

            <br>

            <div>

                <label for="total_pages">
                    Sayfa Sayısı
                </label>

                <input
                    type="number"
                    id="total_pages"
                    name="total_pages"
                    min="1"
                    required
                >

            </div>

            <br>

            <button type="submit">
                📚 Kitabı Ekle
            </button>

        </form>

        <br>

        <a href="<?= base_url('/student/library') ?>">
            ← Kitaplığıma Dön
        </a>

    </main>

</body>

</html>