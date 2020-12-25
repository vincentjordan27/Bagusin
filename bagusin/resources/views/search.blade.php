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
            @if(count($mechanics) == 0)
            <div class="col-lg-12 text-center" style="font-size: 25px">
                Ups! bengkel tidak ditemukan.
                <div style="margin-top: 20px;">
                    <form class="form-inline my-2 my-lg-0" action="/search" method="GET">
                        <input class="form-control mr-sm-2" style="width: 40vw" type="search" name="query" placeholder="jasa apa yang anda butuhkan ?" aria-label="Search">
                        <button class="btn btn-primary my-2 my-sm-0" type="submit" style="margin-left: 15px"><span style="margin-inline: 20px; font-weight:bolder">Cari</span></button>
                      </form>
                </div>
            </div>
            @endif
            @foreach ($mechanics as $mechanic)
            <div class="col-lg-3">
                <a class="link" href="/mechanicdetails/{{$mechanic['id']}}">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        @if(!$mechanic['garage_photo_path1'])
                        <div class="list-group-item" style="background-image:url('/images/mechanic.png');height:200px; background-size:cover">

                        </div>
                        <div class="list-group-item">
                            {{$mechanic['name']}}
                        </div>
                        @else
                        <div class="list-group-item" style="background-image:url('/images/{{$mechanic['garage_photo_path1']}}'); height:200px; background-size:cover">
                        </div>
                        <div class="list-group-item">
                            {{$mechanic['name']}}
                        </div>
                        @endif
                    </ul>
                  </div>
                </a>
            </div>
            @endforeach

        </div>
    </body>
    <!-- Footer -->
    @include('includes.footer')
<html>