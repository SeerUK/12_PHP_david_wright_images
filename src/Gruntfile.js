module.exports = function (grunt) {

    "use strict";

    grunt.initConfig({
        dirs: {
            src: 'src/DWI/AssetBundle/Resources/',
            sass: 'src/DWI/AssetBundle/Resources/sass',
            cssBuild: 'src/DWI/AssetBundle/Resources/public/css/'
        },
        compass: {
            dist: {
                options: {
                    config: 'config.rb'
                }
            }
        },
        watch: {
            css: {
                files: '<%= dirs.sass %>*.scss',
                tasks: ['compass'],
                options: {
                    spawn: false
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['compass']);
};
