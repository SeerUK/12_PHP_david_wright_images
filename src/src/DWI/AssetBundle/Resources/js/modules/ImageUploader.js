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

            return that;
        };


        /**
         * File input change event handler
         *
         * @param Event e
         */
        this.inputFileChangeEvent = function(e) {
            var images  = that.convertFileListToImagesArray(e.target.files);

            // Generate previews for new files
            if (images.length) {
                that.addImages(images);
            }

            that.images = that.images.concat(images);
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
         * @return bool
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

                    images[key]['item'] = md5(image);

                    // Create preview
                    that.drawPreview(images[key]['item'], image);
                }
            })(file);

            reader.readAsDataURL(file);
            that.addImage(images, (key + 1));

            return;
        };


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
        }
    };

    // Assign to global namespace
    window.ImageUploader = ImageUploader;

})(window, jQuery);
