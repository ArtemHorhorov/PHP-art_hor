<?php
require_once 'templates/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Регистрация
                </div>
                <div class="card-body">
                    <form id="regForm" method="POST">
                        <div class="form-group">
                            <label for="username">Имя пользователя:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email адрес:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button id="reg" type="submit" class="btn btn-primary mt-3">Зарегистрироваться</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <script type="application/javascript">
        $(document).ready(function() {
            $("#regForm").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "../controller/registrationController.php",
                    data: $(this).serialize(),
                    success: function(response) {
                        const responseJsonDecode = JSON.parse(response);
                        if (responseJsonDecode.code === 200) {
                            window.location.href = 'http://tmp/index.php'
                        } else {
                            alert(responseJsonDecode.error)
                        }
                    }
                })
            })
        })
    </script>

<?php
    require_once 'templates/footer.php'
?>