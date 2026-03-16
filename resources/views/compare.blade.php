<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Compare — {{ $country1 }} vs {{ $country2 }}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-zinc-50 min-h-screen py-12 px-4">

    <div class="max-w-2xl mx-auto">

        {{-- HEADER --}}
        <div class="flex items-start justify-between mb-6">
            <div>
                <p class="text-xs uppercase tracking-widest text-zinc-400 mb-1">WHO Global Health Observatory</p>
                <h1 class="text-2xl font-semibold text-zinc-900">
                    Compare Countries
                </h1>
            </div>
            <a href="/who"
                class="text-sm text-zinc-500 border border-zinc-200 rounded-lg px-3 py-1.5 hover:bg-zinc-100 hover:text-zinc-800 transition">
                ← Back
            </a>
        </div>

        {{-- CARD --}}
        <div class="bg-white border border-zinc-200 rounded-2xl p-8 shadow-sm">

            {{-- CONTROLS --}}
            <form method="GET" action="/compare" class="flex flex-col gap-2 mb-8">
                <select name="country1"
                    class="flex-1 text-sm border border-zinc-200 rounded-lg px-3 py-2 bg-zinc-50 text-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-300">
                    @foreach ($countries as $c)
                        <option value="{{ $c['Code'] }}" {{ $country1 === $c['Code'] ? 'selected' : '' }}>
                            {{ $c['Title'] }}
                        </option>
                    @endforeach
                </select>

                <span class="text-zinc-400 self-center text-sm font-medium">vs</span>

                <select name="country2"
                    class="flex-1 text-sm border border-zinc-200 rounded-lg px-3 py-2 bg-zinc-50 text-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-300">
                    @foreach ($countries as $c)
                        <option value="{{ $c['Code'] }}" {{ $country2 === $c['Code'] ? 'selected' : '' }}>
                            {{ $c['Title'] }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                    class="text-sm bg-zinc-900 text-white px-4 py-2 rounded-lg hover:bg-zinc-700 transition whitespace-nowrap">
                    Compare
                </button>
            </form>

            {{-- LEGEND --}}
            <div class="flex gap-6 mb-4">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full inline-block" style="background:#18181b"></span>
                    <span class="text-sm text-zinc-600">{{ $country1 }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full inline-block" style="background:#3b82f6"></span>
                    <span class="text-sm text-zinc-600">{{ $country2 }}</span>
                </div>
            </div>

            {{-- CHART --}}
            <div id="chart-container">
                <canvas id="chart"></canvas>
            </div>

        </div>

        {{-- FOOTER --}}
        <p class="text-center text-xs text-zinc-300 mt-6">
            Data source: World Health Organization · Last updated 2024
        </p>

    </div>

    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($data1['labels']),
                datasets: [
                    {
                        label: '{{ $country1 }}',
                        data: @json($data1['values']),
                        borderColor: '#18181b',
                        backgroundColor: 'rgba(24,24,27,0.05)',
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: '#18181b',
                        tension: 0.3,
                        fill: false,
                    },
                    {
                        label: '{{ $country2 }}',
                        data: @json($data2['values']),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59,130,246,0.05)',
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: '#3b82f6',
                        tension: 0.3,
                        fill: false,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => `${ctx.dataset.label}: ${ctx.parsed.y.toFixed(1)} years`
                        }
                    }
                },
                scales: {
                    x: { grid: { color: '#f4f4f5' } },
                    y: {
                        beginAtZero: false,
                        grid: { color: '#f4f4f5' },
                        ticks: { callback: val => `${val} yrs` }
                    }
                }
            }
        });
    </script>

</body>
</html>