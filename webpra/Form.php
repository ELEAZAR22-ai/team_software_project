<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup Form</title>
</head>

<body>
  <h1>Login With your Credentials</h1>
  <?php echo "hello world"; ?>

  <form action="/webpra/Handler.inc.php" method="post">
    <input type="text" name="username" placeholder="username" required><br>
    <div style="position: relative; display: inline-block;">
      <input id="pwd" type="password" name="pwd" placeholder="password" required style="padding-right: 2.2rem;">
      <button id="togglePwd" type="button" aria-label="Toggle password visibility" style="position: absolute; right: 0.25rem; top: 50%; transform: translateY(-50%); border: none; background: transparent; cursor: pointer;">
        <span id="eyeIcon">👁️</span>
      </button>
    </div>
    <br>
    <input type="email" name="email" placeholder="Email" required><br>
    <button type="submit">Signup</button>
  </form>
  <script>
    const pwdInput = document.getElementById('pwd');
    const toggleBtn = document.getElementById('togglePwd');
    const eyeIcon = document.getElementById('eyeIcon');

    toggleBtn.addEventListener('click', function () {
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