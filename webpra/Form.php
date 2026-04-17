<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup - Review System</title>
  <link rel="stylesheet" href="fam.css">
</head>

<body>

  <header class="main-header">
    <div class="logo">
      <img src="log.png" alt="Logo" class="logo-image">
      <span></span>
    </div>
    <h1></h1>
  </header>

  <div class="container">
    <div class="login-card">
      <h2>Create Account</h2>
      <p class="subtitle">Login with your credentials</p>

      <form action="Handler.inc.php" method="post" id="signupForm">

        <div class="input-group">
          <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-group password-wrapper">
          <input id="pwd" type="password" name="pwd" placeholder="Password" required>
          <button id="togglePwd" type="button" class="toggle-btn">
            <span id="eyeIcon">👁️</span>
          </button>
        </div>

        <div class="input-group">
          <input type="email" name="email" placeholder="Email Address" required>
        </div>

        <div class="button-group">
          <button type="submit" class="btn-submit" onclick="return confirm('Are you sure you want to send?')">Signup</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const pwdInput = document.getElementById('pwd');
    const toggleBtn = document.getElementById('togglePwd');
    const eyeIcon = document.getElementById('eyeIcon');

    toggleBtn.addEventListener('click', function() {
      if (pwdInput.type === 'password') {
        pwdInput.type = 'text';
        eyeIcon.textContent = '🙈';
      } else {
        pwdInput.type = 'password';
        eyeIcon.textContent = '👁️';
      }
    });
  </script>
</body>

</html>