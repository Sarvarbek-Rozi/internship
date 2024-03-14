<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap Simple Login Form</title>
    <link href="/css/style.css" rel="stylesheet">
    <style>
        .login-form {
            width: 340px;
            margin: 50px auto;
            font-size: 15px;
        }
        .login-form form {
            margin-bottom: 15px;
            background: #f7f7f7;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
        }
        .login-form h2 {
            margin: 0 0 15px;
        }
        .form-control, .btn {
            min-height: 38px;
            border-radius: 2px;
        }
        .btn {
            font-size: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <form action="{{route('authenticate')}}" method="post">
            @csrf
            <h2 class="text-center">Kirish</h2>
            <div class="form-group">
                <input name="email" type="email" class="form-control" placeholder="Email" required="required">
            </div>
            <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="Password" required="required">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Kirish</button>
            </div>
            <div class="clearfix">
                <label class="float-left form-check-label"><input type="checkbox">Meni eslab qol</label>
                <a href="#" class="float-right">Parolni unutdingizmi?</a>
            </div>
        </form>
        <p class="text-center"><a href="{{route('register')}}">Yangi hisob yarating</a></p>
    </div>
</body>
</html>
