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
         * Array of files
         *
         * @type Array
         */
        this.files = [];


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
            that.files = that.files.concat(that.convertFileListToArray(e.target.files));

            if (that.files.length) {
                console.log(that.files);
            }
        };


        this.addFile = function() {

        };


        /**
         * Convert FileList to Array
         *
         * @param  FileList fileList
         * @return Array
         */
        this.convertFileListToArray = function(files) {
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

            return that;
        };


        /**
         * Draw an image preview
         *
         * @return ImageUploader
         */
        this.drawPreview = function() {

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
