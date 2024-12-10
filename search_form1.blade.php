<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جستجو در تجهیزات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>جستجو در تجهیزات</h2>

        <!-- فرم جستجو -->
        <form action="{{ url('/search') }}" method="GET">
            @csrf
            <div class="mb-3">
                <label for="date" class="form-label">تاریخ</label>
                <input type="date" class="form-control" id="date" name="date">
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">نوع</label>
                <input type="text" class="form-control" id="type" name="status">
            </div>

            <div class="mb-3">
                <label for="equipment_name" class="form-label">نام وسیله</label>
                <input type="text" class="form-control" id="equipment_name" name="equipment_name">
            </div>

            <div class="mb-3">
                <label for="device_model" class="form-label">مدل دستگاه</label>
                <input type="text" class="form-control" id="device_model" name="device_model">
            </div>

            <div class="mb-3">
                <label for="brand_id" class="form-label">برند</label>
                <input type="text" class="form-control" id="brand_id" name="brand_id">
            </div>

            <div class="mb-3">
                <label for="medical_specialties_id" class="form-label">تخصص پزشکی</label>
                <input type="text" class="form-control" id="medical_specialties_id" name="medical_specialties_id">
            </div>

            <div class="mb-3">
                <label for="country_id" class="form-label">کشور</label>
                <input type="text" class="form-control" id="country_id" name="country_id">
            </div>

            <div class="mb-3">
                <label for="supplier_company_id" class="form-label">شرکت تامین‌کننده</label>
                <input type="text" class="form-control" id="supplier_company_id" name="supplier_company_id">
            </div>

            <div class="mb-3">
                <label for="supplier_status_is" class="form-label">وضعیت تامین‌کننده</label>
                <input type="text" class="form-control" id="supplier_status_is" name="supplier_status_is">
            </div>

            <div class="mb-3">
                <label for="history_working" class="form-label">سابقه کاری</label>
                <input type="text" class="form-control" id="history_working" name="history_working">
            </div>

            <div class="mb-3">
                <label for="query_price" class="form-label">قیمت استعلامی</label>
                <input type="number" class="form-control" id="query_price" name="query_price">
            </div>

            <div class="mb-3">
                <label for="query_date" class="form-label">تاریخ استعلام</label>
                <input type="date" class="form-control" id="query_date" name="query_date">
            </div>

            <div class="mb-3">
                <label for="purchase_price" class="form-label">قیمت خرید</label>
                <input type="number" class="form-control" id="purchase_price" name="purchase_price">
            </div>

            <div class="mb-3">
                <label for="purchase_date" class="form-label">تاریخ خرید</label>
                <input type="date" class="form-control" id="purchase_date" name="purchase_date">
            </div>

            <div class="mb-3">
                <label for="certificate_date" class="form-label">تاریخ اعتبار گواهی</label>
                <input type="date" class="form-control" id="certificate_date" name="certificate_date">
            </div>

            <div class="mb-3">
                <label for="salesman_agent" class="form-label">نماینده فروش</label>
                <input type="text" class="form-control" id="salesman_agent" name="salesman_agent">
            </div>

            <div class="mb-3">
                <label for="salesman_phone" class="form-label">تلفن همراه</label>
                <input type="text" class="form-control" id="salesman_phone" name="salesman_phone">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">توضیحات</label>
                <input type="text" class="form-control" id="description" name="description">
            </div>

            <button type="submit" class="btn btn-primary">جستجو</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
