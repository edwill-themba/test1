# Application Requirements
1. Xampp
2. PHP 7 or Higher
3. MYSQL
4. Make sure under  C:\xampp\php\php.ini that this line is uncommented  extension=pdo_mysql
# How the application Works
1. First Copy the database folder userdb to C:\xampp\mysql\data or just create a database        called userdb on phpmyadmin
2. If you decided to create you own database you need to create table called users under         userdb with this fields id int auto_increments, name varchar, surname varchar, idno           varchar, date_of_birth varchar nb as the application requires the date of birth in this       format dd/mm/YYYY
3. Copy the url this url http://localhost/test1/index.html to the browser of your choice and     run the application, the application works according to the instructions.
# Application Folder stracture
1. Test1 is the root folder with subfolder secure, inside secure there is a file called          connection.php which connects the entire application to the database.
2. Subfolder userdb is the database file,if you decide not to create your own database
3. File called index.html is a user interface
4. File called process.php is where the instructions are processed.
# NB This instructions are for windows machines only where the application is tested  