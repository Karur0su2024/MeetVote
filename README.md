# MeetVote

MeetVote is a simple open-source alternative to Doodle, created as a bachelor's thesis project. The application allows you to create polls for scheduling meetings, events, or any other occasion where you need to find a suitable time for everyone.

## Features

- Create polls with time options and additional questions
- Share polls with others via link or email
- Vote for preferred times and answer additional questions
- View results and create a final event
- Synchronize with Google Calendar
- Authentication via Google account or email and password
- Multi-language support (English, Czech)
- Responsive design (Bootstrap 5)

## Technologies

- PHP 8.3 with Laravel 12
- Livewire 3 for reactive components
- Bootstrap 5 for UI
- Alpine.js for client-side interactivity
- Google API for Google Calendar integration
- MariaDB for data storage

## Requirements

- PHP 8.3+
- Composer
- Node.js and NPM
- MariaDB or MySQL database
- Google API keys for Google Calendar integration
- SMTP server for email functionality

## Installation

### 1. Clone the repository
```bash
git clone https://github.com/Karur0su2024/MeetVote.git
cd MeetVote
```

### 3. Environment setup
```bash
composer install
npm install
```

### 3. Install dependencies
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure .env file
```env
DB_CONNECTION=mariadb
DB_HOST=mariadb
DB_PORT=3306
DB_DATABASE=meetvote
DB_USERNAME=your_username
DB_PASSWORD=your_password
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_general_ci

MAIL_ALLOWED=true
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=2525
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_TIMEOUT=10
```
### 5. Run migrations
```bash
php artisan migrate
```

### 6. Start the development server
```bash
php artisan serve
npm run dev
```




## Google API Configuration

For full functionality including Google Calendar synchronization, you need to configure Google API:

1. Create a project in [Google Cloud Console](https://console.cloud.google.com/)
2. Enable Google Calendar API
3. Create OAuth 2.0 credentials
4. Set authorized redirect URIs
5. Copy Client ID and Client Secret to your `.env` file
    ```
    GOOGLE_CLIENT_ID=your-client-id
    GOOGLE_CLIENT_SECRET=your-client-secret
    GOOGLE_REDIRECT_URI=http://localhost:8000/google/callback
    GOOGLE_CALENDAR_REDIRECT_URI=http://localhost:8000/google/calendar/callback
    GOOGLE_SERVICE_ENABLED=true
    ```
## License

This project is licensed under the [MIT License](LICENSE).

## Author

Karel Tynek - as part of a bachelor's thesis at Prague University of Economics and Business
