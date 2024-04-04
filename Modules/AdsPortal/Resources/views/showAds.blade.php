<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data->sites }}</title>
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
<body onload="startTime()">
<span id="time" style="font-size: 28px;"></span>
<!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
<div id="player"></div>
<button id="unmuteButton"></button>

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
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '600',
          width: '800',
          videoId: 'teBXFBSU0ik',
          playerVars: {
            'playsinline': 1
          },
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        // event.target.mute();
        // event.target.setVolume(0); //this can be set from 0 to 100
        event.target.playVideo();
        // setTimeout(function(){
        //     var iframe = document.getElementById('player');
        //     if (iframe.requestFullscreen) {
        //     iframe.requestFullscreen(); // Chrome, Firefox & Safari
        //     } else if (iframe.mozRequestFullScreen) { 
        //     iframe.mozRequestFullScreen(); // Firefox
        //     } else if (iframe.webkitRequestFullscreen) { 
        //     iframe.webkitRequestFullscreen(); // Chrome and Safari
        //     } else if (iframe.msRequestFullscreen) {
        //     iframe.msRequestFullscreen(); // IE
        //     }
        // }, 5000);
      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      var done = false;

      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
          setTimeout(stopVideo, 10000);
          // setTimeout(exitFullscreen, 15000);
          done = true;
        }
      }
      function stopVideo() {
        player.stopVideo();
      }

      function exitFullscreen() {
    if (document.exitFullscreen) {
      document.exitFullscreen();
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
        }

        function checkTime(i) {
            if (i < 10) { i = "0" + i };  // add zero in front of numbers < 10
            return i;
        }
    </script>
@livewireScripts
</body>
</html>



