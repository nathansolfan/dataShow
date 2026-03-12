<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Esperança de Vida - {{ strtoupper($country) }}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    

    <h1>Esperança de Vida no Brasil (2000-2021)</h1>
    <canvas id="chart" width="700" height="200"></canvas>

    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($data['labels']),
                datasets: [{
                    label: 'Esperança de Vida (anos)',
                    data: @json($data['values']),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.3,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: false }
                }
            }
        });
    </script>
</body>
</html>