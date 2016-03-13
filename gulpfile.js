
var gulp = require("gulp");
var stylus = require("gulp-stylus");
var nib = require('nib');

gulp.task('Estilos', function(){
	gulp.src(['./unprg-stylus/**/!(inc*).styl'])
	.pipe(stylus({use : nib(),compress : true}))
	.pipe(gulp.dest("./unprg-htdocs/frontend/css"));
});

gulp.task('watch', function(){
	gulp.watch('./unprg-stylus/**/*.styl',['Estilos']);
});

gulp.task('default',['Estilos','watch']);