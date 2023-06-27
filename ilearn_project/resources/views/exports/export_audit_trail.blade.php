<table>
    <thead>
    <tr>
                <th>Department</th>
                <th>User</th>
                <th>Document Title</th>
                
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                
    </tr>
    </thead>
    <tbody>
    @foreach($apps as $d)
        <tr>
                <td>{{ $d->Department}}</td>
                <td>{{ $d->Fullname }}</td>
                <td>{{ $d->title }}</td>
                <td>{{ Date("Y-m-d", strtotime($d->created_at)) }}</td>
                <td>{{ Date("H:i a" , strtotime($d->start_time)) }}</td>
                <td>{{ Date("H:i a" ,  strtotime($d->end_time)) }}</td>

        </tr>
    @endforeach
    </tbody>
</table>
