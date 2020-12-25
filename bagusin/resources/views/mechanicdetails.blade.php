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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
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

            <div class="col-lg-5">
                <div class="col-lg-10" style="float: right; margin-top:20px">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @if(count($pics) > 0)
                      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        @for($x = 1 ; $x < count($pics) ; $x++)
                        <li data-target="#myCarousel" data-slide-to="{{$x}}"></li>
                        @endfor
                        @endif
                    </ol>
                  
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                    @if(count($pics) > 0)
                      <div class="item active">
                        <img src="/images/{{$pics[0]}}"style="width: 100%; height: auto;">
                      </div>
                      @for($x = 1 ; $x < count($pics) ; $x++)
                      <div class="item">
                        <img src="/images/{{$pics[$x]}}" style="width: 100%; height: auto;">
                      </div>
                      @endfor
                    @else
                    <div class="item active">
                        <img src="/images/mechanic.png"style="width: 100%; height: auto;">
                      </div>
                    @endif
                    </div>
                  
                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                      <span class="glyphicon glyphicon-chevron-left"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                      <span class="glyphicon glyphicon-chevron-right"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="col-lg-8" style="margin-left:20px">
                        <h3>{{$mechanic->name}}</h3>
                        @if($mechanic->reviews_number == 0)
                        Belum ada penilaian<br><br>
                        @else
                        @for($x = 0 ; $x < ceil($mechanic->score/$mechanic->reviews_number); $x++)
                        <span class="fa fa-star checked" style="font-size: 10px; color: #f6c23e"></span>
                        @endfor &nbsp;<span style=" color: #f6c23e">{{$mechanic->score/$mechanic->reviews_number}}</span>
                        <br><br>
                        @endif
                        <span>{{$mechanic->address}}</span><br>
                        <span>{{$mechanic->phone}}</span><br>
                        <span>{{$mechanic->servicedescription}}</span><br>

                        <div class="text-center" style="margin-top:20px">
                            @if($mechanic->hasorder == 0 and Auth::guard('customer')->user())
                            <button class="btn btn-primary" style="width:40%" onclick="location.href='/callmechanic/{{$mechanic->id}}'">Panggil</button>
                            @else
                            <button class="btn btn-primary" style="width:40%" disabled>Panggil</button>
                            @endif
                        </div>
                </div>
            </div>
        </div>
    </body>
    <!-- Footer -->
    @include('includes.footer')
<html>