all: deploy

deploy:
	-sudo rsync -av --exclude='Makefile' * /srv/http/
	sudo service apache2 restart
