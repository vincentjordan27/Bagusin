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
                        @if($order != NULL)
                        <li class="list-group-item" style="font-weight: bolder">Pesanan</li>

                        <li class="list-group-item">
                            <span class="account-attribute">Nama Mekanik</span>{{$mechanic->name}}<br>
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
                        @if($order->status == 'waiting')
                        <li class="list-group-item text-center">
                            <button type="button" onclick="cancel()" class="btn btn-primary" style="margin-right:15px">Batalkan</button>
                        </li>
                        @endif
                        @if($order != NULL)

                        @if($order->status == 'done' and $order->customer_rating == null)
                        <li class="list-group-item text-center">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reviewmodal">Ulas Produk</button>
                        </li>
                        
                        @endif
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
            @if($order != NULL)

            @if($order->status == 'done' and $order->customer_rating == null and Auth::guard('customer')->user())
            <div class="modal fade" id="reviewmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">

                    <form method="POST"  style="margin:10px">
                        @csrf
                      <div class="form-group">
                        <label for="ex2" style="font-weight: bold; color:#000; margin-bottom:10px">Ulasan Anda</label>
                        <textarea class="form-control" id="body" name="body" required size="100px"></textarea>
                        
                        </div>
                        <label for="ex2" style="font-weight: bold; color:#000; margin-bottom:0px">Penilaian Anda</label><br>    
                        <div class="rating" style="margin-bottom: -10px;">
                              <input type="radio" name="star" value="5" id="star-5">
                              <label for="star-5">☆</label>
                              <input type="radio" name="star" value="4" id="star-4">
                              <label for="star-4">☆</label>
                              <input type="radio" name="star" value="3" id="star-3">
                              <label for="star-3">☆</label>
                              <input type="radio" name="star" value="2" id="star-2">
                              <label for="star-2">☆</label>
                              <input type="radio" name="star" value="1" id="star-1">
                              <label for="star-1">☆</label>
                          </div>
                          @if($order)
                          <script>
                              function sendreview(){
                                  $.ajax({
                                      url : '/postreview/{{$order->id}}',
                                      type : 'POST',
                                      data : {
                                          "_token" : '{{csrf_token()}}',
                                          'text' : $('#body').val(),
                                          'score' : $('input[name="star"]:checked').val(),
                                      },
                                      success : function(response){
                                            alertify.set('notifier','position', 'top-center');
                                            alertify.set('notifier','delay', 3);
                                            alertify.success('Ulasanmu terikirim! Terima kasih.');
                                            setTimeout(function(){
                                            window.location.href = '/riwayat';
                                            }, 3000);
                                      },
                                      error : function(jqxhr, status, exception){
                                            alertify.set('notifier','position', 'top-center');
                                            alertify.set('notifier','delay', 3);
                                            alertify.error(exception);
                                      }
                                  });
                              }
                         </script>
                         @endif
                          <div class="submit-button text-center" style="margin-top:15px;">
                            <button onclick="sendreview();" type="button">Kirim Ulasan</button>
                        </div>
                      </form>
                    <div class="modal-body">Tinggalkan ulasan yang juga mungkin dapat membantu orang lain.</div>
                  </div>
                </div>
              </div>
              @endif
              @endif
              @if($order)
              <script>
                    function cancel(){
                    $.ajax({
                        type : 'GET',
                        url : '/cancel/{{$order->id}}',
                        success : function(){
                            alertify.set('notifier','position', 'top-center');
                            alertify.set('notifier','delay', 3);
                            alertify.message('Duh, kamu membatalkan pesanan ini. Sampai jumpa di pemesanan berikutnya.');
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