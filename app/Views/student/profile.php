<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil</title>

    <link rel="stylesheet" href="<?= base_url('student.css') ?>">
</head>

<body>

<?= view('layouts/student_sidebar') ?>

<main class="main-content">

    <!-- BAŞARI / HATA MESAJLARI -->

    <?php if (session()->getFlashdata('success')): ?>

        <div class="profile-message success">
            ✅ <?= esc(session()->getFlashdata('success')) ?>
        </div>

    <?php endif; ?>


    <?php if (session()->getFlashdata('error')): ?>

        <div class="profile-message error">
            ❌ <?= esc(session()->getFlashdata('error')) ?>
        </div>

    <?php endif; ?>


    <div class="profile-page">

        <!-- PROFİL ÜST KISMI -->

        <div class="profile-header">

            <div class="profile-avatar">
                👤
            </div>

            <h1>
                <?= esc($user['username']) ?>
            </h1>

            <p>Öğrenci</p>

        </div>


        <!-- KULLANICI BİLGİLERİ -->

        <div class="profile-info">

            <div class="profile-info-item">

                <span>👤</span>

                <div>

                    <small>Kullanıcı Adı</small>

                    <strong>
                        <?= esc($user['username']) ?>
                    </strong>

                </div>

            </div>


            <div class="profile-info-item">

                <span>📧</span>

                <div>

                    <small>E-posta</small>

                    <strong>
                        <?= esc($user['email']) ?>
                    </strong>

                </div>

            </div>


            <div class="profile-info-item">

                <span>🔒</span>

                <div>

                    <small>Şifre</small>

                    <strong>
                        ••••••••••
                    </strong>

                </div>

            </div>

        </div>


        <!-- PROFİL İŞLEMLERİ -->

        <div class="profile-actions">

            <button
                type="button"
                id="emailButton"
            >
                📧 E-posta Değiştir
            </button>


            <button
                type="button"
                id="passwordButton"
            >
                🔒 Şifre Değiştir
            </button>

        </div>


        <!-- E-POSTA DEĞİŞTİRME -->

        <div
            id="emailForm"
            style="display: none; margin-top: 20px;"
        >

            <h3>📧 E-posta Değiştir</h3>


            <form
                action="<?= base_url('/student/profile/update-email') ?>"
                method="post"
            >

                <div>

                    <label for="new_email">
                        Yeni E-posta
                    </label>

                    <br>

                    <input
                        type="email"
                        id="new_email"
                        name="new_email"
                        placeholder="Yeni e-posta adresiniz"
                        required
                    >

                </div>


                <br>


                <div>

                    <label for="current_password_email">
                        🔐 Mevcut Şifreniz
                    </label>

                    <br>

                    <input
                        type="password"
                        id="current_password_email"
                        name="current_password"
                        placeholder="Mevcut şifrenizi girin"
                        required
                    >

                </div>


                <br>


                <button type="submit">
                    ✓ Onayla ve Değiştir
                </button>

            </form>

        </div>


        <!-- ŞİFRE DEĞİŞTİRME -->

        <div
    id="passwordForm"
    style="display: none; margin-top: 20px;"
>

    <h3>🔒 Şifre Değiştir</h3>

    <form
        action="<?= base_url('/student/profile/update-password') ?>"
        method="post"
    >

        <div>

            <label for="current_password">
                🔐 Mevcut Şifreniz
            </label>

            <br>

            <input
                type="password"
                id="current_password"
                name="current_password"
                placeholder="Mevcut şifrenizi girin"
                required
            >

        </div>

        <br>

        <div>

            <label for="new_password">
                🔑 Yeni Şifre
            </label>

            <br>

            <input
                type="password"
                id="new_password"
                name="new_password"
                placeholder="Yeni şifrenizi girin"
                minlength="6"
                required
            >

        </div>

        <br>

        <div>

            <label for="new_password_again">
                🔑 Yeni Şifre Tekrar
            </label>

            <br>

            <input
                type="password"
                id="new_password_again"
                name="new_password_again"
                placeholder="Yeni şifrenizi tekrar girin"
                minlength="6"
                required
            >

        </div>

        <br>

        <button type="submit">
            ✓ Onayla ve Değiştir
        </button>

    </form>

</div>

    </div>

</main>


<script>

    const emailButton = document.getElementById('emailButton');
    const emailForm = document.getElementById('emailForm');

    const passwordButton = document.getElementById('passwordButton');
    const passwordForm = document.getElementById('passwordForm');


    // E-POSTA FORMUNU AÇ / KAPAT

    emailButton.addEventListener('click', function () {

        if (emailForm.style.display === 'none') {

            emailForm.style.display = 'block';

        } else {

            emailForm.style.display = 'none';

        }

    });


    // ŞİFRE FORMUNU AÇ / KAPAT

    passwordButton.addEventListener('click', function () {

        if (passwordForm.style.display === 'none') {

            passwordForm.style.display = 'block';

        } else {

            passwordForm.style.display = 'none';

        }

    });

</script>

</body>
</html>