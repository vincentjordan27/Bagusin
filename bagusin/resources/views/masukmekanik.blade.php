<!DOCTYPE html>
<html>
    <head>
        <title>BagusIn</title>
        <meta charset="utf-8">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
        <style>
            .jumbotron{
                background-image: url('images/mechanic.png');
                background-repeat: no-repeat;
                background-size: cover;
                height: 70vh;
                margin-top: -20px;
            }
            body{
                font-family: 'Montserrat';
            }
        </style>
    </head>

    <!-- Navbar -->
    @include('includes.navbar')
    
    <body>
        <div class="jumbotron">
            <div class="center">
                    <div class="col-lg-4">
                        <div class="card" style="width: 100%; color: black">
                            <ul class="list-group list-group-flush">
                            <form method="POST" action="/masuk_mekanik">
                                @csrf
                                <li class="list-group-item" style="font-weight: bolder">Masuk Sebagai Mekanik</li>
                                <!-- Account's details -->
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (session('message'))
                                <div class="alert alert-danger">
                                    <ul>
                                        <li>{{ session('message') }}</li>
                                    </ul>
                                </div>
                                @endif
                                <li class="list-group-item">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="text" name="email"/>
                                </li>
                                <li class="list-group-item">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" name="password"/>
                                </li>
                                <li class="list-group-item text-center">
                                    <button class="btn btn-primary" type="submit">Masuk</button>
                                </li>
                                <li class="list-group-item text-center">
                                    Tidak memiliki akun? <a href="/daftar" class="link">Daftar</a>.<br>
                                    Atau, <a href="" class="link">Daftar sebagai mekanik</a>.
                                </li>
                            </form>
                            </ul>
                          </div>
                    </div>
            </div>
        </div>
    </body>
    <!-- Footer -->
    @include('includes.footer')

<html>