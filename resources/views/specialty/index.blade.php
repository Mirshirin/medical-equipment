@extends('layouts.app')

@section('content')

<div style="overflow-x: auto;">
    <h1 class="text-end mb-4">جدول اطلاعات</h1>
    <!-- <div style="overflow-x: auto;">
        <a href="{{ route('export-equipments') }}" class="btn btn-success mb-3">دانلود خروجی Excel</a>

       
    </div> -->
    <!-- صفحه‌بندی -->
    <div class="pagination">
        @if($page > 1)
            <a href="{{ url('equipments?page=' . ($page - 1)) }}" class="btn btn-primary">قبلی</a>
        @endif

        @if($page < $totalPages)
            <a href="{{ url('equipments?page=' . ($page + 1)) }}" class="btn btn-primary">بعدی</a>
        @endif
    </div>
    <!-- جدول اطلاعات -->
    <table class="table table-bordered table-striped text-end">
        <thead style="background-color: #6c757d; color: white;" class="text-end">
            <tr>   
                <!-- سایر ستون‌ها -->
                <th>شناسه</th>
                <th>وضعیت</th>
                <th>تاریخ انتشار</th>
                <th>نوع</th>

                 <!-- استخراج نام ستون‌ها از ACF -->
                 @php
                    $columnNames = [];
                @endphp

                @foreach($equipments as $data)
                    @if(!empty($data['acf']))
                        @foreach($data['acf'] as $key => $value)
                        @if(!in_array($key, $columnNames)) <!-- بررسی اینکه آیا این ستون قبلاً اضافه نشده است -->
                                <?php
                                    $columnNames[] = $key; 
                                ?>
                                <th>{{ $key }}</th>
                            @endif

                            @if(is_array($value)) <!-- برای فیلدهایی که آرایه هستند -->
                                @foreach($value as $subValue)
                                    @if(is_array($subValue)) <!-- اگر subValue خود آرایه است -->
                                        @foreach($subValue as $innerKey => $innerValue)
                                            @if(!in_array($innerKey, $columnNames))
                                                @php
                                                    $columnNames[] = $innerKey;
                                                @endphp
                                                <th>{{ $innerKey }}</th>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                @endforeach
                <th>لینک</th>

            </tr>

        </thead>
        <tbody>
            @foreach($equipments as $data)
                <tr>                    
                    <!-- سایر ستون‌ها -->
                    <td>{{ $data['id'] }}</td>
                    <td>{{ $data['status'] }}</td>
                    <td>{{ $data['date'] }}</td>
                    <td>{{ $data['type'] }}</td>

                    <!-- نمایش داده‌های ACF -->
                   @if(!empty($data['acf']))
                        @foreach($data['acf'] as $key => $value)
                            
                            @if(is_array($value))
                                @foreach($value as $subkey => $subValue )
                                    @if(is_array($subValue))
                                        @foreach($subValue as $innerKey => $innerValue)
                                            <!-- Display inner values -->
                                            @foreach($subValue as $innerKey => $innerValue)
                                            <!-- Display inner values -->
                                                <td>{{ $innerValue}}</td>
                                            @endforeach
                                         @endforeach
                                    @else
                                            <td>{{$subValue }}</td>
                                    @endif
                                @endforeach
                            @else
                                <td>{{ $value }}</td>
                            @endif
                        @endforeach
                    @endif
                    
                    <td><a href="{{ $data['link'] }}" target="_blank">{{ $data['link'] }}</a></td>
  
                </tr>
                
            @endforeach
            
        </tbody>
        
    </table>

    
</div>



@endsection
