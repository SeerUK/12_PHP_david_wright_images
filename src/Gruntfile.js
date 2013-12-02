module.exports = function (grunt) {
    "use strict";

    grunt.initConfig({
        dirs: {
            src: 'src/DWI/AssetBundle/Resources/',
            cssBuild: 'src/DWI/AssetBundle/Resources/public/css/'
        },
        cssmin: {
            dwi: {
                src: '<%= dirs.cssBuild %>dwi.css',
                dest: '<%= dirs.cssBuild %>dwi.min.css'
            }
        },
        less: {
            dwi: {
                src: '<%= dirs.src %>dwi.less',
                dest: '<%= dirs.cssBuild %>dwi.css'
            }
        },
        watch: {
            css: {
                files: '<%= dirs.src %>less/*.less',
                tasks: [
                    'css'
                ]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['css']);
    grunt.registerTask('css', ['less', 'cssmin:dwi']);
};
