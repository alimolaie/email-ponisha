if (typeof jQuery === 'undefined') { throw new Error('Images loader requires jQuery') }

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

function base64ToArrayBuffer(base64) {

    var binary_string = window.atob(base64);
    var len = binary_string.length;
    var bytes = new Uint8Array(len);

    for (var i = 0; i < len; i++)
        bytes[i] = binary_string.charCodeAt(i);

    return bytes.buffer;
}

function arrayBufferToBase64(buffer) {

    var binary = '';
    var bytes = new Uint8Array(buffer);
    var len = bytes.byteLength;

    for (var i = 0; i < len; i++)
        binary += String.fromCharCode(bytes[i]);

    return window.btoa(binary);
}

function getOrientation(src) {

    var view = new DataView(src);

    if (view.getUint16(0, false) != 0xFFD8)
        return -2;

    var length = view.byteLength;
    var offset = 2;

    while (offset < length) {

        if (view.getUint16(offset + 2, false) <= 8)
            -
            1;

        var marker = view.getUint16(offset, false);
        offset += 2;

        if (marker == 0xFFE1) {

            if (view.getUint32(offset += 2, false) != 0x45786966)
                return -1;

            var little = view.getUint16(offset += 6, false) == 0x4949;
            offset += view.getUint32(offset + 4, little);

            var tags = view.getUint16(offset, little);
            offset += 2;

            for (var i = 0; i < tags; i++)
                if (view.getUint16(offset + (i * 12), little) == 0x0112)
                    return view.getUint16(offset + (i * 12) + 8, little);
        } else if ((marker & 0xFF00) != 0xFF00) {
            break;
        } else
            offset += view.getUint16(offset, false);
    }

    return -1;
}

function imageToFormat(img, maxWidth = null, maxHeight = null, imgType = 'image/jpeg', quality = .9, orientation = -1) {

    var canvas = document.createElement("canvas");

    var width = img.width;
    var height = img.height;

    if (img.width > maxWidth)
        width = maxWidth;

    if (img.height > maxHeight)
        height = maxWidth;


    canvas.width = img.width;
    canvas.height = img.height;

    if (orientation >= 5 && orientation <= 8) {
        canvas.width = img.height;
        canvas.height = img.width;
    }


    var scaleX = width / img.width;
    var scaleY = height / img.height;
    var scale = 1;

    if (scaleX < scale)
        scale = scaleX;

    if (scaleY < scale)
        scale = scaleY;


    canvas.width *= scale;
    canvas.height *= scale;

    var ctx = canvas.getContext("2d");
    ctx.scale(scale, scale);


    switch (orientation) {

        case 1:
            ctx.transform(1, 0, 0, 1, 0, 0);
            break;
        case 2:
            ctx.transform(-1, 0, 0, 1, img.width, 0);
            break;
        case 3:
            ctx.transform(-1, 0, 0, -1, img.width, img.height);
            break;
        case 4:
            ctx.transform(1, 0, 0, -1, 0, img.height);
            break;
        case 5:
            ctx.transform(0, 1, 1, 0, 0, 0);
            break;
        case 6:
            ctx.transform(0, 1, -1, 0, img.height, 0);
            break;
        case 7:
            ctx.transform(0, -1, -1, 0, img.height, img.width);
            break;
        case 8:
            ctx.transform(0, -1, 1, 0, 0, img.width);
            break;

        default:
            break;
    }

    ctx.drawImage(img, 0, 0);

    return canvas.toDataURL(imgType, quality);
}


$.fn.imageToFormat = function() {

    return this.each(function() {

        this.src = imageToFormat(this);
    });
}


function drawRotated(img, degree) {

    var canvas = document.createElement("canvas");
    var cContext = canvas.getContext('2d');
    var cw = img.width,
        ch = img.height,
        cx = 0,
        cy = 0;

    switch (degree) {

        case -90:
            cw = img.height;
            ch = img.width;
            cx = img.width * (-1);
            break;
        case 90:
            cw = img.height;
            ch = img.width;
            cy = img.height * (-1);
            break;
        case 180:
            cx = img.width * (-1);
            cy = img.height * (-1);
            break;
        case 270:
            cw = img.height;
            ch = img.width;
            cx = img.width * (-1);
            break;
    }


    canvas.setAttribute('width', cw);
    canvas.setAttribute('height', ch);
    cContext.rotate(degree * Math.PI / 180);
    cContext.drawImage(img, cx, cy);

    return canvas.toDataURL();
}



+

function($) {
    "use strict";

    var ImagesLoader = function(name, element, options) {

        this.name = name;
        this.element = element;
        this.$element = $(element);
        this.inProgress = false;

        var iconBasePath = this.path() + "img/";
        this.options = $.extend({ iconBasePath: iconBasePath }, ImagesLoader.DEFAULTS, options, this.$element.data());

        this.enabled = true;

        this.init();
    };

    ImagesLoader.DEFAULTS = {

        fadeTime: 'slow',
        inputID: 'files',
        maxfiles: 5,
        maxSize: 5000 * 1024 // Kb
            ,
        minSelect: 1,
        imagesToLoad: null,
        filesType: ["image/jpeg", "image/png", "image/gif"],
        maxWidth: 1280 // pixel
            ,
        maxHeight: 1024,
        imgType: "image/jpeg",
        imgQuality: .9,
        errorformat: "Accepted format",
        errorsize: "Max size allowed",
        errorduplicate: "File already uploaded",
        errormaxfiles: "Max images you can upload",
        errorminfiles: "Minimum number of images to upload",
        modifyimagetext: "Modify image",
        rotation: 90
    };

    ImagesLoader.prototype.fullPath = function() {

        return $("script[src*='" + imagesloader_fileName + "']").attr('src');
    }


    ImagesLoader.prototype.path = function() {

        var fullPath = this.fullPath();
        return fullPath.substr(0, fullPath.lastIndexOf("/") + 1);
    }

    ImagesLoader.prototype.fileName = function() {
        var fullPath = this.fullPath();
        return fullPath.substr(fullPath.lastIndexOf("/") + 1, fullPath.length);
    }

    ImagesLoader.prototype.btnAddClick = function(evt, obj) {

        var self = this;
        var element = self.element;
        var $element = $(element);
        var options = self.options;

        self.$files.click();
    }

    ImagesLoader.prototype.btnChangeClick = function(evt, obj) {

        var self = this;
        var element = self.element;
        var $element = $(element);
        var options = self.options;

        if (!evt.target.files)
            return;

        var files = evt.target.files;


        var filesLength = self.AttachmentArray.length + evt.target.files.length;

        self.$progress.hide();

        if (filesLength > options.maxfiles)
            self.ShowProgress(self.barStyle.warning, options.errormaxfiles + ": " + options.maxfiles, 2000);


        var $divLoading = self.$addImage.find('[data-type="loading"]');
        $divLoading.show();

        (function handle(i) {

            if (i >= files.length) {

                self.$files.val('');


                if (self.AttachmentArray.length >= options.maxfiles)
                    self.$addImage.hide();

                $divLoading.hide();
                return;
            }

            let file = files[i];

            if (self.ApplyFileValidationRules(file) == false) {
                handle(++i);
                return;
            }

            self.AttachmentArray.push({
                AttachmentType: 1,
                ObjectType: 1,
                FileName: file.name,
                FileDescription: "Attachment",
                NoteText: '',
                MimeType: file.type,
                Base64: null,
                Orientation: -1,
                FileSizeInBytes: file.size,
                File: file
            });

            var fileReader = new FileReader();

            fileReader.onload = function(e) {

                var main = (self.AttachmentArray.length == 1);

                var idx = self.AttachmentArray.map(function(file) { return file.FileName; }).indexOf(file.name);

                var src = e.target.result;

                var image = new Image();
                image.crossOrigin = "anonymous"; // This enables CORS

                image.onload = function() {

                    var base64 = this.src.split("base64,")[1];
                    var orientation = getOrientation(base64ToArrayBuffer(base64));

                    var src = imageToFormat(this, options.maxWidth, options.maxHeight, options.imgType, options.imgQuality, orientation);
                    self.RenderThumbnail(src, file.name, main);

                    self.AttachmentArray[idx].Base64 = src.split("base64,")[1];
                    self.AttachmentArray[idx].Orientation = orientation;

                    handle(++i);
                };

                image.src = src;
            };

            fileReader.readAsDataURL(file);
        })(0);

    }


    ImagesLoader.prototype.btnRemoveClick = function(evt, obj) {

        var self = this;
        var element = self.element;
        var $element = $(element);
        var options = self.options;


        var $div = $(obj).closest('[data-type="image"]');

        var $buttonPopover = $div.find('[data-type="btn-modify"]');
        $buttonPopover.popover('hide');

        var id = $div.data('id');


        if (self.AttachmentArray.length > 1 && self.AttachmentArray[0].FileName == $div.data('id')) {

            var $nextDiv = $div.next('[data-type="image"]');
            var $noimage = $nextDiv.find('[data-type="noimage"]');

            var $preview = $nextDiv.find('[data-type="preview"]');
            var $btnAdd = $nextDiv.find('[data-type="add"]');
            var $btnModify = $nextDiv.find('[data-type="btn-modify"]');
            var $btnRemove = $nextDiv.find('[data-type="remove"]');
            var $btnMain = $nextDiv.find('[data-type="main"]');
            var $ratioBox = $nextDiv.find('[data-type="image-ratio-box"]');
            var $tag = $ratioBox.find('.main-tag');

            $btnRemove.show();

            $noimage.hide();
            $btnAdd.hide();
            $preview.fadeIn(options.fadeTime);
        }

        var idx = self.AttachmentArray.map(function(file) { return file.FileName; }).indexOf(id);

        if (idx !== -1)
            self.AttachmentArray.splice(idx, 1);

        self.$addImage.fadeOut(options.fadeTime);

        $div.fadeOut(options.fadeTime, function() {

            $div.remove();

            var $divImage = self.$addImage.closest('[data-type="image"]');
            $divImage.attr('data-type', 'noimage');

            self.$addImage.fadeIn(options.fadeTime);
        });

        self.$progress.fadeOut(options.fadeTime);
    };


    ImagesLoader.prototype.btnMainClick = function(evt, obj) {

        var self = this;
        var element = self.element;
        var $element = $(element);
        var options = self.options;

        var $div = $(obj).closest('[data-type="image"]');

        var $preview = $div.find('[data-type="preview"]');
        var $ratioBox = $div.find('[data-type="image-ratio-box"]');
        var $tooltip = $ratioBox.attr('data-original-title');
        var id = $div.attr('data-id');
        var imgSource = $preview.attr('src');


        var $buttonPopover = $div.find('[data-type="btn-modify"]');
        $buttonPopover.popover('hide');


        var main = self.AttachmentArray[0];

        var $divMain = $element.find('[data-id="' + main.FileName + '"]');

        var $previewMain = $divMain.find('[data-type="preview"]');
        var $ratioBoxMain = $divMain.find('[data-type="image-ratio-box"]');
        var $tag = $ratioBoxMain.find('.main-tag');
        var $tooltipMain = $ratioBoxMain.attr('data-original-title');

        var imgSourceMain = $previewMain.attr('src');

        $tag.hide();

        $preview.fadeOut(options.fadeTime, function() {
            $preview.attr('src', imgSourceMain);
        });

        $previewMain.fadeOut(options.fadeTime, function() {
            $previewMain.attr('src', imgSource);
            $tag.show();
        });

        $preview.fadeIn(options.fadeTime);
        $previewMain.fadeIn(options.fadeTime);


        $div.attr('data-id', main.FileName);
        $divMain.attr('data-id', id);


        $ratioBox.attr('data-original-title', $tooltipMain);
        $ratioBoxMain.attr('data-original-title', $tooltip);


        var idx = self.AttachmentArray.map(function(file) { return file.FileName; }).indexOf(id);

        if (idx !== -1) {
            self.AttachmentArray[0] = self.AttachmentArray[idx];
            self.AttachmentArray[idx] = main;
        }
    };

    ImagesLoader.prototype.btnLeftClick = function(evt, obj) {

        var self = this;
        var element = self.element;
        var $element = $(element);
        var options = self.options;


        var $div = $(obj).closest('[data-type="image"]');

        var $preview = $div.find('[data-type="preview"]');
        var $ratioBox = $div.find('[data-type="image-ratio-box"]');
        var $tooltip = $ratioBox.attr('data-original-title');

        var id = $div.attr('data-id');

        var $buttonPopover = $div.find('[data-type="btn-modify"]');
        $buttonPopover.popover('hide');

        var idx = self.AttachmentArray.map(function(file) { return file.FileName; }).indexOf(id);
        var leftImageIdx = idx - 1;
        var leftImage = self.AttachmentArray[leftImageIdx];

        var $divLeft = $element.find('[data-id="' + leftImage.FileName + '"]');
        var $previewLeft = $divLeft.find('[data-type="preview"]');
        var $ratioBoxLeft = $divLeft.find('[data-type="image-ratio-box"]');
        var $tooltipLeft = $ratioBoxLeft.attr('data-original-title');
        var imgSource = "data:image/jpeg;base64," + self.AttachmentArray[idx].Base64;
        var imgSourceLeft = "data:image/jpeg;base64," + leftImage.Base64;

        var $tag = $ratioBoxLeft.find('.main-tag');


        $tag.hide();

        $preview.fadeOut(options.fadeTime, function() {
            $preview.attr('src', imgSourceLeft);
        });

        $previewLeft.fadeOut(options.fadeTime, function() {
            $previewLeft.attr('src', imgSource);

            if (leftImageIdx == 0)
                $tag.show();
        });

        $preview.fadeIn(options.fadeTime);
        $previewLeft.fadeIn(options.fadeTime);

        $ratioBox.attr('data-original-title', $tooltipLeft);
        $ratioBoxLeft.attr('data-original-title', $tooltip);


        $div.attr('data-id', leftImage.FileName);
        $divLeft.attr('data-id', id);

        if (idx !== -1) {
            self.AttachmentArray[leftImageIdx] = self.AttachmentArray[idx];
            self.AttachmentArray[idx] = leftImage;
        }
    };


    ImagesLoader.prototype.btnRightClick = function(evt, obj) {

        var self = this;
        var element = self.element;
        var $element = $(element);
        var options = self.options;


        var $div = $(obj).closest('[data-type="image"]');

        var $preview = $div.find('[data-type="preview"]');
        var $ratioBox = $div.find('[data-type="image-ratio-box"]');
        var $tooltip = $ratioBox.attr('data-original-title');

        var id = $div.attr('data-id');

        var $buttonPopover = $div.find('[data-type="btn-modify"]');
        $buttonPopover.popover('hide');

        var idx = self.AttachmentArray.map(function(file) { return file.FileName; }).indexOf(id);
        var rightImageIdx = idx + 1;
        var rightImage = self.AttachmentArray[rightImageIdx];

        var $divRight = $element.find('[data-id="' + rightImage.FileName + '"]');
        var $previewRight = $divRight.find('[data-type="preview"]');
        var $ratioBoxRight = $divRight.find('[data-type="image-ratio-box"]');
        var $tooltipRight = $ratioBoxRight.attr('data-original-title');
        var imgSource = "data:image/jpeg;base64," + self.AttachmentArray[idx].Base64;
        var imgSourceRight = "data:image/jpeg;base64," + rightImage.Base64;

        var $tag = $ratioBox.find('.main-tag');

        $tag.hide();

        $preview.fadeOut(options.fadeTime, function() {
            $preview.attr('src', imgSourceRight);
        });

        $previewRight.fadeOut(options.fadeTime, function() {
            $previewRight.attr('src', imgSource);
            //$tag.show();
        });

        $preview.fadeIn(options.fadeTime);
        $previewRight.fadeIn(options.fadeTime);


        $ratioBox.attr('data-original-title', $tooltipRight);
        $ratioBoxRight.attr('data-original-title', $tooltip);


        $div.attr('data-id', rightImage.FileName);
        $divRight.attr('data-id', id);

        if (idx !== -1) {
            self.AttachmentArray[rightImageIdx] = self.AttachmentArray[idx];
            self.AttachmentArray[idx] = rightImage;
        }
    };



    ImagesLoader.prototype.btnRotateClick = function(evt, obj) {

        var self = this;
        var options = self.options;
        var element = self.element;
        var $element = $(element);


        var $div = $(obj).closest('[data-type="image"]');
        var $preview = $div.find('[data-type="preview"]');
        var id = $div.attr('data-id');
        var idx = self.AttachmentArray.map(function(file) { return file.FileName; }).indexOf(id);

        var image = new Image();
        image.src = "data:image/jpeg;base64," + self.AttachmentArray[idx].Base64;

        image.onload = function() {

            var src = drawRotated(this, options.rotation);
            var base64 = src.split("base64,")[1];

            $preview.attr('src', src);

            self.AttachmentArray[idx].Base64 = base64;
        }

    };

    ImagesLoader.prototype.ShowProgress = function(style, msg, delay = 0) {

        var self = this;
        var options = self.options;

        if (self.$progress.is(':visible') && self.$progressbar.text() === msg)
            return;

        self.$progressbar.removeClass();

        self.$progressbar.addClass(style.class);
        self.$progressbar.attr('style', style.style);
        self.$progressbar.text(msg);

        self.$progress.hide().fadeIn(options.fadeTime);

        if (delay > 0)
            self.$progress.delay(delay).fadeOut(options.fadeTime);
    }


    ImagesLoader.prototype.execJsFunction = function() {

        var self = this;
        var options = self.options;

        if (this.jsFunction != null)
            eval(this.jsFunction);
    }

    ImagesLoader.prototype.ApplyFileValidationRules = function(readerEvt) {

        var self = this;
        var element = self.element;
        var $element = $(element);
        var options = self.options;

        if (self.CheckFileUnique(readerEvt.name) == false) {
            self.ShowProgress(self.barStyle.danger, options.errorduplicate + " (" + readerEvt.name + ")");
            return false;
        }

        if (self.CheckFileType(readerEvt.type) == false) {
            self.ShowProgress(self.barStyle.danger, options.errorformat + ": " + options.filesType.toString().replaceAll(',', ', ') + " (" + readerEvt.name + ")");
            return false;
        }

        if (self.CheckFileSize(readerEvt.size) == false) {
            self.ShowProgress(self.barStyle.danger, options.errorsize + " " + options.maxSize / 1000 + " Kb (" + readerEvt.name + ")");
            return false;
        }

        if (self.CheckFilesCount() == false)
            return false;

        return true;
    }


    ImagesLoader.prototype.CheckFileType = function(fileType) {

        var self = this;
        var element = self.element;
        var $element = $(element);
        var options = self.options;

        return options.filesType.indexOf(fileType) != -1
    }


    ImagesLoader.prototype.CheckFileSize = function(fileSize) {

        var self = this;
        var element = self.element;
        var $element = $(element);
        var options = self.options;

        return (fileSize < options.maxSize);
    }

    ImagesLoader.prototype.CheckFilesCount = function() {

        var self = this;
        var element = self.element;
        var $element = $(element);
        var options = self.options;


        return (self.AttachmentArray.length < options.maxfiles);
    }

    ImagesLoader.prototype.CheckFileUnique = function(filename) {

        var self = this;
        var element = self.element;
        var $element = $(element);
        var options = self.options;

        for (var i = 0; i < self.AttachmentArray.length; i++)
            if (self.AttachmentArray[i].FileName == filename)
                return false;

        return true;
    }

    ImagesLoader.prototype.CheckValidity = function() {

        var self = this;
        var element = self.element;
        var $element = $(element);
        var options = self.options;
        var retVal = true;

        if (self.AttachmentArray.length < options.minSelect) {

            self.ShowProgress(self.barStyle.danger, options.errorminfiles + ": " + options.minSelect);
            retVal = false;
        }

        return retVal;
    }

    ImagesLoader.prototype.LoadImages = function() {

        var self = this;
        var element = self.element;
        var $element = $(element);
        var options = self.options;

        (function handle(i) {

            if (i >= self.imagesToLoad.length)
                return;

            var url = self.imagesToLoad[i].Url;
            var name = url.substring(url.lastIndexOf('/') + 1);

            var main = (i == 0);

            var name = escape(url.substring(url.lastIndexOf('/') + 1));

            var image = new Image();
            image.crossOrigin = "anonymous"; // This enables CORS
            image.onload = function() {

                var src = imageToFormat(this, options.maxWidth, options.maxHeight, options.imgType, options.imgQuality);
                var base64 = src.split("base64,")[1];

                self.AttachmentArray.push({
                    AttachmentType: 1,
                    ObjectType: 1,
                    FileName: name,
                    FileDescription: "Attachment",
                    NoteText: '',
                    MimeType: options.imgType,
                    Base64: base64,
                    FileSizeInBytes: base64.length,
                    File: null
                });

                self.RenderThumbnail(url, name, main, true);

                handle(++i);
            };

            image.src = url;

        })(0);
    }

    ImagesLoader.prototype.RenderThumbnail = function(src, name, main = false, reload = false) {

        var self = this;
        var element = self.element;
        var $element = $(element);
        var options = self.options;

        var $div = self.$model.clone(true, true);
        $div.attr('data-type', 'image');
        $div.attr('data-id', name);

        var $noimage = $div.find('[data-type="noimage"]');

        var $preview = $div.find('[data-type="preview"]');
        $preview.attr('src', src);

        var $btnAdd = $div.find('[data-type="add"]');
        let $btnModify = $div.find('[data-type="btn-modify"]');
        var $btnRemove = $div.find('[data-type="remove"]');
        var $btnMain = $div.find('[data-type="main"]');
        var $btnLeft = $div.find('[data-type="left"]');
        var $btnRight = $div.find('[data-type="right"]');
        var $ratioBox = $div.find('[data-type="image-ratio-box"]');

        $ratioBox.attr('data-toggle', 'tooltip');
        $ratioBox.attr('data-placement', 'top');

        if (reload)
            $ratioBox.attr('title', src.substring(src.indexOf('_') + 1));
        else
            $ratioBox.attr('title', decodeURI(name));

        if (main) {

            var $tag = $ratioBox.find('.main-tag');
            $tag.show();

        }

        $btnModify.fadeIn(options.fadeTime);

        $btnModify.popover({

            html: true,
            trigger: "manual",
            title: function() {
                return "<p class='m-0 p-0' style='text-align:center'>" + options.modifyimagetext + "</p>";
            },
            content: function() {

                var popoverContent = $element.find('[data-type="popover"]').first().clone(true, true);

                var id = $btnModify.closest('[data-type="image"]').attr('data-id');
                var idx = self.AttachmentArray.map(function(file) { return file.FileName; }).indexOf(id);

                if (idx == 0) {

                    $(popoverContent).find('[data-operation="left"]').addClass('disabled');
                    $(popoverContent).find('[data-operation="left"]').css('cursor', 'default');
                    $(popoverContent).find('[data-operation="left"]').removeAttr('data-operation');
                    $(popoverContent).find('[data-operation="main"]').addClass('disabled');
                    $(popoverContent).find('[data-operation="main"]').css('cursor', 'default');
                    $(popoverContent).find('[data-operation="main"]').removeAttr('data-operation');
                }

                if (idx == self.AttachmentArray.length - 1) {

                    $(popoverContent).find('[data-operation="right"]').addClass('disabled');
                    $(popoverContent).find('[data-operation="right"]').css('cursor', 'default');
                    $(popoverContent).find('[data-operation="right"]').removeAttr('data-operation');
                }

                $(popoverContent).find('[data-operation]').click(function() {
                    $btnModify.parent().trigger($(this).data('operation'));
                });

                return popoverContent;
            }
        }).on("click", function() {

            $element.find('[data-toggle=popover]').not(this).popover('hide');

            var self = this;
            var $self = $(self);

            $self.popover("show");

            $(".popover").on("mouseleave", function() {
                $self.popover('hide');
            });
        });

        $ratioBox.tooltip();

        $noimage.hide();
        $btnAdd.hide();

        $div.insertBefore(self.$addImage);
        $div.show();

        $preview.fadeIn(options.fadeTime);

        return $div;
    }


    ImagesLoader.prototype.hideTooltip = function() {

        var self = this;
        var options = self.options;

        self.$element.find('[data-toggle="tooltip"]').tooltip('hide');
    }

    ImagesLoader.prototype.initTooltip = function(obj) {

        var self = this;
        var options = self.options;
        var $obj = $(obj);

        $obj.find('[data-toggle="tooltip"]').tooltip({
            delay: { show: 200, hide: 0 },
            trigger: "hover"
        });
    }


    ImagesLoader.prototype.init = function() {

        var self = this;
        var options = this.options;
        var element = this.element;
        var $element = $(element);

        this.AttachmentArray = [];

        this.jsFunction = options.jsFunction;

        this.$model = $element.find('[data-type="image-model"]');

        this.$model.bind('remove', (function(evt) { self.btnRemoveClick(evt, this); }));
        this.$model.bind('main', (function(evt) { self.btnMainClick(evt, this); }));
        this.$model.bind('left', (function(evt) { self.btnLeftClick(evt, this); }));
        this.$model.bind('right', (function(evt) { self.btnRightClick(evt, this); }));
        this.$model.bind('rotateclockwise', (function(evt) {

            options.rotation = 90;
            self.btnRotateClick(evt, this);
        }));
        this.$model.bind('rotateanticlockwise', (function(evt) {

            options.rotation = -90;
            self.btnRotateClick(evt, this);
        }));

        this.$btnAdd = $element.find('[data-type="add"]');
        this.$btnAdd.click(function(evt) { self.btnAddClick(evt, this); });

        this.$noImage = $element.find('[data-type="noimage"]');
        this.$noImage.click(function(evt) { self.btnAddClick(evt, this); });

        this.$btnRemove = $element.find('[data-type="remove"]');
        this.$btnRemove.click(function(evt) { self.btnRemoveClick(evt, this); });

        this.imagesToLoad = options.imagesToLoad;

        this.$files = $('#' + options.inputID);
        this.$files.bind('change', (function(evt) { self.btnChangeClick(evt, this); }));

        this.$progress = $element.find('[data-type="progress"]').first();
        this.$progressbar = $element.find('[data-type="progressBar"]').first();

        this.barStyle = {
            successStriped: { class: 'progress-bar progress-bar-striped progress-bar-animated bg-success', style: 'width: 100%' },
            warning: { class: 'progress-bar progress-bar-striped progress-bar-animated bg-warning', style: 'width: 100%; color: #5a5a5a' },
            success: { class: 'progress-bar bg-success', style: 'width: 100%' },
            danger: { class: 'progress-bar bg-danger', style: 'width: 100%' }
        };

        this.$addImage = this.$model.clone(true, true);
        this.$addImage.attr('data-type', 'image-add');
        this.$addImage.appendTo($element);

        if (this.imagesToLoad != null)
            this.LoadImages();

        if (this.imagesToLoad == null || this.imagesToLoad.length < this.options.maxfiles)
            this.$addImage.show();
    }


    var imagesloader_version = '1.0.1';
    var imagesloader_pluginName = 'format.imagesloader';
    var imagesloader_fileName = "jquery.imagesloader";

    var old = $.fn.imagesloader;

    $.fn.imagesloader = function(option) {

        $.fn.imagesloader.loadCSS();

        return this.each(function() {

            var $this = $(this)
            var data = $this.data(imagesloader_pluginName)
            var options = typeof option == 'object' && option

            if (!data) {
                if (option == 'destroy') return
                this.plugin = new ImagesLoader(imagesloader_pluginName, this, options)
                $this.data(imagesloader_pluginName, this.plugin)
            }

            if (typeof option == 'string') data[option]()
        })
    }

    $.fn.imagesloader.loadCSS = function() {

        var href = $("script[src*='" + imagesloader_fileName + "']").attr('src').split("-")[0];

        if ($("link[href*='" + imagesloader_fileName + "']").length == 0) {
            var css = $("<link rel='stylesheet' type='text/css' href='" + href + ".css'>");
            $("head").append(css);
        }
    };

    $.fn.imagesloader.Constructor = ImagesLoader

    $.fn.imagesloader.noConflict = function() {
        $.fn.imagesloader = old
        return this
    }

}(jQuery);