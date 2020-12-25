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
                <div class="text-center" style="color:white; font-size:25px">
                    Selesaikan masalah kendaraan anda dengan profesional terbaik
                    <div style="margin-top: 20px;">
                        <form class="form-inline my-2 my-lg-0" action="/search" method="GET">
                            <input class="form-control mr-sm-2" style="width: 40vw" type="search" name="query" placeholder="jasa apa yang anda butuhkan ?" aria-label="Search">
                            <button class="btn btn-primary my-2 my-sm-0" type="submit" style="margin-left: 15px"><span style="margin-inline: 20px; font-weight:bolder">Cari</span></button>
                          </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <!-- Footer -->
    @include('includes.footer')

<html>