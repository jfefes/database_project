database_project
================

CSIT455- Object/Relational Databases

This project utilizes PHP 5.4, and Oracle's Instant Client libraries to connect to SUNY Fredonia's Oracle server. The easiest way to locally host the client-side files are to install a WAMP (Windows' Apache, MySQL, and PHP) server. For Macinotsh or Linux, servers named MAMP and LAMP, respectively, are availible, however compatability with Instant Client may vary, and procedures may have to be alertered.

For a Windows installation, 
Download WAMPsever 2.4, at http://www.wampserver.com/en/
Assumption: WAMPserver s installed in C:\. If installed in a different path, substitue that in the examples below.
Open up your php.ini file, (C:\wamp\bin\php)
Add this line: extension_dir = C:\wamp\bin\php\php5.4.12\ext
Remove the semicolon from the beginning of the line: extension=php_oci8_11g.dll
save and close.
Download the "Instant Client Package - Basic" for Windows http://www.oracle.com/technetwork/database/features/instant-client/index-097480.html from Oracle. Because PHP is 32 bit, the 32 bit version of Instant Client is required.
Edit your system PATH environment settings and add your Instant Client directory. For me, this was C:\wamp\bin\instantclient_11_2 -> environment settings can be found in the control panel.
Reboot computer, start WAMP, open files in browser.
Installation insturctions were taken from: http://www.oracle.com/technetwork/articles/technote-php-instant-084410.html

