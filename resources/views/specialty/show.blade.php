@extends('layouts.app')

@section('content')
<!-- resources/views/specialty/show.blade.php -->
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مشخصات تخصص</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <!-- راست‌چین کردن عنوان -->
        <h1 class="text-end mb-4">جدول اطلاعات</h1>

        <!-- جدول اطلاعات -->
        <table class="table table-bordered table-striped text-end">
            <thead class="table-dark text-end">
                <tr>
                <th>مقدار</th>    
                <th>ویژگی</th>
                   
                </tr>
            </thead>

            <tbody>
          
                <tr>
                    <td>{{ $data['name'] }}</td>    
                    <td>نام</td>
                    
                </tr>
                <tr>
                <td>{{ $data['description'] }}</td>    
                <td>توضیحات</td>
                    
                </tr>
                <tr>
                <td>{{ $data['count'] }}</td>    
                <td>تعداد پست‌های مرتبط</td>
                    
                </tr>
                <tr>
                <td>{{ $data['slug'] }}</td>    
                <td>Slug</td>
                   
                </tr>
                <tr>
                <td>{{ $data['taxonomy'] }}</td>    
                <td>Taxonomy</td>
                    
                </tr>
                <tr>
                    <td>{{ $data['parent'] }}</td>    
                    <td>والد</td>
                    
                </tr>

                <!-- نمایش داده‌های ACF (تصویر در این مورد) -->
                @if (isset($acfData['تصویر_تخصص']))
                <tr>
                    <td><img src="http://equipment.ir/wp-content/uploads/{{ $acfData['تصویر_تخصص'] }}.jpg" alt="تصویر تخصص" class="img-fluid" style="max-width: 200px;"></td>

                    <td>تصویر تخصص</td>
                </tr>
                @endif
                
                <tr>
                <td><a href="{{ $data['link'] }}" target="_blank">مشاهده بیشتر</a></td>    
                <td>لینک</td>
                   
                </tr>
             

            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


@endsection
