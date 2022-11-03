<script src="{{ asset('vendor/webkul/admin/assets/js/tinyMCE/tinymce.min.js') }}"></script>

<script>
    let tinyMCEHelper = {
        initTinyMCE: function (extraConfiguration) {
            let self = this;

            let config = {
                relative_urls : false,
                remove_script_host : false,
                document_base_url : '{{ asset('/') }}',
                uploadRoute: '{{ route('admin.tinymce.upload') }}',
                csrfToken: '{{ csrf_token() }}',
                fontsize_formats: "12px 14px 16px 18px 20px 24px 26px 28px 30px 32px 34px 36px 40px 52px",               
                plugins: 'directionality emoticons lists image  media wordcount save fullscreen code table lists link      insertdatetime searchreplace  visualblocks ',               
                toolbar1: 'formatselect | fontsizeselect | bold italic strikethrough | forecolor backcolor | emoticons | ltr rtl | alignleft aligncenter alignright alignjustify |  numlist bullist outdent indent   | code ',
                image_advtab: true,
                textcolor_rows: "10",
                height: 400,
                textcolor_map: [
                    "000000", "Black",
                    "993300", "Burnt orange",
                    "333300", "Dark olive",
                    "003300", "Dark green",
                    "003366", "Dark azure",
                    "000080", "Navy Blue",
                    "333399", "Indigo",
                    "333333", "Very dark gray",
                    "800000", "Maroon",
                    "FF6600", "Orange",
                    "808000", "Olive",
                    "008000", "Green",
                    "008080", "Teal",
                    "0000FF", "Blue",
                    "666699", "Grayish blue",
                    "808080", "Gray",
                    "FF0000", "Red",
                    "FF9900", "Amber",
                    "99CC00", "Yellow green",
                    "339966", "Sea green",
                    "33CCCC", "Turquoise",
                    "3366FF", "Royal blue",
                    "800080", "Purple",
                    "999999", "Medium gray",
                    "FF00FF", "Magenta",
                    "FFCC00", "Gold",
                    "FFFF00", "Yellow",
                    "00FF00", "Lime",
                    "00FFFF", "Aqua",
                    "00CCFF", "Sky blue",
                    "993366", "Red violet",
                    "FFFFFF", "White",
                    "FF99CC", "Pink",
                    "FFCC99", "Peach",
                    "FFFF99", "Light yellow",
                    "CCFFCC", "Pale green",
                    "CCFFFF", "Pale cyan",
                    "99CCFF", "Light sky blue",
                    "CC99FF", "Plum",
                    "4d2379","Main Color",
                    "e83c7b","Secondary Color",
                    "ffe000","Yellow Color"

                ],
                color_picker_callback: function(callback, value) {
                    callback('#FF00FF');
                },
                ...extraConfiguration,

                // imagetools hr textcolor colorpicker fullpage spellchecker
            };

            tinymce.init({
                ...config,

                file_picker_callback: function(cb, value, meta) {
                    self.filePickerCallback(config, cb, value, meta);
                },

                images_upload_handler: function (blobInfo, success, failure, progress) {
                    self.uploadImageHandler(config, blobInfo, success, failure, progress);
                },
            });
        },

        filePickerCallback: function(config, cb, value, meta) {
            let input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function() {
                let file = this.files[0];

                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    let id = 'blobid' + (new Date()).getTime();
                    let blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    let base64 = reader.result.split(',')[1];
                    let blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), {title: file.name});
                };
            };
            input.click();
        },

        uploadImageHandler: function(config, blobInfo, success, failure, progress) {
            let xhr, formData;

            xhr = new XMLHttpRequest();

            xhr.withCredentials = false;

            xhr.open('POST', config.uploadRoute);

            xhr.upload.onprogress = function (e) {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = function() {
                let json;

                if (xhr.status === 403) {
                    failure('{{ __('admin::app.error.tinymce.http-error') }}', { remove: true });
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    failure('{{ __('admin::app.error.tinymce.http-error') }}');
                    return;
                }

                json = JSON.parse(xhr.responseText);

                if (! json || typeof json.location != 'string') {
                    failure('{{ __('admin::app.error.tinymce.invalid-json') }} ' + xhr.responseText);
                    return;
                }

                success(json.location);
            };

            xhr.onerror = function () {
                failure('{{ __('admin::app.error.tinymce.upload-failed') }}');
            };

            formData = new FormData();
            formData.append('_token', config.csrfToken);
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        }
    };
</script>