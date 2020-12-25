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
            <div class="center">
                <div class="col-lg-4">
                    <div class="card" style="width: 100%; color: black">
                        <ul class="list-group list-group-flush">
                        <form method="POST" action="/callmechanic/{{$id}}" enctype="multipart/form-data">
                            @csrf
                            <li class="list-group-item" style="font-weight: bolder">Panggil Mekanik</li>
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
                                <label for="problem">Masalah</label>
                                <textarea class="form-control" type="text" name="problem" spellcheck="false"></textarea>    
                            </li>                        </li>
                            <li class="list-group-item">
                                <label for="phone">Handphone</label>
                                <input class="form-control" type="text" name="phone"/>
                            </li>
                            <li class="list-group-item">
                                <label for="location">Lokasi</label>
                                <textarea class="form-control" type="text" name="location" spellcheck="false"></textarea>    
                            </li>
                            <li class="list-group-item" style="height: 175px">

                                  <input class="fileinput" name="problem_pic1" type="file"/>

                                  <input class="fileinput" name="problem_pic2" type="file"/>

                                  <input class="fileinput" name="problem_pic3" type="file"/>
    
                                  <input class="fileinput" name="problem_pic4" type="file"/>
                            </li>        
                            <li class="list-group-item text-center">
                                <button class="btn btn-primary" type="submit">Panggil</button>
                            </li>
                            <li class="list-group-item text-center">
                                Tidak memiliki akun? <a href="/daftar" class="link">Daftar</a>.<br>
                                Atau, <a href="/daftar_mekanik" class="link">Daftar sebagai mekanik</a>.<br>
                                Sudah menjadi mekanik? <a href="/masuk_mekanik" class="link">Masuk sebagai mekanik</a>.
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