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
        </style>
    </head>

    <!-- Navbar -->
    @include('includes.navbar')
    
    <body>
        <div class="jumbotron">
            <div class="col-lg-3">
            </div>
            <div class="col-lg-6" id="accountdetails">
                <div class="card" style="width: 80%;">
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item" style="font-weight: bolder">Pesanan</li>
                        @foreach($orders as $order)
                        <li id="customer{{$order->id}}" class="list-group-item" style="font-weight: bolder; height:50px; font-size:15px">
                            Order{{$order->id}}
                            <span style="float: right; margin-right:10px"><button class="btn btn-primary" onclick="detailpesanan({{$order->id}})" data-toggle="modal" data-target="#orderdetail">Detail</button></span>
                        </li>
                        @endforeach
                    </ul>
                  </div>

                  Halaman : {{ $orders->currentPage() }} <br/>
                  Jumlah Data : {{ $orders->total() }} <br/>
                  <span class="link" style="color:black">Data Per Halaman : {{ $orders->perPage() }} </span><br/>
               
               
                  <span class="links">{{ $orders->links() }}</a>
            </div>
            <div class="col-lg-3">
            </div>
        </div>
    </body>
    <!-- Footer -->
    @include('includes.footer')
    <script>
        function detailpesanan(id){
            $.ajax({
                url : '/admin/detailorder/' + id,
                type : 'GET',
                success : function(response){
                    $("#customer_name").html(response["order"]["customer_name"]);
                    $("#mechanic_name").html(response["order"]["mechanic_name"]);
                    $("#created_at").html(response["order"]["created_at"]);
                    $("#address").html(response["order"]["address"]);
                    $("#status").html(response["order"]["status"]);
                },
                error : function(){
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.error('Ada kesalahan, segera perbaiki.');
                }
            });
        }
    </script>

    <!-- Modal -->
    <div class="modal fade" id="orderdetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
                <li class="list-group-item" style="font-weight: bolder">
                    <span class="account-attribute">Nama Pelanggan</span><span id="customer_name"></span>
                </li>
                <li class="list-group-item" style="font-weight: bolder">
                    <span class="account-attribute">Nama Bengkel</span><span id="mechanic_name"></span>
                </li>
                <li class="list-group-item" style="font-weight: bolder">
                    <span class="account-attribute">Alamat</span><span id="address"></span>
                </li>
                <li class="list-group-item" style="font-weight: bHandphoneolder">
                    <span class="account-attribute">Dibuat</span><span id="created_at"></span>
                </li>
                <li class="list-group-item" style="font-weight: bHandphoneolder">
                    <span class="account-attribute">Status</span><span id="status"></span>
                </li>

            </div>
          </div>
        </div>
      </div>
<html>