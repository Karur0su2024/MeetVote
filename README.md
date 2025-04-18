# MeetVote

MeetVote is a simple open-source alternative to Doodle, created as a bachelor's thesis project. The application allows you to create polls for scheduling meetings, events, or any other occasion where you need to find a suitable time for everyone.

## Demo
Try out the live demo at: **[https://meetvote.online](https://meetvote.online)**

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
- (Optional) Google API keys for Google Calendar integration

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
    GOOGLE_SERVICE_ENABLED=true
    ```
## License

This project is licensed under the [MIT License](LICENSE).

## Author

Karel Tynek - as part of a bachelor's thesis at Prague University of Economics and Business
