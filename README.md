Simple time-tracking Symfony application test task

To install:
1) Install docker and docker-compose
2) Configure your env variables
3) Run 'docker-compose build', 'docker-compose up'
4) Inside apps/symfony4-time-tracker run 'composer install'
5) Run 'docker-compose exec php bash'
6) Inside docker-container run 'bin/build.sh'

Done

Endpoints:
CSV Export: 'http://{host}/export/task/csv'
Logout: 'http://{host}/logout'

Notes:
For entity management by admin UI I used SonataAdminBundle, but looks like it already has export functionality here http://i.imgur.com/5DGLUah.png
Please use CSV export endpoint instead.
