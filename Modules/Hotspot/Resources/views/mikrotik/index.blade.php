@php
    $linkloginonly = $data["link-login-only"];
    //$linkorigesc = $data["link-orig-esc"];
    $linkorigesc = "http%3A%2F%2Fgoogle.com%2F";
    $macesc = $data["mac-esc"];
    $trial = $data["trial"];

    $link  = $linkloginonly.'?dst='.$linkorigesc.'&username=T-'.$macesc;
    $ltrial  = htmlspecialchars($link, ENT_QUOTES);

    // var_dump($link);
@endphp

@extends('app')

@section('content')
<!--begin::Theme mode setup on page load-->
<script>
    var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }
</script>
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Page bg image-->
    <style>
        body {
            background-image: url('/assets/media/auth/bg9.jpg');
        }

        [data-bs-theme="dark"] body {
            background-image: url('/assets/media/auth/bg9-dark.jpg');
        }
    </style>
    <!--end::Page bg image-->
    <!--begin::Authentication - Signup Welcome Message -->
    <div class="d-flex flex-column flex-center flex-column-fluid">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center text-center p-10">
            <!--begin::Wrapper-->
            <div class="card card-flush w-lg-650px py-5">
                <div class="card-body py-15 py-lg-20">
                    <!--begin::Logo-->
                    <div class="mb-13">
                        <a href="../../demo1/dist/index.html" class="">
                            <img alt="Logo" src="/assets/media/logos/custom-2.svg" class="h-40px" />
                        </a>
                    </div>
                    <!--end::Logo-->
                    <!--begin::Title-->
                    <h1 class="fw-bolder text-gray-900 mb-7">{{ $userDetail->instansi ?? 'Nama Instansi'}}</h1>
                    <!--end::Title-->
                    <!--begin::Counter-->
                    <!--end::Counter-->
                    <!--begin::Text-->
                    <div class="fw-semibold fs-6 text-gray-500 mb-7">{{ $user->tagline ?? 'Tagline'}}
                        <!--end::Text-->
                        <!--begin::Form-->
                        <form class="w-md-350px mb-2 mx-auto" action="#" id="kt_coming_soon_form">
                            <div class="fv-row text-start">
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Nama Lengkap</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" class="form-control" autocomplete="off"
                                        placeholder="Nama Lengkap" name="namalengkap" />
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="">Email</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" placeholder="Email" name="email" autocomplete="off"
                                        class="form-control" />
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">No. Telp</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" placeholder="Phone Number" name="phone" autocomplete="off"
                                        class="form-control" />
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Status</span>
                                    </label>
                                    <!--end::Label-->
                                    <div class="col-sm-9" id="statusContainer">
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-secondary"> <input type="radio" name="statuskunjungan"
                                                    value="pasien" /> Pasien </label>
                                            <label class="btn btn-secondary"> <input type="radio" name="statuskunjungan"
                                                    value="pegawai" /> Pegawai </label>
                                            <label class="btn btn-secondary"> <input type="radio" name="statuskunjungan"
                                                    value="tamu" /> Tamu </label>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column fv-row">
                                    <div class="fl">
                                        <div class="fl pa2">
                                            <label class="db lh-copy"> <input class="mr2" type="checkbox"
                                                    name="agreements[]" value="terms" /> Saya telah membaca dan setuju dengan <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_ketentuan">Ketentuan Layanan</a></label>
                                            {{-- <label class="db lh-copy"> <input class="mr2" type="checkbox"
                                                    name="agreements[]" value="privacy-policy" /> Saya Setuju dengan Kebijakan Privasi </label> --}}
                                        </div>
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <p></p>
                                <!--begin::Submit-->
                                <button class="btn btn-primary text-nowrap" id="kt_coming_soon_submit">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Submit</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                                <!--end::Submit-->
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Signup Welcome Message-->
    </div>

    @include('hotspot/ketentuan')
    @endsection

    @section('js')

    <!--begin::Custom Javascript(used for this page only)-->
    <script type="text/javascript">
        var _token = $("input[name='_token']").val();
        var nama = $("input[name='nama']").val();
        var email = $("input[name='email']").val();
        var telp = $("input[name='telp']").val();
        var status = $('input[name=status]:checked').val();
        var sk = $('input[name=sk]:checked').val();
        var link = "{{ $link }}";
        var linkk = link.replace("amp;","");
    </script>

    <script src="/assets/js/hotspot/login.js"></script>

    <!--end::Custom Javascript-->
    @endsection
