<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        .meta { color: #555; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 6px 8px; text-align: left; }
        th { background-color: #222; color: white; }
        .status-approved { color: green; font-weight: bold; }
        .status-rejected { color: red; font-weight: bold; }
        .status-pending { color: #b8860b; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Applicant Ranking Report</h1>
    <div class="meta">
        <strong>Scholarship:</strong> {{ $scholarship->title }}<br>
        <strong>Generated:</strong> {{ now()->format('d M Y, h:i A') }}<br>
        <strong>Total Applicants:</strong> {{ $applications->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Applicant Name</th>
                <th>Total Score</th>
                <th>Decision</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($applications as $application)
                <tr>
                    <td>{{ $application->rank ?? '—' }}</td>
                    <td>{{ $application->applicant->name }}</td>
                    <td>{{ $application->total_score ?? 'Not scored' }}</td>
                    <td class="status-{{ $application->status === 'approved' ? 'approved' : ($application->status === 'rejected' ? 'rejected' : 'pending') }}">
                        {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>