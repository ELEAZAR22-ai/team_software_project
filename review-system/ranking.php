<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Lecturer Ranking Dashboard</title>
    <link rel="stylesheet" href="ranking.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="dark-mode">
    <header class="main-header">
        <div class="logo">
            <img src="log.png" alt="Logo" class="logo-image">
            <span>Pentecost University</span>
        </div>
        <nav>
            <a href="review.php" class="nav-link">📋 Lecturer Review</a>
        </nav>
        <h1>Lecturer Ranking</h1>
        <button id="theme-toggle" class="mode-btn" onclick="toggleMode()">🌓 Switch Mode</button>
    </header>

    <div class="container ranking-view">
        <div class="search-card">
            <input type="text" id="lecturerSearch" placeholder="🔍 Search lecturer by name..." onkeyup="filterSearch()">
            <div id="searchResults" class="search-results-dropdown"></div>
        </div>
        <div class="chart-card">
            <h2>Semester Performance Ranking</h2>
            <canvas id="rankingChart" width="400" height="200"></canvas>
        </div>

        <div class="guide-card">
            <h3>Ranking Factors Guide</h3>
            <ul class="importance-list">
                <li class="high-priority"><span>1</span> Courses Covered Accuracy (High Impact)</li>
                <li class="medium-priority"><span>2</span> Punctuality (Arrival vs. Departure)</li>
                <li class="low-priority"><span>3</span> Faculty Engagement (Low Impact)</li>
            </ul>
        </div>
    </div>

    <script>
        const themeToggleButton = document.getElementById('theme-toggle');

        function updateThemeButton() {
            if (document.body.classList.contains('dark-mode')) {
                themeToggleButton.textContent = '☀️ Light Mode';
            } else {
                themeToggleButton.textContent = '🌓 Dark Mode';
            }
        }

        function toggleMode() {
            document.body.classList.toggle('dark-mode');
            updateThemeButton();
        }

        updateThemeButton();

        // Search Functionality
        async function filterSearch() {
            const query = document.getElementById('lecturerSearch').value;
            const resultsDiv = document.getElementById('searchResults');

            if (query.length < 2) {
                resultsDiv.innerHTML = "";
                return;
            }

            // We can use the same API or create a small search API
            const response = await fetch(`search.php?name=${query}`);
            const data = await response.json();

            resultsDiv.innerHTML = data.map(lecturer => `
        <div class="search-item">
            <strong>${lecturer.lecturer_name}</strong> - Score: ${Math.round(lecturer.performance_score)}%
        </div>
    `).join('');
        }
        async function loadRanking() {
            const response = await fetch('getranking.php');
            const data = await response.json();

            const names = data.map(item => item.lecturer_name);
            const scores = data.map(item => item.performance_score);

            const ctx = document.getElementById('rankingChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: names,
                    datasets: [{
                        label: 'Performance %',
                        data: scores,
                        backgroundColor: ['#003366', '#0055ff', '#ffcc00'], // Blue, Light Blue, Yellow
                        borderRadius: 5
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        }
        loadRanking();
    </script>
</body>

</html>