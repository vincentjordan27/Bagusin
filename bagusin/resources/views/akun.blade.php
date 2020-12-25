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
                <button class="btn btn-primary item" id="editbutton">Edit Profil</button><br>
                @if(Auth::guard('customer')->user())
                <button class="btn btn-primary item" onclick="location.href='/myorder'">Pesanan Saya</button><br>
                @else
                <button class="btn btn-primary item" onclick="location.href='/myorder'">Pesanan Masuk</button><br>
                @endif
                <button class="btn btn-primary item" onclick="location.href='/riwayat'">Riwayat Pesanan</button><br>
                <button class="btn btn-primary item" onclick="location.href='/ubahpassword'">Ubah Password</button>
            </div>
            <div class="col-lg-6" id="accountdetails">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" style="font-weight: bolder">Akun</li>
                        <!-- Account's details -->
                        @if (session('message'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{{ session('message') }}</li>
                            </ul>
                        </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                    <button class="btn btn-secondary" onclick="$('#editbutton').click();" class="link">Ulangi</button>
                                </ul>
                            </div>
                        @endif

                        @if (Auth::guard('customer')->user())
                        <li class="list-group-item">
                            <span class="account-attribute" width="1000px">Nama</span>
                            <span>{{ Auth::guard('customer')->user()->name }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute">Alamat</span>
                            <span>{{ Auth::guard('customer')->user()->address }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute">Nomor Telepon</span>
                            <span>{{ Auth::guard('customer')->user()->phone }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute">Email</span>
                            <span>{{ Auth::guard('customer')->user()->email }}</span>
                        </li>
                        @elseif (Auth::guard('mechanic')->user())
                        <li class="list-group-item">
                            <span class="account-attribute" width="1000px">Nama Jasa</span>
                            <span>{{ Auth::guard('mechanic')->user()->name }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute">Alamat</span>
                            <span>{{ Auth::guard('mechanic')->user()->address }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute">Nomor Telepon</span>
                            <span>{{ Auth::guard('mechanic')->user()->phone }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute">Jenis Layanan</span>
                            <span>{{ Auth::guard('mechanic')->user()->services }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute">Deskripsi Layanan</span><br>
                            <span>{{ Auth::guard('mechanic')->user()->servicedescription }}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute">Email</span>
                            <span>{{ Auth::guard('mechanic')->user()->email }}</span>
                        </li>
                        <li class="list-group-item" style="height: 125px">

                            @for($x = 0 ; $x < 4 ; $x++)
                            @if($pics[$x] != NULL)
                            <div class="col-sm-2" style="background-size:cover;margin-right:8.3%; height:100%; background-color:white; background-image:url('/images/{{$pics[$x]}}')">
                            </div>
                            @else
                            <div class="col-sm-2" style="background-size:cover;margin-right:8.3%; height:100%; background-color:white; background-image:url('/images/addphoto.png')">
                            </div>
                            @endif
                            @endfor

                        @endif
                    </ul>
                  </div>
            </div>

            <div class="col-lg-7" id="editaccountdetails">
                <div class="card" style="width: 60%;">
                    <form method="POST" action="/akun" enctype="multipart/form-data">
                        @csrf
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" style="font-weight: bolder">Edit Akun</li>
                        <!-- Account's details -->
                        <!-- Customer -->
                        @if (Auth::guard('customer')->user())
                        <li class="list-group-item">
                            <span class="account-attribute" width="1000px">Nama Lengkap</span>
                            <input class="form-control" name="name" type="text" value="{{ Auth::guard('customer')->user()->name }}">
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute">Alamat</span>
                            <input class="form-control" name="address" type="text" value="{{ Auth::guard('customer')->user()->address }}">
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute">Nomor Telepon</span>
                            <input class="form-control" name="phone" type="text" value="{{ Auth::guard('customer')->user()->phone }}">
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute">Email</span>
                            <span>{{ Auth::guard('customer')->user()->email }}</span>
                        </li>
                        <li class="list-group-item">
                            <button class="btn btn-success" type="submit">Simpan</button>
                            <button class="btn btn-default" type="button" id="cancelbutton">Batal</button>
                        </li>
                        <!-- Mechanic -->
                        @elseif (Auth::guard('mechanic')->user())
                        <li class="list-group-item">
                            <span class="account-attribute" width="1000px">Nama Jasa</span>
                            <input class="form-control" name="name" type="text" value="{{ Auth::guard('mechanic')->user()->name }}">
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute">Alamat</span>
                            <input class="form-control" name="address" type="text" value="{{ Auth::guard('mechanic')->user()->address }}">
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute">Nomor Telepon</span>
                            <input class="form-control" name="phone" type="text" value="{{ Auth::guard('mechanic')->user()->phone }}">
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute">Jenis Layanan</span>
                            <input class="form-control" name="services" type="text" value="{{ Auth::guard('mechanic')->user()->services }}">
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute">Deskripsi Layanan</span>
                            <textarea class="form-control" name="servicedescription" type="text" >{{ Auth::guard('mechanic')->user()->servicedescription }}</textarea>
                        </li>
                        <li class="list-group-item">
                            <span class="account-attribute">Email</span>
                            <span>{{ Auth::guard('mechanic')->user()->email }}</span>
                        </li>
                        <li class="list-group-item" style="height: 180px">
                            <input class="fileinput" name="mechanicpic1" type="file"/>

                            <input class="fileinput" name="mechanicpic2" type="file"/>

                            <input class="fileinput" name="mechanicpic3" type="file"/>

                            <input class="fileinput" name="mechanicpic4" type="file"/>
                        </li>
                        <li class="list-group-item">
                            <button class="btn btn-success" type="submit">Simpan</button>
                            <button class="btn btn-default" type="button" id="cancelbutton">Batal</button>
                        </li>
                        @endif
                    </ul>
                    </form>
                  </div>
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