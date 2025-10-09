
Bakery Demo - Basic PHP + MySQL app (for XAMPP)

Installation (XAMPP):
1. Start Apache and MySQL in XAMPP Control Panel.
2. Copy the entire 'baker_demo' folder to C:\xampp\htdocs\ (so path becomes C:\xampp\htdocs\baker_demo)
3. Open phpMyAdmin (http://localhost/phpmyadmin) and import the file baker.sql provided in this folder.
   - Default database name in the SQL: bakery_db
4. Edit config/database.php if your MySQL username/password differs (default: root / empty password).
5. Open the site: http://localhost/baker_demo/

Default admin:
  username: admin
  password: admin123

Notes:
- This is a simple demo for learning. It uses session for cart and basic mysqli prepared statements for DB operations.
- Do not use in production without securing properly (CSRF, input validation, HTTPS, etc.).
