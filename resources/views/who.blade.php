<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Life Expectancy - {{ strtoupper($country) }}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div style="width: 600px; margin: 0 auto">
        <h1> Life Expectancy(2000-2021) - {{ strtoupper($country) }}</h1>




        {{-- LOADING --}}
        <div id="loading" style="display:none; text-align:center; padding: 20px;">
            <p>Loading...</p>
        </div>



        <select style="width: 150px; padding: 6px;" onchange="showLoading() ;window.location.href='/who/' + this.value">
            @foreach ($countries as $c)
                <option value="{{ $c['Code'] }}" {{ strtoupper($country) === $c['Code'] ? 'selected' : '' }}>
                    {{ $c['Title'] }}
                </option>
            @endforeach
        </select>



        <form action="/who/save" method="POST">
            @csrf
            <input type="hidden" name="country_code" value="{{ strtoupper($country) }}">
            <button type="submit">Save Search</button>
        </form>



        @if (session('success'))
            <p style="color: green">{{ session('success') }}</p>
        @endif


        <script>
            function showLoading() {
                document.getElementById('loading').style.display = 'block';
                const chart = document.getElementById('chart-container');
                if (chart) chart.style.display = 'none'
            }
        </script>


        <div id="chart-container">
            <canvas id="chart"></canvas>
        </div>

        

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
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });
        </script>
    </div>

</body>

</html>
