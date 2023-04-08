# fruits-eureka
# Installation Guide

Follow these steps to install and run the project on your machine:

## Prerequisites

- Ensure you have PHP, Composer, Node.js, and NPM installed on your system.
- Install Symfony CLI and create a new Symfony project.
- Set up a local MySQL database and update the connection settings in the Symfony project's .env file.

## Installation Steps

1. **Clone the repository**:

git clone https://github.com/al7373/fruits-eureka.git
cd fruits-eureka

2. **Install dependencies**:

composer install
npm install


3. **Configure email settings for Gmail SMTP**:

- Open the .env file and update the MAILER_DSN with your Gmail credentials:
  ```
  MAILER_DSN=smtp://username:password@smtp.gmail.com:587
  ```
- Replace 'username' and 'password' with your actual Gmail username and password.

4. **Build frontend assets**:

npm run build

5. **Run migrations to create the database schema**:
php bin/console d:s:u --force --complete
( php bin/console doctrine:migrations:migrate )

6. **Run the custom console command to fetch fruit data and save it to the database**:

php bin/console fruits:fetch

7. **Start the development server**:
Run this command in the public folder:
php -S localhost:3000

8. **Access the application**:

- Open your web browser and navigate to `http://localhost:3000` (or the URL provided by the Symfony server).

