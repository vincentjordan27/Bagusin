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
                height: auto;
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
                        <div class="card" style="width: 100%; color: black;">
                            <ul class="list-group list-group-flush">
                            <form id="customerregister" method="POST" action="/daftar">
                                @csrf
                                <li class="list-group-item" style="font-weight: bolder">Daftar</li>
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
                                <div class="alert alert-success">
                                    <ul>
                                        <li>{{ session('message') }} Silakan <a href="/masuk" class="link">masuk</a>.</li>
                                    </ul>
                                </div>
                                @endif
                                <li class="list-group-item">
                                    <label for="name">Nama</label>
                                    <input class="form-control" type="text" name="name"/>
                                </li>
                                <li class="list-group-item">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="text" name="email"/>
                                </li>
                                <li class="list-group-item">
                                    <label for="phone">Handphone</label>
                                    <input class="form-control" type="text" name="phone"/>
                                </li>
                                <li class="list-group-item">
                                    <label for="address">Alamat</label>
                                    <input class="form-control" type="text" name="address"/>
                                </li>
                                <li class="list-group-item">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" name="password"/>
                                </li>
                                <li class="list-group-item">
                                    <label for="confirm_password">Ulangi Password</label>
                                    <input class="form-control" type="password" name="confirm_password"/>
                                </li>
                                <li class="list-group-item text-center">
                                    <button class="btn btn-primary" type="submit">Masuk</button>
                                </li>
                                <li class="list-group-item text-center">
                                    Sudah memiliki akun? <a href="/masuk" class="link">Masuk</a>.<br>
                                    Atau, <a href="/daftar_mekanik" class="link">Daftar sebagai mekanik</a>.
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