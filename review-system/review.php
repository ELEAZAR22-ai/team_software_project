<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: /review-system/admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Review System</title>
    <link rel="stylesheet" href="review.css">
</head>

<body>

    <header class="main-header">
        <div class="logo">
            <img src="log.png" alt="Logo" class="logo-image">
            <span>Pentecost University</span>
        </div>
        <nav>
            <a href="ranking.php" class="nav-link">📊 View Rankings</a>
        </nav>
        <h1>Lecturer Review</h1>
        <button id="theme-toggle" class="mode-btn" onclick="toggleMode()">🌓 Switch Mode</button>
    </header>

    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="message success"><?php echo $_SESSION['success'];
                                            unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="message error"><?php echo $_SESSION['error'];
                                        unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <!-- The Minimalist Card -->
        <div class="record-card">
            <div class="card-header">
                <h2>Lecturer Record Entry</h2>
                <p>Enter details for the current semester</p>
            </div>

            <form action="adhandler.php" method="POST" id="lecturerForm">
                <input type="hidden" name="record" value="1">
                <div class="form-grid">
                    <!-- Lecturer Name -->
                    <div class="input-group">
                        <label>Lecturer Name</label>
                        <input type="text" name="lecturer_name" placeholder="e.g. Mr. Harry" required>
                    </div>

                    <!-- Faculty -->
                    <div class="input-group">
                        <label>Faculty</label>
                        <select name="faculty" required>
                            <option value="">Select Faculty</option>
                            <option value="FESAC">FESAC</option>
                            <option value="ABE">ABE</option>
                            <option value="LAW">LAW</option>
                            <option value="FBA">FBA</option>
                        </select>
                    </div>

                    <!-- Arrival Time -->
                    <div class="input-group">
                        <label>Arrival Time</label>
                        <input type="time" name="arrival_time" required>
                    </div>

                    <!-- Departure Time -->
                    <div class="input-group">
                        <label>Departure Time</label>
                        <input type="time" name="departure_time" required>
                    </div>

                    <!-- Number of Courses -->
                    <div class="input-group">
                        <label>Number of Courses</label>
                        <input type="number" name="num_courses" min="1" placeholder="0" required>
                    </div>

                    <!-- Courses Covered -->
                    <div class="input-group">
                        <label>Courses Covered (Sem)</label>
                        <input type="number" name="courses_covered" min="0" placeholder="0" required>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-submit" onclick="return confirm('Confirm data entry?')">Submit</button>
                    <button type="button" class="btn btn-cancel" onclick="window.history.back()">Cancel</button>
                    <button type="reset" class="btn btn-clear">Clear</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleMode() {
            document.body.classList.toggle('dark-mode');
        }
    </script>
</body>

</html>