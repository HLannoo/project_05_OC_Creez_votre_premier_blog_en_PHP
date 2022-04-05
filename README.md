## code quality
Code quality has been validated by Symfony Insight. You can access the inspection report by clicking on the badge below.

[![SymfonyInsight](https://insight.symfony.com/projects/4ea20490-080e-4c13-811d-175d00c66607/big.svg)](https://insight.symfony.com/projects/4ea20490-080e-4c13-811d-175d00c66607)

## Installation
- PHP 8
- MySql 5.7.36
- Apache 2.*

## Requirements
- Localhost 
For this project i used WAMPSERVER avaible here : https://www.wampserver.com/


## Installing the project:
Step 1: Clone the Repository on server from the root via the command: **git clone https://github.com/Kakahuette400/project_05.git**

Step 2: Install composer on your project if it's not already the case: https://getcomposer.org/
- Install all dependances avaible on : https://packagist.org/ whit "composer install"
- Read the documentation to customize your installation

Step 3: Create a database on your DBMS and import the blog_php.sql file avaiable in diagrams folder

Step 4: create the project_05/config/config_db.php file with access to your database (/!\ CREATE config folder and config files : config_db.php and config_email.php
- Create config_db.php file whit this function :

`Place this code`
  
    <?php
    return Array
    (
    $host="your host",
    $dbname="your dbname",
    $port="your port",
    $user="your user dbname",
    $pass="your password dbname",
    );


Step 5: Fill in the project_05/config/config_email.php file with access to your email account.

- Create config_email.php file whit this function :

`place this code :`

    <?php
    return Array
    (
    $smtp="your SMPTP",
    $username="your email",
    $password="your email password",
    $port=your port,
    );
    
Step 6: Your blog is now functional, you can now connect to the administrator panel.


## Libraries used:
The libraries were installed via composer, please install it:
- For route management: **nikic/fast-route** https://packagist.org/packages/nikic/fast-route
- For views: **twig/twig** https://packagist.org/packages/twig/twig
- For sending emails: **phpmailer/phpmailer** https://packagist.org/packages/phpmailer/phpmailer
- For managing CSRF vulnerabilities: **psecio/csrf** https://packagist.org/packages/psecio/csrf

## About bootsrap Blog Theme

For this project, I used the bootstrap template: https://startbootstrap.com/template/modern-business














