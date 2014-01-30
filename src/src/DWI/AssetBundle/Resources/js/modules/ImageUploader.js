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
        this.elements = {
            inputFile: $('')
        };


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

            that.elements.inputFile.change(that.inputFileChangeEvent);

            return this;
        };


        this.inputFileChangeEvent = function() {

        };


        this.addFile = function() {

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
            that.elements.container.append(this.drawTemplate('base', {
                cancelUrl: that.options.cancelUrl,
            }));

            return this;
        };


        /**
         * Draw an image preview
         *
         * @return ImageUploader
         */
        this.drawPreview = function() {

        };


        /**
         * Set options
         *
         * @param Object opts
         */
        this.setOptions = function(opts) {
            if (opts != null && typeof opts === 'object') {
                that.options = $.extend({}, that.defaults, opts);
            }

            return this;
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
