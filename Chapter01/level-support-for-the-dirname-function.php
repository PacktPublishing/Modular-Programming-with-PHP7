<?php

// would echo '/var/www/html/app/etc'
echo dirname('/var/www/html/app/etc/config/');

// would echo '/var/www/html/app/etc'
echo dirname('/var/www/html/app/etc/config.php');

// would echo '/var/www/html/app'
echo dirname('/var/www/html/app/etc/config.php', 2);

// would echo '/var/www/html'
echo dirname('/var/www/html/app/etc/config.php', 3);
