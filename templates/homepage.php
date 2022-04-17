<?php /* @var array $params */ ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/48002bbb07.js" crossorigin="anonymous"></script>
    <title>Form Sender</title>
</head>
<body>
<form name="myForm" class="mx-auto mt-3 mb-3" style="width: 50%">
    <div class="mb-3">
        <label for="first_name" class="form-label">Имя</label>
        <div class="invalid-feedback">
            Вы ввели пустую строку
        </div>
        <input type="text" name="first_name" class="form-control" id="first_name">
        <div id="first_name_Help" class="form-text">Это поле не должно быть пустым</div>
    </div>
    <div class="mb-3">
        <label for="second_name" class="form-label">Фамилия</label>
        <div class="invalid-feedback">
            Вы ввели пустую строку
        </div>
        <input type="text" name="second_name" class="form-control" id="second_name">
        <div id="second_name_Help" class="form-text">Это поле не должно быть пустым</div>
    </div>
    <div class="mb-3">
        <label for="last_name" class="form-label">Отчество</label>
        <input type="text" name="last_name" class="form-control" id="last_name">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Почта</label>
        <div class="invalid-feedback">
            Неверный формат
        </div>
        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">Формат: адрес@сервис.домен.</div>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Телефон</label>
        <div class="invalid-feedback">
            Неверный формат
        </div>
        <input type="tel" name="phone" class="form-control" id="phone" aria-describedby="phoneHelp">
        <div id="phoneHelp" class="form-text">Формат: +7/8-XXX-XXX-XX-XX.</div>
    </div>
    <div class="mb-3">
        <label for="comm" class="form-label">Комментарий</label>
        <div class="invalid-feedback">
            Вы ввели пустую строку
        </div>
        <textarea name="comm" class="form-control" id="comm" aria-describedby="commHelp"></textarea>
        <div id="phoneHelp" class="form-text">Это поле не должно быть пустым</div>
    </div>

    <button id="sumbit_button" type="button" class="btn btn-primary mb-3">Отправить</button>
    <div class="invalid-feedback" id="dbcheck" id="existing_app">

    </div>
</form>
<script src="js/validate.js"></script>
</body>
</html>