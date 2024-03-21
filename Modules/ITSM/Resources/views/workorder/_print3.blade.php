<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Maintenance Work Order Report</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            line-height: 1.6;
            color: #333;
        }

        h2, h3 {
            color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #f5f5f5;
        }

        .section {
            margin-bottom: 20px;
        }

        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .signature p {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">IT Maintenance Work Order Report</h2>

<!-- Work Order Information Table -->
<table>
    <tr>
        <th>Work Order ID</th>
        <td>#{{ $workorder->workorder_number }}</td>
    </tr>
    <tr>
        <th>Requester Name</th>
        <td>{{ $workorder->user ?? '-'}}</td>
    </tr>
    <tr>
        <th>Requester Unit</th>
        <td>{{ $workorder->location ?? '-'}}</td>
    </tr>
    <tr>
        <th>Issue Type</th>
        @php $jumlah = count($reporteds->category) @endphp

        @if ($jumlah > 1)
            <td>
                @for ($x = 0; $x < $jumlah; $x++)
                {{ $x+1 .'. '. $reporteds->category[$x] ?? 'Nama Pemberi Tugas'}}<br>
                @endfor
            </td>
        @else
        <td>
            @for ($x = 0; $x < $jumlah; $x++)
            {{ $reporteds->category[$x] ?? 'Nama Pemberi Tugas'}}
            @endfor
        </td>
        @endif
    </tr>
    <tr>
        <th>Issue Description</th>
        <td>{{ $workorder->subject ?? 'Nama Pemberi Tugas'}}</td>
    </tr>
</table>

<!-- Maintenance Details Table -->
<table>
    <tr>
        <th>Technician Name</th>
        @php $jumlah = count($workorder->staff) @endphp

        @if ($jumlah > 1)
            <td>
                @for ($x = 0; $x < $jumlah; $x++)
                {{ $x+1 .'. '. $workorder->staff[$x] ?? 'Nama Pemberi Tugas'}}<br>
                @endfor
            </td>
        @else
        <td>
            @for ($x = 0; $x < $jumlah; $x++)
            {{ $workorder->staff[$x] ?? 'Nama Pemberi Tugas'}}
            @endfor
        </td>
        @endif

    </tr>
    <tr>
        <th>Start Time</th>
        <td>{{ $workorder->start_time ?? '-'}}</td>
    </tr>
    <tr>
        <th>End Time</th>
        <td>{{ $workorder->end_time ?? '-'}}</td>
    </tr>
    <tr>
        <th>Resolution</th>
        <td>
            {!! optional($workorder->respons->first())->publish == 1 ? optional($workorder->respons->first())->description : '-' !!}

        </td>
    </tr>
</table>

<!-- Additional Information Section -->
<div class="section">
    <h3>Additional Information</h3>
    <p><strong>Notes:</strong> The user was informed about best practices for handling electronic devices.</p>
    <p><strong>Attachments:</strong> <!-- List of attachments or links to attachments --></p>
</div>

<!-- Signatures Section -->
<div class="section signature">
    <div>
        <h3>Requester's Signature</h3>
        <p>______________________</p>
    </div>
    <div>
        <h3>Technician's Signature</h3>
        <p>{!! QrCode::generate('Make me into a QrCode!'); !!}</p>
        <p>______________________</p>
    </div>
</div>

<!-- Include any necessary scripts here -->

</body>
</html>
