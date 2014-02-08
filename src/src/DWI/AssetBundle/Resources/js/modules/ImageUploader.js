/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

/**
 * Image Uploader
 */
;(function(window, $, undefined) {

    "use strict";

    var ImageUploader = function(am) {
        var that = this;


        /**
         * Options & Default Objects
         *
         * @type Object
         */
        this.options  = {};
        this.defaults = {
            CSRFToken: {
                name: '',
                value: '',
            },
            engine: Handlebars,
            fileField: '',
            cancelUrl: '',
            uploadUrl: '/',
        };


        /**
         * Elements handled by ImageUploader
         *
         * @type Object
         */
        this.elements = {};


        /**
         * Array of images
         *
         * @type Array
         */
        this.images = [];


        /**
         * Binds interactive events
         *
         * @return ImageUploader
         */
        this.bindEvents = function() {
            var container = that.elements.container;
            that.elements = $.extend({}, that.elements, {
                inputFile: container.find('.inputFiles'),
            });

            that.elements.inputFiles.change(that.inputFileChangeEvent);
            that.elements.inputUpload.click(that.inputUploadClickEvent);

            // Live events
            $('body').on('click', '.remove-image', that.removeImageEvent);

            return that;
        };


        /**
         * File input change event handler
         *
         * @param Event e
         */
        this.inputFileChangeEvent = function(e) {
            var images = that.convertFileListToImagesArray(e.target.files);

            // Generate previews for new files
            if (images.length) {
                that.addImages(images);
            }

            that.images = that.images.concat(images);

            // Reset file input
            $(this).val('');
        };


        /**
         * Upload input click event handler
         *
         * @param  Event e
         * @return void
         */
        this.inputUploadClickEvent = function(e) {
            e.stopPropagation();
            e.preventDefault();

            if ( ! that.images.length) {
                return;
            }

            for (var i = 0; i < that.images.length; i++) {
                if ( ! that.isValidImageFile(that.images[i]['file'])) {
                    continue;
                }

                that.updatePreviewStatus(that.images[i]['item'], 'waiting');

                var data = new FormData();

                data.append(that.options.CSRFToken.name, that.options.CSRFToken.value);
                data.append(that.options.fileField, that.images[i]['file']);

                am.addRequest(that.createAjaxOptions(data, that.images[i]));
                that.images.splice(i, 1);
                i--;
            }

            am.run(function() {
                console.log('done');
            });
        };


        /**
         * Remove image button event handler
         *
         * @param Event e
         */
        this.removeImageEvent = function(e) {
            var $li  = $(e.target).parent();
            var item = $li.data('item');

            that.removeImage(item);
        };


        /**
         * Recursively add images
         *
         * @param array images
         */
        this.addImages = function(images) {
            that.addImage(images, 0);
        };


        /**
         * Add Image
         *
         * @param  array   images
         * @param  integer key
         * @return void
         */
        this.addImage = function(images, key) {
            if ( ! images[key]) {
                return false;
            }

            var reader = new FileReader();
            var file   = images[key]['file'];

            reader.onload = (function(file) {
                return function(e) {
                    var image = e.target.result;
                    var date  = new Date();

                    images[key]['item'] = md5(image + date.getTime());

                    // Create preview
                    that.drawPreview(images[key]['item'], image);
                }
            })(file);

            reader.readAsDataURL(file);
            that.addImage(images, (key + 1));

            return;
        };


        /**
         * Remove Image
         *
         * @param  integer item
         * @return void
         */
        this.removeImage = function(item) {
            var found = false;

            for (var i = 0; i < that.images.length; i++) {
                if (item === that.images[i].item) {
                    that.images.splice(i, 1);
                    that.removePreview(item);

                    found = true;
                    i--;
                }
            }

            return found;
        };


        /**
         * Attempts to remove the preview for the given item
         *
         * @param string item
         */
        this.removePreview = function(item) {
            $('[data-item="' + item + '"]').remove();
        }


        /**
         * Convert FileList to Array of images
         *
         * @param  FileList fileList
         * @return Array
         */
        this.convertFileListToImagesArray = function(files) {
            var array = new Array();

            $.each(files, function(key, value) {
                if (that.isValidImageFile(value)) {
                    array[key] = {
                        'file': value,
                        'item': null
                    };
                }
            });

            return array;
        };


        /**
         * Create ajax request options
         *
         * @param  FormData data
         * @param  Array    image
         * @return jqXHR
         */
        this.createAjaxOptions = function(data, image) {
            return {
                url: that.options.uploadUrl,
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function(jqXHR, settings) {
                    that.updatePreviewStatus(image['item'], 'uploading')
                },
                success: function(data, status, jqXHR) {
                    if (data.id) {
                        that.updatePreviewStatus(image['item'], 'success');

                        return true;
                    } else {
                        that.updatePreviewStatus(image['item'], 'error');

                        return false;
                    }
                },
                error: function(jqXHR, status, error) {
                    that.updatePreviewStatus(image['item'], 'error');

                    return false;
                }
            };
        };


        /**
         * Check if image is valid file format
         *
         * @param  File file
         * @return bool
         */
        this.isValidImageFile = function(file)
        {
            return file.type.match('image/jpeg')
                ? true
                : false;
        }


        /**
         * Set options
         *
         * @param Object opts
         */
        this.setOptions = function(opts) {
            if (opts != null && typeof opts === 'object') {
                that.options = $.extend({}, that.defaults, opts);
            }

            return that;
        };

        /**
         * Update preview status
         *
         * @param string item
         * @param string status
         */
        that.updatePreviewStatus = function(item, status) {
            var elPreview = that.elements.container.find('[data-item="' + item + '"]');
            var elStatus  = elPreview.find('.status');

            switch (status) {
                case 'waiting':
                    elStatus
                        .removeClass('btn-danger')
                        .removeClass('btn-success')
                        .addClass('btn-warning')
                        .prop('disabled', true)
                        .text('Waiting...');
                    break;
                case 'uploading':
                    elStatus
                        .removeClass('btn-danger')
                        .removeClass('btn-success')
                        .addClass('btn-warning')
                        .prop('disabled', true)
                        .text('Uploading...');
                    break;
                case 'success':
                    elStatus
                        .removeClass('btn-danger')
                        .removeClass('btn-warning')
                        .addClass('btn-success')
                        .prop('disabled', true)
                        .text('Uploaded');
                    break;
                case 'error':
                    elStatus
                        .removeClass('btn-warning')
                        .removeClass('btn-success')
                        .addClass('btn-danger')
                        .prop('disabled', true)
                        .text('Failed');
                    break;
                default:
                    break;
            }
        }


        /**
         * Draws a given template
         *
         * @param  string template
         * @return string
         */
        this.drawTemplate = function(template, vars) {
            var engine   = that.options.engine;
            var template = engine.compile($('#template-' + template).html());

            if (vars == null || typeof vars !== 'object') {
                vars = {};
            }

            return template(vars);
        };


        /**
         * Draw the container for the images
         *
         * @return ImageUploader
         */
        this.drawBase = function() {
            that.elements.container.append(that.drawTemplate('base', {
                cancelUrl: that.options.cancelUrl,
            }));

            that.elements.inputFiles  = that.elements.container.find('.inputFiles');
            that.elements.inputUpload = that.elements.container.find('.inputUpload');
            that.elements.previewList = that.elements.container.find('.previewList');

            return that;
        };


        /**
         * Draw an image preview
         *
         * @return ImageUploader
         */
        this.drawPreview = function(item, image) {
            that.elements.previewList.append(that.drawTemplate('image', {
                item: item,
                image: image
            }));

            return that;
        };


        return {
            init: function(el, opts) {
                that.setOptions(opts);
                that.elements.container = el;
                that.drawBase();
                that.bindEvents();
            },
            getImages: function() {
                return that.images;
            }
        }
    };

    // Assign to global namespace
    window.ImageUploader = ImageUploader;

})(window, jQuery);
