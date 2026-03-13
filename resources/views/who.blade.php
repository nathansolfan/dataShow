<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Esperança de Vida - {{ strtoupper($country) }}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div style="width: 600px; margin: 0 auto">

    <h1> Life Expectancy(2000-2021) - {{strtoupper($country)}}</h1>


    <select style="width: 100px; padding: 6px"   onchange="window.location.href='/who/' + this.value">

        @foreach ($countries as $c )
        <option value="{{ $c['Code']}}" {{strtoupper($country) === $c['Code'] ? 'selected' : ''}} >
             {{$c['Title']}}
        </option>
            
        @endforeach
    </select>



        <canvas id="chart" ></canvas>

    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($data['labels']),
                datasets: [{
                    label: 'Life Expectancy',
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
        </div>

</body>
</html>