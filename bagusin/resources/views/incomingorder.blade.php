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
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
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
            .rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    font-size: 25px;
}

.rating>input {
    display: none
}
.rating>label {
    position: relative;
    width: 1em;
    font-size: 30px;
    color: #FFD600;
    cursor: pointer
}
.rating>label::before {
    content: "\2605";
    position: absolute;
    opacity: 0
}

.rating>label:hover:before,
.rating>label:hover~label:before {
    opacity: 1 !important
}

.rating>input:checked~label:before {
    opacity: 1
}

.rating:hover>input:checked~label:before {
    opacity: 0.4
}
.alert {
    padding: 10px;
    background-color: #1cc88a;
    color: white;
    font-size: 17px;
    position: -webkit-sticky;
    position: sticky;
    top: 0;
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
                <button class="btn btn-primary item" onclick="location.href='/myorder'" disabled>Pesanan Saya</button><br>
                @else
                <button class="btn btn-primary item" onclick="location.href='/myorder'" disabled>Pesanan Masuk</button><br>
                @endif
                <button class="btn btn-primary item" onclick="location.href='/riwayat'">Riwayat Pesanan</button><br>
                <button class="btn btn-primary item" onclick="location.href='/ubahpassword'">Ubah Password</button>
            </div>
            <div class="col-lg-7">
                <div class="card" style="width: 80%;">
                    <ul class="list-group list-group-flush">
                        @if($order)
                        <li class="list-group-item" style="font-weight: bolder">Pesanan</li>

                        <li class="list-group-item">
                            <span class="account-attribute">Nama Pelanggan</span>{{$customer->name}}<br>
                        </li>

                        <li class="list-group-item">
                            <span class="account-attribute">Dibuat Pada</span>{{$order->created_at}}<br>
                        </li>

                        <li class="list-group-item">
                            <span class="account-attribute">Kebutuhan</span>{{$order->problem_description}}<br>
                        </li>

                        <li class="list-group-item">
                            <span class="account-attribute">Lokasi</span>{{$order->address}}<br>
                        </li>
                        
                        <li class="list-group-item">
                            <span class="account-attribute">Status</span>{{$order->status}}<br>
                        </li>
                        <li class="list-group-item" style="height: 125px">
                            @for($x = 0 ; $x < 4 ; $x++)
                            @if($pics[$x] != NULL)
                            <div class="col-sm-2" style="background-size:cover;margin-right:8.3%; height:100%; background-color:white; background-image:url('/images/{{$pics[$x]}}')">
                            </div>
                            @endif
                            @endfor
                        </li>                        

                        @if($order->status == 'waiting')
                        <li class="list-group-item text-center">
                            <button type="button" onclick="reject()" class="btn btn-primary" style="margin-right:15px">Tolak</button>
                            <button type="button" onclick="accept()" class="btn btn-primary">Terima</button>
                        </li>
                        @endif

                        @if($order->status == 'accept')
                        <li class="list-group-item text-center">
                            <button type="button" onclick="finish()" class="btn btn-primary">Selesai</button>
                        </li>
                        @endif

                        @else
                        <li class="list-group-item" style="font-weight: bolder">Pesanan</li>
                        <li class="list-group-item">
                            <span class="account-attribute">Semua pesanan selesai!</span>
                        </li>
                        @endif
                    </ul>
                  </div>
            </div>
@if($order!=NULL)
            <script>
                function accept(){
                    $.ajax({
                        type : 'GET',
                        url : '/accept/{{$order->id}}',
                        success : function(){
                            alertify.set('notifier','position', 'top-center');
                            alertify.set('notifier','delay', 3);
                            alertify.success('Berhasil diterima! Segera selesaikan ya.');
                            setTimeout(function(){
                            location.reload();
                            }, 3000);
                        },
                        error : function(){
                            alertify.set('notifier','position', 'top-center');
                            alertify.set('notifier','delay', 3);
                            alertify.error('Ups! Ada kesalahan, coba lagi nanti ya.');
                        }
                    });
                }

                function reject(){
                    $.ajax({
                        type : 'GET',
                        url : '/reject/{{$order->id}}',
                        success : function(){
                            alertify.set('notifier','position', 'top-center');
                            alertify.set('notifier','delay', 3);
                            alertify.message('Sayang sekali ya! Sampai jumpa di pesanan berikutnya.');
                            setTimeout(function(){
                            location.reload();
                            }, 3000);
                        },
                        error : function(){
                            alertify.set('notifier','position', 'top-center');
                            alertify.set('notifier','delay', 3);
                            alertify.error('Ups! Ada kesalahan, coba lagi nanti ya.');
                        }
                    });
                }

                function finish(){
                    $.ajax({
                        type : 'GET',
                        url : '/finish/{{$order->id}}',
                        success : function(){
                            alertify.set('notifier','position', 'top-center');
                            alertify.set('notifier','delay', 3);
                            alertify.success('Luar biasa! Kamu menyelesaikan pesanan ini.');
                            setTimeout(function(){
                            location.reload();
                            }, 3000);
                        },
                        error : function(){
                            alertify.set('notifier','position', 'top-center');
                            alertify.set('notifier','delay', 3);
                            alertify.error('Ups! Ada kesalahan, coba lagi nanti ya.');
                        }
                    });
                }
            </script>
@endif
        </div>
    </body>
    <!-- Footer -->
    @include('includes.footer')


<html>