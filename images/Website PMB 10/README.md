# Website PMB 10

## Overview
Website PMB 10 is a web application designed for public complaints management. It allows users to register, log in, and submit complaints to the BPBD (Badan Penanggulangan Bencana Daerah) of Kota Tangerang Selatan. The application features a user-friendly interface and integrates social media feeds for enhanced user engagement.

## Project Structure
```
Website PMB 10
├── private
│   ├── database.php       # Database connection logic
│   ├── auth.php           # Authentication functions
├── public
│   ├── css
│   │   ├── bootstrap.css   # Bootstrap CSS framework
│   │   ├── font-awesome.min.css # Font Awesome icons
│   │   └── style.css       # Custom styles
│   ├── js
│   │   ├── bootstrap.js     # Bootstrap JavaScript
│   │   └── jquery.min.js    # jQuery library
│   ├── images
│   │   ├── avatar1.png      # User avatar
│   │   ├── avatar2.png      # User avatar
│   │   └── logotangerangselatan.png # Logo image
│   ├── login.php            # User login form
│   ├── register.php         # User registration form
│   ├── logout.php           # User logout functionality
│   └── index.php            # Main entry point
├── .htaccess                # Server configuration
└── README.md                # Project documentation
```

## Installation
1. Clone the repository to your local machine.
2. Ensure you have a web server (like XAMPP) running.
3. Create a database in MySQL and import the necessary tables for user management.
4. Update the `private/database.php` file with your database credentials.
5. Access the application via your web browser at `http://localhost/Website PMB 10/public/index.php`.

## Usage
- **Registration**: Navigate to `register.php` to create a new account.
- **Login**: Use `login.php` to access your account.
- **Logout**: Click on the logout option to end your session.

## Features
- User registration and authentication
- Complaint submission and management
- Social media integration for real-time updates

## Contributing
Contributions are welcome! Please fork the repository and submit a pull request for any enhancements or bug fixes.

## License
This project is licensed under the MIT License.