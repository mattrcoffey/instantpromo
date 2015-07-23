module.exports = function(grunt) {
    grunt.initConfig({
      image_resize: {
        resize: {
          options: {
            width: 780,
              upscale: true
          },
          files: {
              'media/wysiwyg/Mid_Carolina_Cars.jpg':  'media/wysiwyg/Mid_Carolina_Cars2.jpg',
              'media/wysiwyg/IMG_6214.jpg': 'media/wysiwyg/IMG_62142.jpg',
              'media/wysiwyg/DBK_1.jpg': 'media/wysiwyg/DBK_12.jpg',
              'media/wysiwyg/TATH_Racing_Arch.jpg': 'media/wysiwyg/TATH_Racing_Arch2.jpg',
          }
        }
      }
    })
    grunt.loadNpmTasks('grunt-image-resize');
    grunt.registerTask('default', ['image_resize']);
};