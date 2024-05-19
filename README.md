# Two-Factor Authentication (2FA) Library

This library provides an easy-to-use implementation of two-factor authentication (2FA) using email verification. It is designed to enhance the security of web and mobile applications. Developed in PHP, this library offers a robust 2FA solution that integrates seamlessly into existing applications.

# Features
- Email-Based 2FA: Secure your application by sending a 2FA code to the user's email address using PHPMailer.
- Code Generation: Generates secure, random 6-digit codes for user verification.
- Verification: Validates the provided code against the stored code, ensuring it hasn't expired.
- Environment Configuration: Utilizes dotenv for secure and flexible configuration of SMTP settings.
- Session Management: Efficiently stores and retrieves 2FA codes and their expiration times in a JSON file.

# Usage
## Prerequisites:
- XAMPP
- Visual Studio Code or another suitable code editor
- PHP 7.4 or higher
- Composer

## Installation:
Clone the repository and install the dependencies using Composer:
```sh
git clone https://github.com/Besmira75/2FA-Library.git
cd your-repo-name
composer install
composer require phpmailer/phpmailer
composer require vlucas/phpdotenv
```
Note: Ensure that you place the folder of the library in the `htdocs` folder of your XAMPP installation. This is typically located at `C:\xampp\htdocs` on Windows or `/Applications/XAMPP/htdocs` on macOS.  

## Integrate 2FA in your web and mobile application

To integrate the library you need to add `send2FACode` and `verify2FACode` functions in your web or mobile application, follow these steps:

1. **Sending the 2FA Code**: Call the `send2FACode` function with the user's email address to send the 2FA code.
2. **Verifying the 2FA Code**: Call the `verify2FACode` function with the user's email address and the entered 2FA code to verify it.

# Contributors:
- [Astrit Krasniqi](https://github.com/astritkrasniqi1)
- [Besmira Berisha](https://github.com/Besmira75)
- [Blerta Azemi](https://github.com/bl3rt4)

##### This library was created as part of the Internet Security course, supervised by PhD. Mërgim Hoti.
