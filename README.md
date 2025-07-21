# Kawanmasa Atelier Appointment & Review System

## Project Information

Kawanmasa Atelier is a web application built with **CodeIgniter 4 (PHP)** and **JavaScript** for booking photography session, managing appointments and collecting user reviews.

Users can book sessions, view their appointments, submit reviews, and view submitted reviews.  
The app features a modern UI, authentication, and appointment status tracking.

---

## Setup Instructions

1. **Clone the repository**
    ```bash
    git clone https://github.com/doteneff/kawanmasa-atelier.git
    cd kawanmasa-atelier
    ```

2. **Install dependencies**
    - Make sure you have [Composer](https://getcomposer.org/) installed.
    ```bash
    composer install
    ```

3. **Configure your environment**
    To run locally:
    - First go to app/Config/App.php and change the baseURL to http://localhost:8080
    - Next, edit value on app/Config/Database.php inside Construct to ENVIRONMENT === 'development'
    - Additionally, on the same file edit $test array with details for your Database
   

4. **Prepare the database**
    - Create a Database following your previous Database Detail 
    - Run PHP Spark Script below to Migrate / Create Table
    ```bash
    php spark migrate
    ```
    - Run PHP Spark Script below to Seed Users and Schedule Data
    ```bash
    php spark db:seed StartSeeder
    ```

---

## Sample Login Credentials

> **Note:** Use the detail below login.

- **Email:** `admin@gmail.com`
- **Password:** `P@ssw0rd`

--- 

## How to Run the Application Locally

1. **Start the built-in PHP server**
    ```bash
    php spark serve
    ```
    - The app will be available at [http://localhost:8080](http://localhost:8080) depending on the URL

2. **Login and use the app**
    - Visit `/login` to access the login page.


## How to Run the Application on Cloud
1. Open https://kawanmasa-atelier-a4e41d099687.herokuapp.com/
2. Use the same credential for login
3. Do the testing process

---

## Assumptions Made

- Only authenticated users can book appointments and submit reviews.
- Each appointment can have only one review.
- Appointments are considered "completed" if their date/time has passed.
- Appointments are counted as "pending" if their date/time has not passed.
- Reviews cannot be submitted for pending appointments.
- The UI uses a shared header/topbar layout for consistency.
- CSRF protection is enabled for all forms.

---

## How to Run Tests

TBA

---

## Additional Notes

- The Application is Deployed on Heroku using Automatic Deployment from Github
- The Database of the Application is being set up using VPS
- The credential of the Database, baseURL, etc is being set up inside envVar of Cloud Portal (Heroku)

**As the VPS requirement is quite low, please use the database wisely**
**For more optimized experience, please clone and setup on local**
**This app is not suitable for mobile as it does NOT mobile responsiveness nor mobile-friendly styling**
**The rest of the app (Unit Test, More View Template, etc) will be updated at a later time**


---