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

    var iuidx = 0;

    var ImageUploader = function(am, el) {
        var that = this,
            engine = Handlebars,
            container;

        /**
         * Binds interactive events
         *
         * @return ImageUploader
         */
        this.bindEvents = function() {
            return this;
        };

        /**
         * Draws a given template
         *
         * @param  string template
         * @return string
         */
        this.drawTemplate = function(template, vars) {
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
        this.drawContainer = function() {
            el.append(this.drawTemplate('images', {id: 'iu-images-' + iuidx}));

            return $('#iu-images-' + iuidx);
        };

        /**
         * Draw an image preview
         *
         * @return ImageUploader
         */
        this.drawPreview = function() {

        };

        return {
            addImagePreview: function() {

            },
            init: function() {
                // Increment IU Index
                iuidx++;

                // Draw base container
                container = that.drawContainer();

                // Bind events to elements
                that.bindEvents();
            }
        }
    };

    // Assign to global namespace
    window.ImageUploader = ImageUploader;

})(window, jQuery);
