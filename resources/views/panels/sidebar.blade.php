<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-dark sidenav-active-rounded">
  <div class="brand-sidebar">
    <h1 class="logo-wrapper">
      <a class="brand-logo darken-1" href="{{ route('dashboard') }}">
        <img src="{{ asset('images/logo/materialize-logo.png') }}" alt="logo"/>
        <span class="logo-text hide-on-med-and-down">Homi</span>
      </a>
    </h1>
  </div>
  <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow"
      id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">

    <li class="bold">
      <a href="{{ route('dashboard') }}" class="waves-effect waves-cyan">
        <i class="material-icons">dashboard</i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="bold">
      <a href="{{ route('master') }}" class="waves-effect waves-cyan">
        <i class="material-icons">storage</i>
        <span>Master Data</span>
      </a>
    </li>

    <li class="bold">
      <a href="{{ route('products') }}" class="waves-effect waves-cyan">
        <i class="material-icons">shopping_cart</i>
        <span>Product</span>
      </a>
    </li>

    <li class="bold">
      <a href="{{ route('settings') }}" class="waves-effect waves-cyan">
        <i class="material-icons">settings</i>
        <span>Setting</span>
      </a>
    </li>

  </ul>
</aside>
