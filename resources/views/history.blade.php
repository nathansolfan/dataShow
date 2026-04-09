<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search History</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #f5f5f5;
            font-family: system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            padding: 48px 16px;
        }

        .card {
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            max-width: 680px;
            margin: 0 auto;
            padding: 40px;
        }

        .header {
            margin-bottom: 28px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 { font-size: 22px; font-weight: 600; color: #111; }

        .back-link {
            font-size: 13px;
            color: #666;
            text-decoration: none;
        }

        .back-link:hover { color: #111; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th {
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #999;
            padding: 8px 12px;
            border-bottom: 1px solid #f0f0f0;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #f7f7f7;
            color: #333;
        }

        tr:last-child td { border-bottom: none; }

        .country-link {
            color: #111;
            font-weight: 500;
            text-decoration: none;
        }

        .country-link:hover { text-decoration: underline; }

        .code-badge {
            font-size: 11px;
            background: #f5f5f5;
            border: 1px solid #e5e5e5;
            border-radius: 4px;
            padding: 2px 6px;
            color: #666;
        }

        .delete-btn {
            background: none;
            border: none;
            color: #ccc;
            cursor: pointer;
            font-size: 16px;
            transition: color 0.2s;
        }

        .delete-btn:hover { color: #e00; }

        .empty {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 14px;
        }

        .success {
            font-size: 13px;
            color: #2d7a4f;
            background: #f0faf4;
            border: 1px solid #c3e8d5;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="card">

        <div class="header">
            <h1>Search History</h1>
            <div >
                <a href="/export/{ $record->country_code}" class="back-link">Download</a>

                <a href="/who" class="back-link">Back to chart ← </a>

            </div>


        </div>



        @if(session('success'))
            <div class="success">✓ {{ session('success') }}</div>
        @endif

        @if($history->isEmpty())
            <div class="empty">No searches saved yet.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>Code</th>
                        <th>Saved at</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $record)
                        <tr>
                            <td>
                                <a href="/who/{{ $record->country_code }}" class="country-link">
                                    {{ $record->country_name }}
                                </a>
                            </td>
                            <td><span class="code-badge">{{ $record->country_code }}</span></td>
                            <td>{{ $record->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <form method="POST" action="/history/{{$record->id}}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete-btn" type="submit" title="Delete">✕</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
</body>
</html>
