@php
$path1 = Module::asset('AdsPortal:css/style.bundle.css');


@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! printHtmlAttributes('html') !!}>
<!--begin::Head-->
<head>
    <base href=""/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content=""/>
    <link rel="canonical" href=""/>

    {!! includeFavicon() !!}

    <!--begin::Fonts-->
    {!! includeFonts() !!}
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ Module::asset('adsportal:css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
    <!-- Lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

    


<!--[if (lt IE 9)]><script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.helper.ie8.js"></script><![endif]-->
    <!--end::Global Stylesheets Bundle-->

    @livewireStyles
    <style>
        #player {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.9);
}

    </style>
</head>
<!--end::Head-->

<!--begin::Body-->
<!-- <body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}> -->
<body onload="startTime()" id="kt_app_body" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="false" data-kt-app-sidebar-fixed="false" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
<!-- <a href="https://www.youtube.com/embed/oXPMW-YmKgI?enablejsapi=1&mute=1" data-lightbox="youtube-video" id="youtube-link">
    <img src="path-to-your-thumbnail.jpg">
</a> -->

<!-- <div id="video-gallery">
    <a href="https://www.youtube.com/watch?v=oXPMW-YmKgI">
        <img src="https://img.youtube.com/vi/oXPMW-YmKgI/hqdefault.jpg">
    </a>
</div> -->
<!-- <a href="https://www.youtube.com/watch?v=YoXPMW-YmKgI" data-lightbox="youtube-video">
    <img src="path-to-your-thumbnail.jpg">
</a> -->
<div id="player"></div>

@include('partials/theme-mode/_init')

@yield('content')
<!-- jQuery -->
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
<!--end::Javascript-->


<!-- Include YouTube Iframe API -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
<!-- Include YouTube Iframe API -->
<script src="https://www.youtube.com/iframe_api"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Include Lightbox2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <script type="text/javascript">

        // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;

// Create a new Date object for the current date and time
let now = new Date();
function onYouTubeIframeAPIReady() {
    // player = new YT.Player('player', {
    //     height: '390',
    //     width: '640',
    //     videoId: 'YoXPMW-YmKgI',
    //     playerVars: {
    //         autoplay: 0,      // Auto-play the video on load
    //         controls: 1,      // Show pause/play buttons in player
    //         showinfo: 0,      // Hide the video title
    //         modestbranding: 1, // Hide the Youtube Logo
    //         loop: 1,          // Run the video in a loop
    //         fs: 0,            // Hide the full screen button
    //         cc_load_policty: 0, // Hide closed captions
    //         iv_load_policy: 3,  // Hide the Video Annotations
    //         autohide: 0,      // Hide video controls when playing
    //         mute: 1,          // Start video muted
    //     },
    //     events: {
    //         'onReady': onPlayerReady
    //     }
    // });
    player = new YT.Player('player', {
          height: '600',
          width: '800',
          videoId: 'teBXFBSU0ik',
          playerVars: {
            'playsinline': 1,
            'mute': 1,
          },
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
}

function onPlayerReady(event) {
    // Get the current hours and minutes
    let hours = now.getHours();
    let minutes = now.getMinutes();
    // console.log(hours);
    // console.log(minutes);
    if (hours === 20 && minutes === 35) {
        console.log('waktu nya mulai');
        document.getElementById("player").style.display = "block";
        event.target.playVideo();
        var iframe = document.getElementById('player');
        if (iframe.requestFullscreen) {
        iframe.requestFullscreen(); // Chrome, Firefox & Safari
        } else if (iframe.mozRequestFullScreen) { 
        iframe.mozRequestFullScreen(); // Firefox
        } else if (iframe.webkitRequestFullscreen) { 
        iframe.webkitRequestFullscreen(); // Chrome and Safari
        } else if (iframe.msRequestFullscreen) {
        iframe.msRequestFullscreen(); // IE
        }
    }
    setTimeout(function(){
        // document.getElementById("player").style.display = "block";
        // event.target.playVideo();
        // var iframe = document.getElementById('player');
        // if (iframe.requestFullscreen) {
        // iframe.requestFullscreen(); // Chrome, Firefox & Safari
        // } else if (iframe.mozRequestFullScreen) { 
        // iframe.mozRequestFullScreen(); // Firefox
        // } else if (iframe.webkitRequestFullscreen) { 
        // iframe.webkitRequestFullscreen(); // Chrome and Safari
        // } else if (iframe.msRequestFullscreen) {
        // iframe.msRequestFullscreen(); // IE
        // }
    }, 5000); // Start video after 5 seconds
}

var done = false;

      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
          setTimeout(stopVideo, 13000);
          setTimeout(exitFullscreen, 15000);
          
          done = true;
        }
      }
      function stopVideo() {
        player.stopVideo();
      }

function exitFullscreen() {
    if (document.exitFullscreen) {
      document.exitFullscreen();
      document.getElementById("player").style.display = "none";
    }
  }

  function startTime() {
    var today = new Date();
            var h     = today.getHours();
            var m     = today.getMinutes();
            var s     = today.getSeconds();
            m         = checkTime(m);
            s         = checkTime(s);
            $('#time').html(h + ":" + m + ":" + s);
            var t = setTimeout(startTime, 500);

            if('20' == h)
  	if('55' == m)
    	if('10' == s)
  alert('a');
        }

        function checkTime(i) {
            if (i < 10) { i = "0" + i };  // add zero in front of numbers < 10
            return i;
        }
    </script>
<!-- NOTE: prior to v2.2.1 tiny-slider.js need to be in <body> -->
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

@livewireScripts
</body>
<!--end::Body-->

</html>
