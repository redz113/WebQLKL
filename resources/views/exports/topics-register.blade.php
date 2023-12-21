<table>
    <thead>
    <tr>
        <td colspan="6"><h1>Danh sách sinh viên đăng ký đề tài</h1></td>
    </tr>
    <tr>
        <th>STT</th>
        <th style="width: 50px;">Tên đề tài</th>
        <th style="width: 10px;">Bộ môn</th>
        <th style="width: 15px;">Mã sinh viên</th>
        <th style="width: 25px;">Họ tên sinh viên</th>
        <th style="width: 25px;">Giảng viên hướng dẫn</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($register_result as $key => $result)
        @php
            $beforeVal = "";
            $afterVal = "";

            if(isset($register_result[$key - 1])){
                $beforeVal = $register_result[$key - 1]->topic_name; 
            }

            if(isset($register_result[$key + 1])){
                $afterVal = $register_result[$key + 1]->topic_name; 
            }
        @endphp
        <tr>
            <td>{{ ++$i }}</td>
            @if ($beforeVal != $result->topic_name)
            <td class="w-auto" {{ ($afterVal == $result->topic_name)? 'rowspan=2': ''  }}>{{ $result->topic_name }}</td>  
            @endif
            <td>{{ $result->department }}</td>
            <td>{{ $result->student_id }}</td>
            <td>{{ $result->student_name }}</td>
            <td>{{ $result->instructor_name }}</td>
        </tr>
        @endforeach
    </tbody>