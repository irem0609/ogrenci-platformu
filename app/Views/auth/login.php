<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign In - Student Platform</title>

    <link rel="stylesheet" href="<?= base_url('css/auth.css') ?>">
</head>

<body>

<div class="auth-container">

    <div class="auth-card">

        <div class="logo">
            Student Platform
        </div>

        <div class="subtitle">
            Welcome back
        </div>


        <!-- ROLE SELECTOR -->

        <div class="role-selector">

            <button
                type="button"
                class="role-button"
                onclick="toggleRoles()"
            >
                <span id="selected-role">
                    Choose your role
                </span>

                <span>
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


        <!-- LOGIN FORM -->

        <form
            id="login-form"
            action="<?= base_url('/login') ?>"
            method="post"
            style="display: none;"
        >

            <!-- ROLE -->

            <input
                type="hidden"
                id="role"
                name="role"
                value=""
            >


            <!-- EMAIL -->

            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
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

            </div>


            <button
                type="submit"
                class="auth-button"
            >
                Sign In
            </button>

        </form>


        <!-- ERROR -->

        <?php if (isset($error)): ?>

            <div class="error-message">
                <?= esc($error) ?>
            </div>

        <?php endif; ?>


        <!-- VALIDATION ERRORS -->

        <?php if (isset($validation)): ?>

            <div class="error-message">

                <?= $validation->listErrors() ?>

            </div>

        <?php endif; ?>


        <div class="auth-link">

            Don't have an account?

            <a href="<?= base_url('/register') ?>">
                Sign up
            </a>

        </div>

    </div>

</div>


<script>

function toggleRoles()
{
    const options = document.getElementById('role-options');

    if (options.style.display === 'none') {

        options.style.display = 'block';

    } else {

        options.style.display = 'none';

    }
}


function selectRole(role)
{
    const roleInput = document.getElementById('role');

    const selectedRole = document.getElementById('selected-role');

    const loginForm = document.getElementById('login-form');

    const options = document.getElementById('role-options');


    roleInput.value = role;


    if (role === 'student') {

        selectedRole.textContent = 'Student';

    } else if (role === 'teacher') {

        selectedRole.textContent = 'Teacher';

    }


    options.style.display = 'none';

    loginForm.style.display = 'block';
}

</script>

</body>
</html>