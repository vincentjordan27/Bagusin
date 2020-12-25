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
            <div class="col-lg-4" id="accountdetails">
                <div class="card" style="width: 80%;">
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item" style="font-weight: bolder">Pengguna</li>
                        
                        <li class="list-group-item" style="font-weight: bolder">{{$customers}}</li>

                        <li class="list-group-item" style="font-weight: bolder">
                            <button class="btn btn-primary" onclick="location.href='/admin/customers'">Lihat Semua</button>
                        </li>
                    </ul>
                  </div>
            </div>

            <div class="col-lg-4" id="accountdetails">
                <div class="card" style="width: 80%;">
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item" style="font-weight: bolder">Mekanik</li>

                        <li class="list-group-item" style="font-weight: bolder">{{$mechanics}}</li>
                        <li class="list-group-item" style="font-weight: bolder">
                            <button class="btn btn-primary" onclick="location.href='/admin/mechanics'">Lihat Semua</button>
                        </li>
                    </ul>
                  </div>
            </div>

            <div class="col-lg-4" id="accountdetails">
                <div class="card" style="width: 80%;">
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item" style="font-weight: bolder">Pesanan</li>

                        <li class="list-group-item" style="font-weight: bolder">{{$orders}}</li>

                        <li class="list-group-item" style="font-weight: bolder">
                            <button class="btn btn-primary" onclick="location.href='/admin/orders'">Lihat Semua</button>
                        </li>
                    </ul>
                  </div>
            </div>
        </div>
    </body>
    <!-- Footer -->
    @include('includes.footer')

<html>