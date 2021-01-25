$(function () {

    let index = 0;
    let input = $("input#news-files");
    input.fileinput({
        language: 'no',
        uploadUrl: "/file-upload-batch/1",
        showUpload: false,
        uploadAsync: false,
        overwriteInitial: false,
        initialPreview: input.data("initialpreview"),
        initialPreviewConfig: input.data("initialpreviewconfig"),
        purifyHtml: true,
        initialPreviewAsData: true,
        maxFileSize: 102400, //100 Mb
        msgSizeTooLarge: 'Filen "{name}" (<b>{size} KB</b>) overskrider maksimal tillatt opplastningsstørrelse på <b>100 MiB</b>.',
        previewFileIconSettings: { // configure your icon file extensions
            'doc': '<i class="fas fa-file-word text-primary"></i>',
            'xls': '<i class="fas fa-file-excel text-success"></i>',
            'ppt': '<i class="fas fa-file-powerpoint text-danger"></i>',
            'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
            'zip': '<i class="fas fa-file-archive text2muted fa-2x"></i>',
            'rar': '<i class="fas fa-file-archive text2muted fa-2x"></i>',
            'htm': '<i class="fas fa-file-code text-info"></i>',
            'txt': '<i class="fas fa-file-alt text-info"></i>',
            'mov': '<i class="fas fa-file-video text-warning"></i>',
            'mp3': '<i class="fas fa-file-audio text-warning"></i>',
            // note for these file types below no extension determination logic
            // has been configured (the keys itself will be used as extensions)
            'jpg': '<i class="fas fa-file-image text-danger"></i>',
            'gif': '<i class="fas fa-file-image text-muted"></i>',
            'png': '<i class="fas fa-file-image text-primary"></i>'
        },
    })
        .ready(function () {
            addInput();
        })
        .on("fileloaded", function (event, file, previewId, index, reader) {
            addInput();
        })
        .on('fileuploaderror', function (event, data, msg) {
            $(document).find("div.file-preview-error").remove();
        });


    function addInput() {
        $(document).find("div.file-preview-thumbnails.clearfix")
            .find("div.file-preview-frame.krajee-default.kv-preview-thumb:not(.data-index)")
            .each(function () {
                $(this).attr("data-index", index).addClass("data-index")
                    .find("div.file-footer-caption")
                    .prepend($("<input>", {
                        type: "text",
                        class: "kv-input kv-init form-control input-sm form-control-sm text-center mt-2",
                        placeholder: "Enter description",
                        name: "file_desc[]",
                        value: function () {
                            return input.data("initialpreviewconfig")[index] !== undefined ? input.data("initialpreviewconfig")[index]["description"] : "";
                        }
                    })).parent().find("span.file-drag-handle.drag-handle-init.text-info").remove();
                index += 1;
            });
    }


    $("form#news-form").submit(function (e) {
        // e.preventDefault();
        let input = $("input#news-files");
        let fileManager = input.data("fileinput").fileManager;
        let files = [];

        let loadedStack = fileManager.stack;
        for (let key in loadedStack) {
            files.push(loadedStack[key].file);
        }

        input[0].files = new FileListItem(files);
    });

    // Used for creating a new FileList in a round-about way
    function FileListItem(a) {
        a = [].slice.call(Array.isArray(a) ? a : arguments)
        for (var c, b = c = a.length, d = !0; b-- && d;) d = a[b] instanceof File
        if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
        for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(a[c])
        return b.files
    }

});


