## code quality
Code quality has been validated by Symfony Insight. You can access the inspection report by clicking on the badge below.

[![SymfonyInsight](https://insight.symfony.com/projects/4ea20490-080e-4c13-811d-175d00c66607/big.svg)](https://insight.symfony.com/projects/4ea20490-080e-4c13-811d-175d00c66607)

## Installation
- PHP 8
- MySql 5.7.36
- Apache 2.*


## Installing the project:
Step 1: Clone the Repository on server from the root via the command: **git clone https://github.com/Kakahuette400/project_05.git**

Step 2: Create a database on your DBMS and import the blog_php.sql file

Step 3: Fill the project_05/config/config_db_.php file with access to your database.

Step 4: Fill in the project_05/config/config_email.php file with access to your email account.

Step 4: Your blog is now functional, you can now connect to the administrator panel.


## Libraries used:
The libraries were installed via composer, please install it:
- For route management: **nikic/fast-route** https://packagist.org/packages/nikic/fast-route
- For views: **twig/twig** https://packagist.org/packages/twig/twig
- For sending emails: **phpmailer/phpmailer** https://packagist.org/packages/phpmailer/phpmailer
- For managing CSRF vulnerabilities: **psecio/csrf** https://packagist.org/packages/psecio/csrf

## About bootsrap Blog Theme

For this project, I used the bootstrap template: https://startbootstrap.com/template/modern-business














