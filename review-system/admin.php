<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Review System</title>
    <link rel="stylesheet" href="adminstyle.css">
</head>

<body>

    <header class="main-header">
        <div class="logo"> <img src="log.png" alt="Logo" class="logo-image">
            Pentecost University</div>
        <h1>Review System</h1>
        <button id="theme-toggle" class="mode-btn">🌓 Switch Mode</button>
    </header>

    <div class="container">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message"><?php echo $_SESSION['error'];
                                        unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message"><?php echo $_SESSION['success'];
                                            unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <div class="login-card">
            <h2>Stuffs Login</h2>
            <form action="/review-system/adhandler.php" method="POST" id="loginForm">
                <input type="hidden" name="login" value="1">
                <div class="input-group">
                    <input type="text" name="username" id="username" placeholder="Username" required>
                </div>

                <div class="input-group password-wrapper">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <button type="button" id="togglePassword" class="toggle-icon">👁️</button>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-submit">Submit</button>
                    <button type="reset" class="btn btn-clear">Clear</button>
                </div>
            </form>

            <div class="contact-info">
                <p>contact offcials: 0304575857/0304557576</p><br>
                <p>email: Admin@gmail.com</p>
            </div>
        </div>

        <div class="comment-section">
            <h3>Student Feedback</h3>
            <form action="/review-system/adhandler.php" method="POST">
                <textarea name="comments" placeholder="Students: Leave your comments here..."></textarea>
                <button type="submit" class="btn-submit">Post Comment</button>
            </form>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });

        // Theme Toggle
        const themeToggle = document.querySelector('#theme-toggle');
        themeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark');
            this.textContent = document.body.classList.contains('dark') ? '☀️ Light Mode' : '🌓 Switch Mode';
        });

        // Submit Confirmation Popup
        function handleSubmit() {
            const response = confirm("Do you want to submit?");
            if (response) {
                document.getElementById('loginForm').submit();
            } else {
                alert("Submission cancelled.");
            }
        }
    </script>
</body>

</html>