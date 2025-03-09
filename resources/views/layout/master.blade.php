<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! printHtmlAttributes('html') !!}>
<!--begin::Head-->
<head>
    <base href=""/>
    <title>{{ config('onexolution.system.app_name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content=""/>
    <link rel="canonical" href=""/>

    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    {!! includeFavicon() !!}

    <!--begin::Fonts-->
    {!! includeFonts() !!}
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    @foreach(getGlobalAssets('css') as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Vendor Stylesheets(used by this page)-->
    @foreach(getVendors('css') as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Vendor Stylesheets-->

    <!--begin::Custom Stylesheets(optional)-->
    @foreach(getCustomCss() as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    @stack('styles')
    <!--end::Custom Stylesheets-->

    @livewireStyles

</head>
<!--end::Head-->

<!--begin::Body-->
<body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}>

@include('partials/theme-mode/_init')

@yield('content')

<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
@foreach(getGlobalAssets() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach
<!--end::Global Javascript Bundle-->

<!--begin::Vendors Javascript(used by this page)-->
@foreach(getVendors('js') as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach
<!--end::Vendors Javascript-->

<!--begin::Custom Javascript(optional)-->
@foreach(getCustomJs() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach

<!--end::Javascript-->

<script>
    window.livewireIsInitialized = false; // Initialize a flag

    document.addEventListener('livewire:init', function () {
        window.livewireIsInitialized = true; // Set the flag when Livewire is loaded
        console.log("Livewire is initialized.");
    });

    // Optional: Check if Livewire is already loaded (for cases where it loads very quickly)
    if (typeof Livewire !== 'undefined') {
      window.livewireIsInitialized = true;
      console.log("Livewire was already initialized.");
    }


    function checkLivewire() {
      if (window.livewireIsInitialized) {
        console.log("Livewire is running.");
        // Perform actions that require Livewire to be loaded.
      } else {
        console.log("Livewire is not yet running.");
        // Handle cases where Livewire is not yet loaded (e.g., show a loading message).
      }
    }

</script>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('success', (message) => {
            toastr.success(message);
        });
        Livewire.on('error', (message) => {
            toastr.error(message);
        });
    });

</script>

<script>
    window.accessToken = "{{ session('access_token') }}"; // Make it available globally, or
    // For better scoping (if the token is only needed in a specific function):
    function useAccessToken() {
        const token = "{{ session('access_token') }}";
        console.log('Token:', token);
        // ... use the token in your function ...
    }

    // Call the function if needed or call it when you need the token
    useAccessToken();

</script>

@livewireScripts

<!--end::Custom Javascript-->
@stack('scripts')
</body>
<!--end::Body-->

</html>