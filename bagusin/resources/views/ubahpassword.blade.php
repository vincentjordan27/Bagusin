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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <style>
            .jumbotron{
                display: block;
                overflow: auto;
                margin-top: -20px;
                min-height: 70vh;
            }
            body{
                font-family: 'Montserrat';
            }
            .btn.btn-primary.item{
                margin: 8px
            }
        </style>
    </head>

    <!-- Navbar -->
    @include('includes.navbar')
    
    <body>
        <div class="jumbotron">
            <div class="col-lg-5 text-center">
                <button class="btn btn-primary item" onclick="location.href='/akun'">Edit Profil</button><br>
                @if(Auth::guard('customer')->user())
                <button class="btn btn-primary item" onclick="location.href='/myorder'">Pesanan Saya</button><br>
                @else
                <button class="btn btn-primary item" onclick="location.href='/myorder'">Pesanan Masuk</button><br>
                @endif                <button class="btn btn-primary item" onclick="location.href='/riwayat'">Riwayat Pesanan</button><br>
                <button class="btn btn-primary item" disabled>Ubah Password</button>
            </div>

            <div class="col-lg-7" id="editpassword">
                <div class="card" style="width: 60%;">
                    <form method="POST" action="/ubahpassword">
                        @csrf
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" style="font-weight: bolder">Edit Akun</li>
                        <!-- Account's details -->
                        @if (session('message'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{{ session('message') }}</li>
                            </ul>
                        </div>
                        @endif
                        @if (session('error'))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{{ session('error') }}</li>
                            </ul>
                        </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                    <button class="btn btn-secondary" onclick="$('#editbutton').click();" class="link">Ulangi</button>
                                </ul>
                            </div>
                        @endif
                        <li class="list-group-item">
                            <span class="account-attribute" width="1000px">Password Lama</span>
                            <input class="form-control" name="password" type="password" value="">
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute" width="1000px">Password Baru</span>
                            <input class="form-control" name="newpassword" type="password" value="">
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute" width="1000px">Konfirmasi Password Baru</span>
                            <input class="form-control" name="confirmnewpassword" type="password" value="">
                        </li>
                        <li class="list-group-item">
                            <button class="btn btn-success" type="submit">Simpan</button>
                        </li>
                    </ul>
                    </form>
                  </div>
            </div>
        </div>
    </body>
    <!-- Footer -->
    @include('includes.footer')

<html>