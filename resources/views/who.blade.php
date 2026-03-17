<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Life Expectancy - {{ strtoupper($country) }}</title>
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
                    Life Expectancy — {{ strtoupper($country) }}
                </h1>
            </div>
            <div class="flex gap-2">
                <a href="/history"
                class="text-sm text-zinc-500 border border-zinc-200 rounded-lg px-3 py-1.5 hover:bg-zinc-100 hover:text-zinc-800 transition">
                History →
            </a>
            <a href="/compare"
                class="text-sm text-zinc-500 border border-zinc-200 rounded-lg px-3 py-1.5 hover:bg-zinc-100 hover:text-zinc-800 transition">
                Compare →
            </a>


            </div>
            
        </div>

        {{-- CARD --}}
        <div class="bg-white border border-zinc-200 rounded-2xl p-8 shadow-sm">

            {{-- LOADING --}}
            <div id="loading" class="hidden py-16 text-center text-zinc-400 text-sm">
                Loading data...
            </div>

            {{-- CONTROLS --}}
            <form action="/who/save" method="POST" class="flex gap-2 mb-6">
                @csrf
                <input type="hidden" name="country_code" value="{{ strtoupper($country) }}">
                <select
                    class="flex-1 text-sm border border-zinc-200 rounded-lg px-3 py-2 bg-zinc-50 text-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-300"
                    onchange="showLoading(); window.location.href='/who/' + this.value">
                    @foreach ($countries as $c)
                        <option value="{{ $c['Code'] }}"
                            {{ strtoupper($country) === $c['Code'] ? 'selected' : '' }}>
                            {{ $c['Title'] }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="text-sm bg-zinc-900 text-white px-4 py-2 rounded-lg hover:bg-zinc-700 transition whitespace-nowrap">
                    Save
                </button>
            </form>

            {{-- SUCCESS --}}
            @if(session('success'))
                <div class="text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg px-4 py-2 mb-6">
                    ✓ Search saved successfully.
                </div>
            @endif

            {{-- CHART META --}}
            <p class="text-xs text-zinc-300 text-right mb-2 tracking-wide">2000 – 2021 · Years</p>

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
        function showLoading() {
            document.getElementById('loading').classList.remove('hidden');
            document.getElementById('chart-container').style.display = 'none';
        }

        const ctx = document.getElementById('chart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($data['labels']),
                datasets: [{
                    label: 'Life Expectancy (years)',
                    data: @json($data['values']),
                    borderColor: '#18181b',
                    backgroundColor: 'rgba(24,24,27,0.05)',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#18181b',
                    tension: 0.3,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => `${ctx.parsed.y.toFixed(1)} years`
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