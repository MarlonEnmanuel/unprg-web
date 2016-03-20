
var gulp = require("gulp");
var stylus = require("gulp-stylus");
var sftp = require("gulp-sftp");
var nib = require('nib');

gulp.task('estilos', function(){
	gulp.src(['./unprg-stylus/**/!(inc*).styl'])
	.pipe(stylus({use : nib(),compress : true}))
	.pipe(sftp({
		host : '192.168.0.10',
		user : 'root',
		pass : 'root',
		remotePath : '/opt/lampp/htdocs/frontend/css'
	}));
});

gulp.task('htdocs-backend', function(){
	gulp.src(['./unprg-htdocs/backend/**/*.*'])
	.pipe(sftp({
		host : '192.168.0.10',
		user : 'root',
		pass : 'root',
		remotePath : '/opt/lampp/htdocs/backend'
	}));
});

gulp.task('htdocs-frontend', function(){
	gulp.src(['./unprg-htdocs/frontend/**/*.*'])
	.pipe(sftp({
		host : '192.168.0.10',
		user : 'root',
		pass : 'root',
		remotePath : '/opt/lampp/htdocs/frontend'
	}));
});

gulp.task('htdocs-includes', function(){
	gulp.src(['./unprg-htdocs/includes/**/*.*'])
	.pipe(sftp({
		host : '192.168.0.10',
		user : 'root',
		pass : 'root',
		remotePath : '/opt/lampp/htdocs/includes'
	}));
});

gulp.task('htdocs-gestion', function(){
	gulp.src(['./unprg-htdocs/gestion/**/*.*'])
	.pipe(sftp({
		host : '192.168.0.10',
		user : 'root',
		pass : 'root',
		remotePath : '/opt/lampp/htdocs/gestion'
	}));
});

gulp.task('watch', function(){
	gulp.watch('./unprg-stylus/**/*.styl',['estilos']);

	gulp.watch('./unprg-htdocs/backend/**/*.*',['htdocs-backend']);
	gulp.watch('./unprg-htdocs/frontend/**/*.*',['htdocs-frontend']);
	gulp.watch('./unprg-htdocs/includes/**/*.*',['htdocs-includes']);
	gulp.watch('./unprg-htdocs/gestion/**/*.*',['htdocs-gestion']);
});

gulp.task('default',['estilos','watch']);