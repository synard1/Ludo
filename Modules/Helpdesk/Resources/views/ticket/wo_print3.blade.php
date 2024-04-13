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

        h2,
        h3 {
            color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
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

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
        }

        .print-date {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">

        <h2 style="text-align: center;">IT Maintenance Work Order Report</h2>

        <!-- Work Order Information Table -->
        <table>
            <tr>
                <th>Work Order ID</th>
                <td>#WO-{{ $workorder->no }}</td>
            </tr>
            <tr>
                <th>Requester Name</th>
                <td>{{ $ticket->reporter_name ?? '-'}}</td>
            </tr>
            <tr>
                <th>Requester Unit</th>
                <td>{{ $ticket->origin_unit ?? 'Nama Pemberi Tugas'}}</td>
            </tr>
            <tr>
                <th>Issue Type</th>
                @if( !empty($data->category))
                    @php $jumlah = count($data->category) @endphp

                    @if ($jumlah > 1)
                    <td>
                        @for ($x = 0; $x < $jumlah; $x++) {{ $x+1 .'. '. $data->category[$x] ?? ' Nama Pemberi
                            Tugas'}}<br>
                            @endfor
                    </td>
                    @else
                    <td>
                        @for ($x = 0; $x < $jumlah; $x++) {{ $data->category[$x] ?? 'Nama Pemberi Tugas'}}
                            @endfor
                    </td>
                    @endif
                @endif

            </tr>
            <tr>
                <th>Issue Description</th>
                <td><b>{{ $ticket->subject ?? 'Nama Pemberi Tugas'}}</b> -- {{$workorder->subject }}<br>
                    {!! $workorder->description !!}
                </td>
            </tr>
        </table>

        <!-- Maintenance Details Table -->
        <table>
            <tr>
                <th>Technician Name</th>
                @php $jumlah = count($workorder->staff) @endphp

                @if ($jumlah > 1)
                <td>
                    @for ($x = 0; $x < $jumlah; $x++) {{ $x+1 .'. '. $workorder->staff[$x] ?? ' Nama Pemberi
                        Tugas'}}<br>
                        @endfor
                </td>
                @else
                <td>
                    @for ($x = 0; $x < $jumlah; $x++) {{ $workorder->staff[$x] ?? 'Nama Pemberi Tugas'}}
                        @endfor
                </td>
                @endif

            </tr>
            <tr>
                <th>Report Time</th>
                <td>{{ $ticket->report_time ?? '-'}}</td>
            </tr>
            <tr>
                <th>Resolution Time</th>
                <td>{{ $woResponse->end_time ?? '-'}}</td>
            </tr>
            <tr>
                <th>Resolution</th>
                <td>{!! $woResponse->response ?? '-' !!}</td>
            </tr>
        </table>

        <!-- Additional Information Section -->
        <div class="section">
            <h3>Additional Information</h3>
            <p><strong>Notes:</strong> {{ $woNotes->response ?? '-' }}</p>
            <p><strong>Attachments:</strong> <!-- List of attachments or links to attachments -->
            </p>
        </div>

        <!-- Signatures Section -->
        <div class="section signature">
            <div>
                <h3>Requester's Signature</h3>
                @if($workorder->status == 'Resolved')
                <p>{!! QrCode::generate('This document has been sign by : '. $workorder->origin_unit ); !!}</p>
                @endif
                <p>______________________</p>
            </div>
            <div>
                <h3>Technician's Signature</h3>
                @if($workorder->status == 'Resolved')
                @php
                    $text = 'This document has been sign by : '. $workorder->staff[0] . '\nOn : '. $workorder->end_time;
                    
                @endphp
                <p>{!! QrCode::generate($text); !!}</p>
                @endif
                <p>______________________</p>
            </div>
        </div>

        <!-- Include any necessary scripts here -->
        <!-- Print date at the bottom center -->
        <div class="print-date">
            Printed on:
            <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>
</body>

</html>