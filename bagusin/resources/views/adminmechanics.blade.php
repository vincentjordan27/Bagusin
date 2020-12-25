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

                        <li class="list-group-item" style="font-weight: bolder">Mekanik</li>
                        @foreach($mechanics as $mechanic)
                        <li id="mechanic{{$mechanic->id}}" class="list-group-item" style="font-weight: bolder; height:50px; font-size:15px">
                            {{$mechanic->name}}
                            <span style="float: right"><button class="btn btn-danger" onclick="hapusmekanik({{$mechanic->id}})">Hapus</button></span>
                            <span style="float: right; margin-right:10px"><button class="btn btn-primary" onclick="detailmekanik({{$mechanic->id}})" data-toggle="modal" data-target="#mechanicdetail">Detail</button></span>
                        </li>
                        @endforeach
                    </ul>
                  </div>

                  Halaman : {{ $mechanics->currentPage() }} <br/>
                  Jumlah Data : {{ $mechanics->total() }} <br/>
                  <span class="link" style="color:black">Data Per Halaman : {{ $mechanics->perPage() }} </span><br/>
               
               
                  <span class="links">{{ $mechanics->links() }}</a>
            </div>
            <div class="col-lg-3">
            </div>
        </div>
    </body>
    <!-- Footer -->
    @include('includes.footer')
    <script>
        function hapusmekanik(id){
            $.ajax({
                url : '/admin/deletemechanic/' + id,
                type : 'GET',
                success : function(){
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.success('Mekanik dihapus.');
                    $('#mechanic'+id).remove();
                },
                error : function(){
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.error('Ada kesalahan, segera perbaiki.');
                }
            });
        }

        function detailmekanik(id){
            $.ajax({
                url : '/admin/detailmechanic/' + id,
                type : 'GET',
                success : function(response){
                    $("#name").html(response["mechanic"]["name"]);
                    $("#email").html(response["mechanic"]["email"]);
                    $("#phone").html(response["mechanic"]["phone"]);
                    $("#address").html(response["mechanic"]["address"]);
                    $("#services").html(response["mechanic"]["services"]);
                    $("#servicedescription").html(response["mechanic"]["servicedescription"]);

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
    <div class="modal fade" id="mechanicdetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
                <li class="list-group-item" style="font-weight: bolder">
                    <span class="account-attribute">Nama</span><span id="name"></span>
                </li>
                <li class="list-group-item" style="font-weight: bolder">
                    <span class="account-attribute">Email</span><span id="email"></span>
                </li>
                <li class="list-group-item" style="font-weight: bolder">
                    <span class="account-attribute">Alamat</span><span id="address"></span>
                </li>
                <li class="list-group-item" style="font-weight: bolder">
                    <span class="account-attribute">Handphone</span><span id="phone"></span>
                </li>
                <li class="list-group-item" style="font-weight: bolder">
                    <span class="account-attribute">Layanan</span><span id="services"></span>
                </li>
                <li class="list-group-item" style="font-weight: bolder">
                    <span class="account-attribute">Deskripsi Layanan</span><span id="servicedescription"></span>
                </li>

            </div>
          </div>
        </div>
      </div>
<html>