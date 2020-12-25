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
                <!--<img src="/images/profilepicturebutton.png" style="height: 20vh"><br>-->
                <button class="btn btn-primary item" onclick="location.href='/akun'">Edit Profil</button><br>
                @if(Auth::guard('customer')->user())
                <button class="btn btn-primary item" onclick="location.href='/myorder'">Pesanan Saya</button><br>
                @else
                <button class="btn btn-primary item" onclick="location.href='/myorder'">Pesanan Masuk</button><br>
                @endif
                <button class="btn btn-primary item" disabled>Riwayat Pesanan</button><br>
                <button class="btn btn-primary item" onclick="location.href='/ubahpassword'">Ubah Password</button>
            </div>
            <div class="col-lg-7">
                <div class="card" style="width: 80%;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" style="font-weight: bolder">Riwayat</li>
                        @if (!$orders)
                        Ups! Belum ada pesanan.
                        @endif
                        @foreach ($orders as $order)
                        @if(Auth::guard('customer')->user())
                        <li class="list-group-item">
                            <span class="account-attribute">Mekanik</span>{{$order->mechanic_name}}<br>
                            <span class="account-attribute">Status</span>{{$order->status}}<br>

                        </li>
                        @else
                        <li class="list-group-item">
                            <span class="account-attribute">Pemesan</span>{{$order->customer_name}}<br>
                            <span class="account-attribute">Status</span>{{$order->status}}<br>

                        </li>
                        @endif
                        @endforeach
                    </ul>
                  </div>

                  Halaman : {{ $orders->currentPage() }} <br/>
                  Jumlah Data : {{ $orders->total() }} <br/>
                  <span class="link" style="color:black">Data Per Halaman : {{ $orders->perPage() }} </span><br/>
               
               
                  <span class="links">{{ $orders->links() }}</a>
            </div>
        </div>
    </body>
    <!-- Footer -->
    @include('includes.footer')

    <script>
        $(document).ready(function(){
            $('#editaccountdetails').css('visibility', 'hidden');
            $('#editaccountdetails').css('display', 'none');
        });
        $('#editbutton').click(function(){
            $('#editbutton').prop('disabled', true);
            $('#editaccountdetails').css('visibility', 'visible');
            $('#editaccountdetails').css('display', 'inline');
            $('#accountdetails').css('visibility', 'hidden');
            $('#accountdetails').css('display', 'none');
        });
        $('#cancelbutton').click(function(){
            $('#editbutton').prop('disabled', false);
            $('#editaccountdetails').css('visibility', 'hidden');
            $('#editaccountdetails').css('display', 'none');
            $('#accountdetails').css('visibility', 'visible');
            $('#accountdetails').css('display', 'inline');
        });
    </script>


<html>