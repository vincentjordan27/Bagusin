<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
<nav class="navbar navbar-light" style="background-color: #4986F8; height:10vh; border-radius:0px;">
  <!-- Navbar content -->
  <a class="navbar-brand" href="/"><img id="logo" src="/images/bagusin.png"></a>
  <div style="padding-right:50px;text-align: right; margin-top:2vh">

    @if ((!Auth::guard('customer')->user()) and (!Auth::guard('mechanic')->user()) and (!Auth::guard('admin')->user()))
    <a class="btn nav-item" href="/daftar">Daftar</a>
    <a class="btn nav-item" href="/masuk">Masuk</a>
    @endif

    <!-- Admin -->
    @if(!Auth::guard('admin')->user())
    <a class="btn nav-item" data-toggle="modal" data-target="#aboutmodal">Tentang Kami</a>
    <a class="nav-item" href="/myorder"><img id="bell" src="/images/bell.png"></a>
    @endif

    <!-- Customer -->
    @if (Auth::guard('customer')->user())
    <a class="btn nav-item" type="button" class="" data-toggle="modal" data-target="#profileModal">
      {{ Auth::guard('customer')->user()->name }}
    </a>
    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="width: 180px; margin-left:50vw">
          <div class="modal-body">
            <a href="/akun" class="profilemenu">Pengaturan Akun</a><br>
            <a href="/riwayat" class="profilemenu">Pesanan Saya</a><br>
            <a href="/keluar" class="profilemenu">Keluar</a><br>
          </div>
        </div>
      </div>
    </div>
    @endif

    <!-- Mechanic -->
    @if (Auth::guard('mechanic')->user())
    <a class="btn nav-item" type="button" class="" data-toggle="modal" data-target="#profileModal">
      {{ Auth::guard('mechanic')->user()->name }}
    </a>
    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="width: 180px; margin-left:50vw">
          <div class="modal-body">
            <a href="/akun" class="profilemenu">Pengaturan Akun</a><br>
            <a href="/riwayat" class="profilemenu">Pesanan Saya</a><br>
            <a href="/keluar" class="profilemenu">Keluar</a><br>
          </div>
        </div>
      </div>
    </div>
    @endif

    @if(Auth::guard('admin')->user())
    <a class="btn nav-item" href="/admin/dashboard">Admin</a>
    <a class="btn nav-item" href="/admin/logout">Keluar</a>
    @endif

    <!-- End Profile Modal -->
</nav>
<!--About us modal -->

<div class="modal fade" id="aboutmodal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">BagusIn</h5>
      </div>
      <div class="modal-body">
        BagusIn adalah aplikasi penghubungmu dengan mekanik panggilan berbasis mobile dan web. Kami bekerjasama dengan tenaga profesional terbaik di kota Antuk menyediakan layanan dan pengalaman terbaik.
      </div>

    </div>
  </div>
</div>

<!-- end of modal -->
<style>
  .profilemenu{
    text-decoration: none;
    color: black;
  }
  .profilemenu:hover{
    text-decoration: none;
    color: black;
  }
  #logo{
    height: 7vh;
    margin-left:50px;
    margin-top: -1.3vh;
  }
  #bell{
    height: 4vh;
  }
  .nav-item{
    font-size: 16px;
    margin-right: 20px
  }
</style>
@if(Auth::guard('customer')->user() or Auth::guard('mechanic')->user())
<script>

</script>
@endif
