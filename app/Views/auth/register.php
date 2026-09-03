<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign Up - Student Platform</title>

    <link rel="stylesheet" href="<?= base_url('css/auth.css') ?>">
</head>

<body>

<div class="auth-container">

    <div class="auth-card">

        <div class="logo">
            Student Platform
        </div>

        <div class="subtitle">
            Create your account
        </div>


        <!-- SUCCESS MESSAGE -->
        <?php if (session()->getFlashdata('success')): ?>

            <div class="success-message">
                <?= session()->getFlashdata('success') ?>
            </div>

        <?php endif; ?>


        <!-- VALIDATION ERRORS -->
        <?php if (isset($validation)): ?>

            <div class="error-message">
                <?= $validation->listErrors() ?>
            </div>

        <?php endif; ?>


        <!-- ROLE SELECTION -->

        <div class="role-selector">

            <button
                type="button"
                class="role-button"
                onclick="toggleRoles()"
            >
                <span id="selected-role">
                    Choose your role
                </span>

                <span id="role-arrow">
                    ▼
                </span>
            </button>


           <div
    id="role-options"
    class="role-options"
    style="display: none;"
>

                <button
                    type="button"
                    onclick="selectRole('student')"
                >
                    Student
                </button>

                <button
                    type="button"
                    onclick="selectRole('teacher')"
                >
                    Teacher
                </button>

            </div>

        </div>


        <!-- REGISTER FORM -->

        <div
            id="register-form"
            class="register-form"
        >

            <form
                action="<?= base_url('/register') ?>"
                method="post"
            >

                <!-- ROLE -->

                <input
                    type="hidden"
                    id="role"
                    name="role"
                    value=""
                >


                <!-- USERNAME -->

                <div class="form-group">

                    <label for="username">
                        Username
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="<?= old('username') ?>"
                        required
                    >

                </div>


                <!-- EMAIL -->

                <div class="form-group">

                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= old('email') ?>"
                        required
                    >

                </div>


                <!-- PASSWORD -->

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                    >

                    <small>
                        En az 8 karakter, 1 büyük harf,
                        1 küçük harf ve 1 özel karakter içermelidir.
                    </small>

                </div>


                <!-- SUBMIT -->

                <button
                    type="submit"
                    class="auth-button"
                >
                    Sign Up
                </button>

            </form>

        </div>


        <!-- LOGIN LINK -->

        <div class="auth-link">

            Already have an account?

            <a href="<?= base_url('/login') ?>">
                Sign in
            </a>

        </div>

    </div>

</div>


<script>

function toggleRoles()
{
    const options = document.getElementById('role-options');
    const arrow = document.getElementById('role-arrow');

    if (options.style.display === 'block')
    {
        options.style.display = 'none';
        arrow.textContent = '▼';
    }
    else
    {
        options.style.display = 'block';
        arrow.textContent = '▲';
    }
}


function selectRole(role)
{
    const selectedRole = document.getElementById('selected-role');
    const options = document.getElementById('role-options');
    const arrow = document.getElementById('role-arrow');
    const form = document.getElementById('register-form');
    const roleInput = document.getElementById('role');


    if (role === 'student')
    {
        selectedRole.textContent = 'Student';
    }


    if (role === 'teacher')
    {
        selectedRole.textContent = 'Teacher';
    }


    // Seçilen rolü forma gönder
    roleInput.value = role;


    // Seçim kutusunu kapat
    options.style.display = 'none';
    arrow.textContent = '▼';


    // Formu göster
    form.style.display = 'block';
}

</script>

</body>

</html>