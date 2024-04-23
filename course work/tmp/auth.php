<?php
    require "templates/header.php";
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Авторизация
                </div>
                <div class="card-body">
                    <form id="authForm" method="POST">
                        <div class="form-group">
                            <label for="email">Email адрес:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button type="submit" class="btn btn-primary">Войти</button>
                            <a href="./registration.php">Регистрация</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function() {
        $("#authForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "../controller/authController.php",
                data: {
                    'email': $('#email').val(),
                    'password': $('#password').val(),
                    'func': 'login',
                },
                success: function(response) {

                    console.log(response)
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
    require "templates/footer.php";
?>

<!--display: flex;-->
<!--justify-content: space-between;-->
<!--align-items: center;-->