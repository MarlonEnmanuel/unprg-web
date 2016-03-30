
var gulp = require("gulp");
var stylus = require("gulp-stylus");
var sftp = require("gulp-sftp");
var nib = require('nib');

var host = '192.168.0.11';

gulp.task('estilos', function(){
	gulp.src(['./unprg-stylus/*.styl','./unprg-stylus/!(includes|blocks|libs)/*.styl'])
	.pipe(stylus({use : nib(),compress : true}))
	.pipe(sftp({
		host : host,
		user : 'root',
		pass : 'root',
		remotePath : '/opt/lampp/htdocs/frontend/css'
	}));
});

gulp.task('htdocs-backend', function(){
	gulp.src(['./unprg-htdocs/**/*.php'])
	.pipe(sftp({
		host : host,
		user : 'root',
		pass : 'root',
		remotePath : '/opt/lampp/htdocs/'
	}));
});

gulp.task('htdocs-frontend', function(){
	gulp.src(['./unprg-htdocs/frontend/**/*.*'])
	.pipe(sftp({
		host : host,
		user : 'root',
		pass : 'root',
		remotePath : '/opt/lampp/htdocs/frontend'
	}));
});

gulp.task('watch', function(){
	gulp.watch('./unprg-stylus/**/*.styl',['estilos']);

	gulp.watch('./unprg-htdocs/**/*.php',['htdocs-backend']);
	gulp.watch('./unprg-htdocs/frontend/**/*.*',['htdocs-frontend']);
});

gulp.task('default',['estilos','htdocs-backend','htdocs-frontend','watch']);