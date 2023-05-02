
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title> ایمل های ارسالی </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Premium Bootstrap 4 Landing Page Template">
    <meta name="keywords" content="Appointment, Booking, System, Dashboard, Health">
    <meta name="author" content="Shreethemes">
    <meta name="email" content="support@shreethemes.in">
    <meta name="website" content=" ">
    <meta name="Version" content="v1.2.0">
    <!-- favicon -->

    <!-- simplebar -->
    <link href="{{asset('assets/css/simplebar.css')}}" rel="stylesheet" type="text/css">
    <!-- Icons -->

    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
    <!-- Bootstrap -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <!-- Icons -->
    <link href="{{asset('assets/css/materialdesignicons.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/remixicon.css')}}" rel="stylesheet" type="text/css">


    <!-- Iconscout -->
    {{--    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">--}}
    <link href="{{asset('assets/css/unicons.iconscout.com/release/v3.0.6/css/line.css')}}" rel="stylesheet">
    <!-- Css -->
    <link href="{{asset('assets/css/style-rtl.min.css')}}" rel="stylesheet" type="text/css" id="theme-opt">

</head>

<body>


<div class="page-wrapper doctris-theme toggled">
    @include('layouts.navbar')
    <!-- Start Page Content -->
    <main class="page-content bg-light">
        <div class="top-header">
            <div class="header-bar d-flex justify-content-between border-bottom">
                <div class="d-flex align-items-center">
                    <a href="#" class="logo-icon">
                        <img src="{{asset('assets/images/logo-icon.png')}}" height="30" class="small" alt="">
                        <span class="big">
                                    <img src="{{asset('assets/images/logo-dark.png')}}" height="24" class="logo-light-mode" alt="">
                                    <img src="{{asset('assets/images/logo-light.png')}}" height="24" class="logo-dark-mode" alt="">
                                </span>
                    </a>
                    <a id="close-sidebar" class="btn btn-icon btn-pills btn-soft-primary me-2" href="#">
                        <i class="uil uil-bars"></i>
                    </a>
                    <div class="search-bar p-0 d-none d-lg-block me-2">
                        <div id="search" class="menu-search mb-0">
                            <form role="search" method="get" id="searchform" class="searchform">
                                <div>
                                    <input type="text" class="form-control border rounded-pill" name="s" id="s" placeholder="جستجو کلیدواژه...">
                                    <input type="submit" id="searchsubmit" value="Search">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="container-fluid">
            <div class="layout-specing">
                <div class="d-md-flex justify-content-between">
                    <h5 class="mb-0">ایمیل های ارسالی</h5>

                    <nav aria-label="breadcrumb" class="d-inline-block mt-4 mt-sm-0">
                        <ul class="breadcrumb bg-transparent rounded mb-0 p-0">
                            <li class="breadcrumb-item"><a href="index.html">دوماس میل</a></li>
                            <li class="breadcrumb-item active" aria-current="page">ایمیل های ارسالی</li>
                        </ul>
                    </nav>
                </div>

                <div class="col-12 card rounded border-0 mt-4 overflow-hidden">
                    <div class="row g-1">


                        <div class="col-xl-12 col-lg-9 col-md-8 col-12 mt-4 mt-sm-0">
                            <div class="tab-content rounded-0 shadow" id="pills-tabContent">
                                <div class="tab-pane fade bg-white show active" id="inbox" role="tabpanel" aria-labelledby="inbox-tab">
                                    <div class="col-12 table-responsive">

                                        <div class="col-12 card">
                                            <div class="card-header">
                                               گیرنده: {{$email->to}}
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">{{$email->subject}}</h5>
                                                <p class="card-text">
                                                    {!! $email->message !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                </div><!--end teb pane-->

                                <div class="tab-pane fade bg-white rounded" id="starred" role="tabpanel" aria-labelledby="starred-tab">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-email table-center table-nowrap">
                                            <thead>
                                            <tr>
                                                <th class="border-bottom py-3" style="min-width: 15px;" scope="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input check" type="checkbox" value="" id="checkAll1">
                                                        <label class="form-check-label fw-normal" for="checkAll1"></label>
                                                    </div>
                                                </th>
                                                <th class="border-bottom py-3" style="min-width: 15px;" scope="col">
                                                    <a href="#" class="text-muted"><i class="uil uil-redo"></i></a>
                                                </th>
                                                <th class="border-bottom py-3" style="min-width: 150px;" scope="col"></th>
                                                <th class="border-bottom py-3" style="min-width: 750px;" scope="col"></th>
                                                <th class="border-bottom py-3 text-end" style="min-width: 150px;" scope="col">
                                                    <a href="#" class="btn btn-icon btn-sm btn-pills btn-soft-light"><i class="uil uil-angle-left icons"></i></a>
                                                    <a href="#" class="btn btn-icon btn-sm btn-pills btn-soft-light"><i class="uil uil-angle-right icons"></i></a>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input class="form-check-input check" type="checkbox" value="" id="checkbox16">
                                                        <label class="form-check-label" for="checkbox16"></label>
                                                    </div>
                                                </th>
                                                <th><i class="uil uil-star text-muted"></i></th>
                                                <td>امی لوسر</td>
                                                <td><p class="text-muted mb-0"> در یک ساعت آزاد ، زمانی که قدرت انتخاب ما از بین نرفته و هیچ چیز مانع توانایی انجام ما نمی شود. </p></td>
                                                <td class="text-end"><small>17 اسفند 1400</small></td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input class="form-check-input check" type="checkbox" value="" id="checkbox17">
                                                        <label class="form-check-label" for="checkbox17"></label>
                                                    </div>
                                                </th>
                                                <th><i class="uil uil-star text-muted"></i></th>
                                                <td>تامیکا ویتهود</td>
                                                <td><p class="text-muted mb-0"> بنابراین انسان دانا همیشه در رعایت این اصل انتخاب گام برمی دارد. </p></td>
                                                <td class="text-end"><small>27 اسفند 1400</small></td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input class="form-check-input check" type="checkbox" value="" id="checkbox18">
                                                        <label class="form-check-label" for="checkbox18"></label>
                                                    </div>
                                                </th>
                                                <th><i class="uil uil-star text-muted"></i></th>
                                                <td>باربارا بیانس</td>
                                                <td><p class="text-muted mb-0"> ما با صالح تقبیح می کنیم </p></td>
                                                <td class="text-end"><small>21 اسفند 1400</small></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!--end teb pane-->

                                <div class="tab-pane fade bg-white rounded p-4" id="spam" role="tabpanel" aria-labelledby="spam-tab">
                                    <span class="text-muted">Hooray, no spam here!</span>
                                </div><!--end teb pane-->

                                <div class="tab-pane fade bg-white rounded" id="sent" role="tabpanel" aria-labelledby="send-tab">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-email table-center table-nowrap">
                                            <thead>
                                            <tr>
                                                <th class="border-bottom py-3" style="min-width: 15px;" scope="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input check" type="checkbox" value="" id="checkAll2">
                                                        <label class="form-check-label fw-normal" for="checkAll2"></label>
                                                    </div>
                                                </th>
                                                <th class="border-bottom py-3" style="min-width: 15px;" scope="col">
                                                    <a href="#" class="text-muted"><i class="uil uil-redo"></i></a>
                                                </th>
                                                <th class="border-bottom py-3" style="min-width: 150px;" scope="col"></th>
                                                <th class="border-bottom py-3" style="min-width: 750px;" scope="col"></th>
                                                <th class="border-bottom py-3 text-end" style="min-width: 150px;" scope="col">
                                                    <a href="#" class="btn btn-icon btn-sm btn-pills btn-soft-light"><i class="uil uil-angle-left icons"></i></a>
                                                    <a href="#" class="btn btn-icon btn-sm btn-pills btn-soft-light"><i class="uil uil-angle-right icons"></i></a>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input class="form-check-input check" type="checkbox" value="" id="checkbox19">
                                                        <label class="form-check-label" for="checkbox19"></label>
                                                    </div>
                                                </th>
                                                <th><i class="uil uil-star text-muted"></i></th>
                                                <td>امی لوسر</td>
                                                <td><p class="text-muted mb-0"> در یک ساعت آزاد ، زمانی که قدرت انتخاب ما از بین نرفته و هیچ چیز مانع توانایی انجام ما نمی شود. </p></td>
                                                <td class="text-end"><small>17 اسفند 1400</small></td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input class="form-check-input check" type="checkbox" value="" id="checkbox20">
                                                        <label class="form-check-label" for="checkbox20"></label>
                                                    </div>
                                                </th>
                                                <th><i class="uil uil-star text-muted"></i></th>
                                                <td>تامیکا ویتهود</td>
                                                <td><p class="text-muted mb-0"> بنابراین انسان دانا همیشه در رعایت این اصل انتخاب گام برمی دارد. </p></td>
                                                <td class="text-end"><small>27 اسفند 1400</small></td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input class="form-check-input check" type="checkbox" value="" id="checkbox21">
                                                        <label class="form-check-label" for="checkbox21"></label>
                                                    </div>
                                                </th>
                                                <th><i class="uil uil-star text-muted"></i></th>
                                                <td>باربارا بیانس</td>
                                                <td><p class="text-muted mb-0"> ما با صالح تقبیح می کنیم </p></td>
                                                <td class="text-end"><small>21 اسفند 1400</small></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!--end teb pane-->

                                <div class="tab-pane fade bg-white rounded p-4" id="drafts" role="tabpanel" aria-labelledby="drafts-tab">
                                    <span class="text-muted">You don't have any saved drafts. Saving a draft allows you to keep a message you aren't ready to send yet.</span>
                                </div><!--end teb pane-->

                                <div class="tab-pane fade bg-white rounded p-4" id="delete" role="tabpanel" aria-labelledby="delete-tab">
                                    <span class="text-muted">No conversations in Trash.</span>
                                </div><!--end teb pane-->

                                <div class="tab-pane fade bg-white rounded p-4" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                                    <span class="text-muted">No notes in Notes</span>
                                </div><!--end teb pane-->
                            </div>
                        </div>
                    </div><!--end row-->
                </div>
            </div>
        </div><!--end container-->
        <!-- Footer Start -->
        <footer class="bg-white shadow py-3">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-sm-start text-center">
                            <p class="mb-0 text-muted">1402© سامانه سرویس ایمیل دوماس میل. Design By <i class="mdi mdi-heart text-danger"></i> <a href="http://ali-molaei.ir/" target="_blank" class="text-reset">Ali Molaei</a>.</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </footer><!--end footer-->
        <!-- End -->
    </main>
    <!--End page-content" -->
</div>
<!-- page-wrapper -->

<!-- Offcanvas Start -->
<div class="offcanvas offcanvas-end bg-white shadow" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header p-4 border-bottom">
        <h5 id="offcanvasRightLabel" class="mb-0">
            <img src="{{asset('assets/images/logo-dark.png')}}" height="24" class="light-version" alt="">
            <img src="{{asset('assets/images/logo-light.png')}}" height="24" class="dark-version" alt="">
        </h5>
        <button type="button" class="btn-close d-flex align-items-center text-dark" data-bs-dismiss="offcanvas" aria-label="Close"><i class="uil uil-times fs-4"></i></button>
    </div>
    <div class="offcanvas-body p-4 px-md-5">
        <div class="row">
            <div class="col-12">
                <!-- Style switcher -->
                <div id="style-switcher">
                    <div>
                        <ul class="text-center list-unstyled mb-0">
                            <li class="d-grid"><a href="javascript:void(0)" class="rtl-version t-rtl-light" onclick="setTheme('style-rtl')"><img src="{{asset('assets/images/layouts/light-dash-rtl.png')}}" class="img-fluid rounded-md shadow-md d-block" alt=""><span class="text-muted mt-2 d-block">راست چین</span></a></li>
                            <li class="d-grid"><a href="javascript:void(0)" class="dark-rtl-version t-rtl-dark" onclick="setTheme('style-dark-rtl')"><img src="{{asset('assets/images/layouts/dark-dash-rtl.png')}}" class="img-fluid rounded-md shadow-md d-block" alt=""><span class="text-muted mt-2 d-block">راست چین</span></a></li>
                            <li class="d-grid"><a href="javascript:void(0)" class="dark-version t-dark mt-4" onclick="setTheme('style-dark-rtl')"><img src="{{asset('assets/images/layouts/dark-dash-rtl.png')}}" class="img-fluid rounded-md shadow-md d-block" alt=""><span class="text-muted mt-2 d-block">حالت تاریک</span></a></li>
                            <li class="d-grid"><a href="javascript:void(0)" class="light-version t-light mt-4" onclick="setTheme('style-rtl')"><img src="{{asset('assets/images/layouts/light-dash-rtl.png')}}" class="img-fluid rounded-md shadow-md d-block" alt=""><span class="text-muted mt-2 d-block">حالت روشن</span></a></li>
                            <li class="d-grid"><a href="{{url('/')}}" target="_blank" class="mt-4"><img src="{{asset('assets/images/layouts/landing-light-rtl.png')}}" class="img-fluid rounded-md shadow-md d-block" alt=""><span class="text-muted mt-2 d-block">صفحات لندینگ</span></a></li>
                        </ul>
                    </div>
                </div>
                <!-- end Style switcher -->
            </div><!--end col-->
        </div><!--end row-->
    </div>

    <div class="offcanvas-footer p-4 border-top text-center">
        <ul class="list-unstyled social-icon mb-0">
            <li class="list-inline-item mb-0"><a href="https://www.rtl-theme.com/doctris-html-template" target="_blank" class="rounded"><i class="uil uil-shopping-cart align-middle" title="خرید"></i></a></li>
            <li class="list-inline-item mb-0"><a href=" " target="_blank" class="rounded"><i class="uil uil-dribbble align-middle" title="dribbble"></i></a></li>
            <li class="list-inline-item mb-0"><a href="https://www.rtl-theme.com/author/afaridteam/" target="_blank" class="rounded"><i class="uil uil-facebook-f align-middle" title="facebook"></i></a></li>
            <li class="list-inline-item mb-0"><a href="https://www.rtl-theme.com/author/afaridteam/" target="_blank" class="rounded"><i class="uil uil-instagram align-middle" title="instagram"></i></a></li>
            <li class="list-inline-item mb-0"><a href="https://www.rtl-theme.com/author/afaridteam/" target="_blank" class="rounded"><i class="uil uil-twitter align-middle" title="twitter"></i></a></li>
            <li class="list-inline-item mb-0"><a href="https://www.rtl-theme.com/author/afaridteam/" class="rounded"><i class="uil uil-envelope align-middle" title="email"></i></a></li>
            <li class="list-inline-item mb-0"><a href=" " target="_blank" class="rounded"><i class="uil uil-globe align-middle" title="website"></i></a></li>
        </ul><!--end icon-->
    </div>
</div>
<!-- Offcanvas End -->

<!-- Compose Mail Start -->
<div class="modal fade" id="compose-mail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom p-3">
                <h5 class="modal-title" id="exampleModalLabel">ارسال ایمیل</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-4">
                <form action="{{route('send.mail')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="به" name="to">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="موضوع" name="subject">
                            </div>
                        </div>


                        <div class="col-12">
                            <textarea class="tinymce-editor" name="message">متن پیام</textarea>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary">ارسال</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Compose Mail End -->

<!-- javascript -->
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<!-- simplebar -->
<script src="{{asset('assets/js/simplebar.min.js')}}"></script>
<!-- Icons -->
<script src="{{asset('assets/js/feather.min.js')}}"></script>
<!-- CK editor -->
<script src="{{asset('assets/js/feather.min.js')}}"></script>
<!-- Main Js -->
<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{asset('js/tinymce.min.js')}}"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea.tinymce-editor',
        height: 300,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount', 'image'
        ],
        toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_css: '//www.tiny.cloud/css/codepen.min.css'
    });
</script>
</body>

</html>
