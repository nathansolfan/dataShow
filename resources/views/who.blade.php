<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Life Expectancy - {{ strtoupper($country) }}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen py-10">

    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg p-8">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            🌍 Life Expectancy — {{ strtoupper($country) }}
        </h1>

        {{-- LOADING --}}
        <div id="loading" class="hidden text-center py-6 text-gray-500">
            <p>Loading...</p>
        </div>

        {{-- SELECT --}}
        <select
            class="w-64 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-400 mb-4"
            onchange="showLoading(); window.location.href='/who/' + this.value">
            @foreach ($countries as $c)
                <option value="{{ $c['Code'] }}" {{ strtoupper($country) === $c['Code'] ? 'selected' : '' }}>
                    {{ $c['Title'] }}
                </option>
            @endforeach
        </select>

        {{-- SAVE FORM --}}
        <form action="/who/save" method="POST" class="mb-4">
            @csrf
            <input type="hidden" name="country_code" value="{{ strtoupper($country) }}">
            <button type="submit"
                class="bg-teal-500 hover:bg-teal-600 text-white font-semibold px-4 py-2 rounded-lg transition">
                Save Search
            </button>
        </form>

        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))
            <p class="text-green-600 font-medium mb-4">✅ {{ session('success') }}</p>
        @endif

        {{-- CHART --}}
        <div id="chart-container">
            <canvas id="chart"></canvas>
        </div>

    </div>

    <script>
        function showLoading() {
            document.getElementById('loading').classList.remove('hidden');
            const chart = document.getElementById('chart-container');
            if (chart) chart.style.display = 'none';
        }

        const ctx = document.getElementById('chart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($data['labels']),
                datasets: [{
                    label: 'Life Expectancy (years)',
                    data: @json($data['values']),
                    borderColor: 'rgba(20, 184, 166, 1)',
                    backgroundColor: 'rgba(20, 184, 166, 0.15)',
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