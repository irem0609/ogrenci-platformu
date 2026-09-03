<!DOCTYPE html>
<html lang="tr">
<head>

    <meta charset="UTF-8">

    <title>Kitaplığım</title>

    <link rel="stylesheet" href="<?= base_url('student.css') ?>">

</head>

<body>

    <?= view('layouts/student_sidebar') ?>


    <main class="main-content">

        <h1>📚 Kitaplığım</h1>
        <a href="<?= base_url('/student/library/add') ?>">
    ➕ Kitap Ekle
</a>
<form method="get" action="<?= base_url('/student/library') ?>">

    <input
        type="text"
        name="search"
        placeholder="Kitap adı veya yazar ara..."
        value="<?= esc($search ?? '') ?>"
    >

    <button type="submit">
        🔍 Ara
    </button>

</form>
<div>

    <a href="<?= base_url('/student/library') ?>">
        Tümü
    </a>

    <a href="<?= base_url('/student/library?filter=reading') ?>">
        Okuyorum
    </a>

    <a href="<?= base_url('/student/library?filter=completed') ?>">
        Tamamlandı
    </a>

    <a href="<?= base_url('/student/library?filter=favorite') ?>">
        ❤️ Favoriler
    </a>

</div>

        <?php if (empty($books)): ?>

            <p>Henüz kitap eklemedin.</p>

        <?php else: ?>

            <?php foreach ($books as $book): ?>

                <div>

                    <h2><?= esc($book['title']) ?></h2>

                    <p>
                        Yazar:
                        <?= esc($book['author']) ?>
                    </p>

                    <p>
                        İlerleme:
                        <?= esc($book['current_page']) ?>
                        /
                        <?= esc($book['total_pages']) ?>
                        sayfa
                    </p>

                    <p>
                        Durum:
                        <?= esc($book['status']) ?>
                    </p>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </main>

</body>
</html>