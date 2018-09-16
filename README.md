# Pizza Site
This site is an experiment with learning how to do some web coding. It started as a fun idea of just reviewing different local pizza places to find a good one. I then decided to use that idea to learn to code a decent looking website. In the past I've only ever used basic html/php/sql in order to make sites for school projects. For this project I've decided to stick with the html/php/sql, but I'm also using the CSS framework [Bootstrap](https://getbootstrap.com/). Along the way I've had to customize some CSS to do things that I wanted to do and have learned a lot. So far this is a work in progress and while some steps have been made to make it portable (mainly moving secret keys and passwords to a config), this is not meant to be completely portable.

The website can be found here: https://mcdade.info/pizza/index.php

## Requirements
- PHP
- [PDO](https://secure.php.net/manual/en/book.pdo.php)
- [PHPmailer](https://github.com/PHPMailer/PHPMailer) (for contact page)
- [TinyMCE](https://www.tiny.cloud/) (for wysiwyg editing)
- Mysql/MariaDB (with appropriate database structure. I will need to add an sql script that can create this.)
- Nginx/Apache
