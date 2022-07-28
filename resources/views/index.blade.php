<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Тестовое задание</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' />
    <link rel='stylesheet'
          href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">

</head>

<body class="bg-light">
<div class="container">
    <div class="row my-5">
        <div class="col-lg-4">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Форма добавления изображений</h5>

                </div>
                <form action="#" method="POST" id="add_employee_form" enctype="multipart/form-data" accept-charset="windows-1251">
                    @csrf
                    <div class="modal-body p-4 bg-light">
                        <div class="row before-content">
                            <div class="col-lg-12 mt-3">
                                <label for="fname">Название</label>
                                <input type="text" name="fname" id="fname" class="form-control mt-2" placeholder="Название" required>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <label for="avatar">Выбрать изображение</label>
                                <input type="file" name="avatar" class="form-control mt-2" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 mt-3">
                                <a class="btn btn-success add-input">Добавить еще <i class="bi-plus-circle me-2"></i></a>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="add_employee_btn" class="btn btn-primary">Добавить изображение</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-info d-flex justify-content-between align-items-center">
                    <h5 class="text-light">Список изображений</h5>
                </div>
                <div class="card-body" id="show_all_employees">
                    <h1 class="text-center text-secondary my-5">Загрузка...</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function() {

        $( ".add-input" ).click(function() {
            $('.before-content').after('' +
                '<div class="row"><div class="col-lg-12 mt-3">' +
                '<label for="fname">Название</label>' +
                '<input type="text" name="fname" id="fname" class="form-control mt-2" placeholder="Название" required>' +
                '' +
                '</div>' +
                '<div class="col-lg-12 mt-3">\n' +
                '                                <label for="avatar">Выбрать изображение</label>\n' +
                '                                <input type="file" name="avatar" class="form-control mt-2" required>\n' +
                '                            </div></div>');
        });

        // добавление изображения
        $("#add_employee_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#add_employee_btn").text('Добавление...');
            $.ajax({
                url: '{{ route('store') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        Swal.fire(
                            'Добавлено!',
                            'Изображение добавлено успешно!',
                            'Успешно'
                        )
                        fetchAllEmployees();
                    }
                    $("#add_employee_btn").text('Добавить изображение');
                    $("#add_employee_form")[0].reset();
                    $("#addEmployeeModal").modal('hide');
                }
            });
        });

        // Получение всех
        fetchAllEmployees();

        function fetchAllEmployees() {
            $.ajax({
                url: '{{ route('fetchAll') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_employees").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }
    });
</script>
</body>

</html>
