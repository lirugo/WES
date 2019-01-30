<!DOCTYPE html>
<html>
<head>
    <title>Schedule</title>
</head>

<style>
    #schedule {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        border-collapse: collapse;
        width: 100%;
    }

    #schedule td, #schedule th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #schedule tr:nth-child(even){background-color: #f2f2f2;}

    #schedule tr:hover {background-color: #ddd;}

    #schedule th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #3f51b5;
        color: white;
    }
</style>
<body>
    <table id="schedule">
        <thead>
        <tr>
            <th>Name</th>
            <th>Start</th>
            <th>End</th>
        </tr>
        </thead>

        <tbody>
        @foreach($schedules as $sch)
            <tr>
                <td>{{$sch->title}}</td>
                <td>{{$sch->start_date}}</td>
                <td>{{$sch->end_date}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>