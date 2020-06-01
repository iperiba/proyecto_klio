<a href="{{ url('/') }}" id="branding">
    <img src="images/logo_klio_noFondo.png" alt="" class="logo" style="width: 130px;">
    <!--<div class="logo-copy">
        <h1 class="site-title">Company Name</h1>
        <small class="site-description">Tagline goes here</small>
    </div>-->
</a> <!-- #branding -->

<div class="main-navigation">
    <button type="button" class="menu-toggle"><i class="fa fa-bars"></i></button>
    <ul class="menu">
        <li class="menu-item current-menu-item"><a href="{{ url('/') }}">Portada</a></li>
        <li class="menu-item"><a href="{{ url('review_general') }}">Cartelera</a></li>
        <li class="menu-item"><a href="{{ url('about') }}">Sobre nosotros</a></li>
        <li class="menu-item"><a href="{{ url('contact') }}">Contacto</a></li>
    </ul> <!-- .menu -->

    <form action="#" class="search-form">
        <input type="text" placeholder="Search...">
        <button><i class="fa fa-search"></i></button>
    </form>
</div> <!-- .main-navigation -->