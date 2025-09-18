{{-- pageConfigs variable pass to Helper's updatePageConfig function to update page configuration  --}}
@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
<!DOCTYPE html>
@php
$configData = Helper::applClasses();
@endphp
<html class="loading"
    lang="@if(session()->has('locale')){{ session()->get('locale') }}@else{{ $configData['defaultLanguage'] }}@endif"
    data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Homi</title>
    <link rel="apple-touch-icon" href="{{ asset('images/favicon/apple-touch-icon-152x152.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon/favicon-32x32.png') }}">

    {{-- Core + vendor styles --}}
    @include('panels.styles')
</head>
<!-- END: Head-->

<body
    class="{{ $configData['mainLayoutTypeClass'] }} @if(!empty($configData['bodyCustomClass'])) {{ $configData['bodyCustomClass'] }} @endif"
    data-open="click" data-menu="vertical-modern-menu" data-col="1-column">

    {{-- BEGIN: Sidebar --}}
    <aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-dark sidenav-active-rounded">
        <div class="brand-sidebar">
            <h1 class="logo-wrapper">
                <a class="brand-logo darken-1" href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/logo/materialize-logo.png') }}" alt="logo" />
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
                <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">storage</i>
                    <span>Master Data</span>
                </a>
                <div class="collapsible-body">
                    <ul>
                        <li>
                            <a href="{{ route('categories.index') }}">
                                <i class="material-icons">home</i>
                                <span>Categories</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('attributes.index') }}">
                                <i class="material-icons">tune</i>
                                <span>Attributes</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('promos.index') }}">
                                <i class="material-icons">local_offer</i>
                                <span>Promos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('facilities.index') }}">
                                <i class="material-icons">location_city</i>
                                <span>Facilities</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('provinces.index') }}">
                                <i class="material-icons">map</i>
                                <span>Provinces</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('regencies.index') }}">
                                <i class="material-icons">location_city</i> 
                                <span>Regencies</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="bold">
                <a href="{{ route('products.index') }}" class="waves-effect waves-cyan">
                    <i class="material-icons">shopping_cart</i>
                    <span>Product</span>
                </a>
            </li>

            <li class="bold">
                <a href="{{ route('settings.edit') }}" class="waves-effect waves-cyan">
                    <i class="material-icons">settings</i>
                    <span>Setting</span>
                </a>
            </li>
        </ul>
    </aside>
    {{-- END: Sidebar --}}

    {{-- BEGIN: Content --}}
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    @yield('content')
                </div>
                <div class="content-overlay"></div>
            </div>
        </div>
    </div>
    {{-- END: Content --}}

    {{-- Vendor + page scripts --}}
    @include('panels.scripts')
    @stack('scripts')
</body>

</html>