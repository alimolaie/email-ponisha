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
                        <div class="col-12">
                            <br>

                            <label for="attachment" class="text-danger">ضمیمه(اختیاری)</label>
                            <br>
                            <br>

                            <input type="file" class="form-control-file" name="attachment[]" multiple/>

                            {{--
                                                        <div class="row" data-type="imagesloader" data-errorformat="Accepted file formats" data-errorsize="Maximum size accepted" data-errorduplicate="File already loaded" data-errormaxfiles="Maximum number of images you can upload" data-errorminfiles="Minimum number of images to upload"
                                                        data-modifyimagetext="ویرایش عکس">
                                                        <!-- <div class="col-12 order-1 mt-2">
                                                            <div data-type="progress" class="progress" style="height: 25px; display:none;">
                                                                <div data-type="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%;">Load in progress...</div>
                                                            </div>
                                                        </div> -->
                                                        <div data-type="image-model" class="col-4 pl-2 pr-2 pt-2" style="max-width:150px; display:none;">
                                                            <div class="ratio-box text-center" data-type="image-ratio-box">
                                                                <img data-type="noimage" class="btn btn-light ratio-img img-fluid p-2 image border dashed rounded" src="./img/photo-camera-gray.svg" style="cursor:pointer;">
                                                                <div data-type="loading" class="img-loading" style="color:#ffaa0f; display:none;">
                                                                    <span class="fa fa-2x fa-spin fa-spinner"></span>
                                                                </div>
                                                                <img data-type="preview" class="btn btn-light ratio-img img-fluid p-2 image border dashed rounded" src="" style="display: none; cursor: default;">
                                                                <!-- <span class="badge badge-pill badge-success p-2 w-50 main-tag" style="display:none;">Main</span> -->
                                                            </div>
                                                            <div data-type="image-buttons" class="row justify-content-center mt-2">
                                                                <button data-type="add" class="btn btnupld " type="button"><i class="fa fa-camera fupld " ></i><i class="fa fa-plus fupld2 " ></i></button>
                                                                <button data-type="btn-modify" type="button" class="btn btnupld m-0" data-toggle="popover" data-placement="right" style="display:none;">
                                                                  <i class="fa fa-pencil"></i></button>
                                                            </div>
                                                        </div>
                                                        <div data-type="popover-model" style="display:none">
                                                            <div data-type="popover" class="ml-3 mr-3" style="min-width:90px;">
                                                                <div class="row mt-2">
                                                                    <div class="col-6 p-0 pr-1">
                                                                        <button data-operation="left" class="btn btn-block  btnupld1 btn-sm rounded-pill" type="button"><span class="fa fa-angle-left mr-2"></span>چپ</button>
                                                                    </div>
                                                                    <div class="col-6 p-0 pl-1">
                                                                        <button data-operation="right" class="btn btn-block btnupld1 btn-sm rounded-pill" type="button">راست<span class="fa fa-angle-right ml-2"></span></button>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col-6 p-0 pr-1">
                                                                        <button data-operation="rotateanticlockwise" class="btn btn-block btnupld2 btn-sm rounded-pill" type="button"><span class="fas fa-undo-alt mr-2"></span>چرخش</button>
                                                                    </div>
                                                                    <div class="col-6 p-0 pl-1">
                                                                        <button data-operation="rotateclockwise" class="btn btn-block btnupld2 btn-sm rounded-pill" type="button">چرخش<span class="fas fa-redo-alt ml-2"></span></button>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <button data-operation="remove" class="btn btn-outline-danger btn-sm btn-block" type="button"><i class="fa fa-trash" style="font-size:25px"></i></button>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                            {{-- </div> --}}
                            {{-- <div class="form-group row">
                                <div class="input-group">
                                    <input id="files" type="file" name="files[]" data-button="" multiple="" accept="image/jpeg, image/png, image/gif," style="display:none;">
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary">ارسال</button>
                        </div>

                </form>
            </div>
        </div>
    </div>
</div>
