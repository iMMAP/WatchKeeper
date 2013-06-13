Watchkeeper
============

<b>------ ASSUMPTIONS ------</b>
- you are installing on ubuntu server LTS 12.04
- postgresql 
- system tables for the app are setup on the postgressql instance (more to come on this)

<b>------ iNSTALLATION ------</b>         

Prepare the system

    sudo apt-get update
    sudo apt-get upgrade

Install postgresql client

    sudo apt-get install postgresql-client 
    
Install apache, php, pear, gd, mapscript, curl, and more..

    sudo apt-get install apache2 php5 libapache2-mod-php5 php-pear php5-gd php5-mapscript php5-pgsql
    
Install SMTP server and support

    sudo apt-get install postfix             (set as internet service, and enter your domain name)
    sudo pear install Net_SMTP
    
Reconfigure postfix SMTP server using

    sudo dpkg-reconfigure postfix
    
Restart apache

    sudo service apache2 restart
    
Get the code

    cd /var/www
    sudo apt-get install git
    sudo git clone https://github.com/iMMAP/Watchkeeper.git

<b>------ CONFIGURATION ------</b>   

Set your postgis server connection string here

    sudo vi /var/www/watchkeeper/sec/sec-m/conf.php
    sudo vi /var/www/watchkeeper/immap-sms/includes/config.php
    
Configure the GSM SMS Package

    sudo vi /var/www/watchkeeper/immap-sms/cron/cron-functions.php
    
<b>------ Cron Job / Task Scheduler ------</b>

Install Cron Job

    sudo apt-get install cron
    
List Current Schedule

    sudo crontab -l
    
Edit Cron Job
    
    sudo crontab -e

Set hourly job

    * * * * * php /var/www/watchkeeper/immap-sms/cron/chk_sms.php
    * * * * * php /var/www/watchkeeper/immap-sms/cron/chk_status.php
    
Set dayli job every 16.00 server time Mon - Sun

    0 16 * * 1-7 php /var/www/watchkeeper/sec-m/php/automail.php
    

Restart apache

    sudo service apache2 restart
    
    
