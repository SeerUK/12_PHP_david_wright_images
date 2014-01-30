module.exports = function (grunt) {

    "use strict";

    grunt.initConfig({
        dirs: {
            cssBuild: 'src/DWI/AssetBundle/Resources/public/css/',
            js: 'src/DWI/AssetBundle/Resources/js',
            jsBuild: 'src/DWI/AssetBundle/Resources/public/js',
            sass: 'src/DWI/AssetBundle/Resources/sass',
            src: 'src/DWI/AssetBundle/Resources/'
        },
        compass: {
            dist: {
                options: {
                    config: 'config.rb'
                }
            }
        },
        concat: {
            options: {
                separator: ';',
            },
            dist: {
                src: ['<%= dirs.js %>/modules/*.js', '<%= dirs.js %>/*.js'],
                dest: '<%= dirs.jsBuild %>/dwi.js'
            }
        },
        uglify: {
            options: {
                // mangle: false
                debug: true,
            },
            target: {
                files: {
                    '<%= dirs.jsBuild %>/dwi.min.js': ['<%= dirs.jsBuild %>/dwi.js']
                }
            }
        },
        watch: {
            css: {
                files: [
                    '<%= dirs.sass %>/*.scss',
                    '<%= dirs.sass %>/modules/*.scss',
                    '<%= dirs.sass %>/partials/*.scss'
                ],
                tasks: ['css'],
                options: {
                    spawn: false
                }
            },
            js: {
                files: [
                    '<%= dirs.js %>/modules/*.js',
                    '<%= dirs.js %>/*.js'
                ],
                tasks: ['js'],
                options: {
                    spawn: false
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['css', 'js']);
    grunt.registerTask('css', ['compass']);
    grunt.registerTask('js', ['concat', 'uglify']);
};
