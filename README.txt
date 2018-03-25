How to set up the website and database.

1. Extract all the files from the zip folder.
2. Log onto ONID https://secure.onid.oregonstate.edu/cgi-bin/my and go to Web Database.
3. If there's no database account, create one, then click on  https://secure.oregonstate.edu/oniddb and login with your database username and password.
4. Once in the SQL database, go to import tab and choose shelterTable.sql as the file, then click on go.
5. Open base.php file and change xxxx-db with your database username, and db-pass with your database pass.
6. Change "http://web.engr.oregonstate.edu/~xxxx/361/" to replace "xxxx" with your onid username, and "xxxxx@oregonstate.edu" with your onid email.
7. Once queries have been made, and settings are changed, drag all the PHP files along with the cat.jpg and style.css file into a folder in public_html/cs361, on ENGR server.
8. Be sure that permission is set to 775 for all files. 
9. Go to your newly established web link at http://web.engr.oregonstate.edu/~xxxx/361/home.php replacing "xxxx" with your onid username.