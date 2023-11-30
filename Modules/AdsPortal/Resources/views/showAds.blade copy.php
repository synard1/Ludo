<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
<body>
    <video id="autoplay" muted playsinline controls>
   <source src="https://www.youtube.com/embed/teBXFBSU0ik" type="video/mp4">
</video>
<!--end::Custom source(Vimeo)-->

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
<!--end::Custom Javascript-->
@stack('scripts')
<script src="/assets/plugins/custom/fslightbox/fslightbox.bundle.js"></script>
<!--end::Javascript-->

<script>
    document.addEventListener('livewire:load', () => {
        Livewire.on('success', (message) => {
            toastr.success(message);
        });
        Livewire.on('error', (message) => {
            toastr.error(message);
        });
    });
</script>
<script>
document.getElementById('autoplay').play();
</script>
@livewireScripts
</body>
</html>



