module.exports = {
  apps : [
	  {
		name     : 'yqkmanager',
		script   : 'npm',
		args    : 'run dev',
		cwd    : '/home/vagrant/yqkmanager',
	  }

  deploy : {
    production : {
      user : 'vagrant',
      host : '119.23.141.231',
      ref  : 'origin/develop',
      repo : 'ssh://git@119.23.141.231:10022/youqikang/yqkmanager.git',
      path : '/var/www/production',
      'post-deploy' : 'npm install && pm2 reload ecosystem.config.js --env production'
    }
  }
};
