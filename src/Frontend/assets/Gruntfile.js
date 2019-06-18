const sass = require('node-sass');

module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    sass: {
        frontend: {
          options: {
            implementation: sass,
            outputStyle: 'compressed',
          },
          files: {
            'css/custom-us-dynamic-ctas.css': 'css/custom-us-dynamic-ctas.scss',
          }
        }
    },

    cssmin: {
      options: {
        keepSpecialComments: 0
      },
      merge_all: {
        src: [
          'css/bootstrap.min.css',
          'css/custom-us-dynamic-ctas.css'
        ],
        dest: 'dist/us-dynamic-ctas.css'
      }
    },

	uglify: {
      dist: {
        files: {
          'dist/us-dynamic-ctas.js': [
            'js/bootstrap.min.js',
            'js/custom-us-dynamic-ctas.js',
          ],
        }
      }
    },

    watch: {
      options: {
        livereload: true,
      },
      sass: {
        files: ['css/*.scss'],
        tasks: ['sass', 'cssmin']
      },
	  js: {
        files: ['js/custom-us-dynamic-ctas.js'],
        tasks: ['uglify']
      },
    }

  });

  // Load Grunt Plugins
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-compress');
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  // Register Tasks
  grunt.registerTask('default', ['sass', 'cssmin', 'uglify']);
};
