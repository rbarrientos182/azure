/*global module:false*/
module.exports = function(grunt) {

// Project configuration.
grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    meta: {
        banner: '/**\n' +
        ' * <%= pkg.name %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %>\n' +
        ' *\n' +
        ' * Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
        ' * Licensed <%= pkg.license %>\n' +
        ' */\n'
    },

    /**
     * Minify the sources!
     */
    uglify: {
      compile: {
        options: {
          banner: '<%= meta.banner %>'
        },
        files: {
          'circles.min.js': ['circles.js']
        }
      }
    },


});

// Dependencies
grunt.loadNpmTasks('grunt-contrib-uglify');

// Default task.
grunt.registerTask('default', 'uglify');


};