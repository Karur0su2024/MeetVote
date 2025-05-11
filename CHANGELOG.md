# Release Notes

## [Unreleased](https://github.com/laravel/laravel/compare/v0.1.0...main)

## [v0.1.0](https://github.com/laravel/laravel/compare/v11.0.0...v0.1.0) - 2025-05-11

### [0.1.0] - 2025-05-11

#### Features

##### Core Functionality

- **Poll Creation**: Create polls for meeting scheduling with customizable date and time options
- **Voting System**: Vote for preferred times using Yes/Maybe/No preference system
- **Anonymous Voting**: Option to allow anonymous participation
- **Custom Questions**: Add additional questions to polls (e.g., location, agenda)
- **Comments**: Optional comment section for discussions
- **Poll Security**: Password protection and invite-only options

##### Event Management

- **Event Creation**: Create final events from poll results
- **Google Calendar Integration**: Sync events with Google Calendar
- **Availability Check**: Check participant availability via Google Calendar
- **Calendar Exports**: Export events to Google Calendar and Outlook

##### User Management

- **Authentication**: Login via email/password or Google OAuth
- **Profile Management**: User dashboard for managing polls and votes
- **Invitation System**: Send email invitations to participants
- **Admin Controls**: Special privileges for poll creators

##### Localization

- Multi-language support (English, Czech)
- Timezone support for global meetings

##### UI/UX

- Responsive design using Bootstrap 5
- Dark/Light theme toggle
- Real-time updates with Livewire
- Interactive calendar for date selection

#### Technical Stack

- Laravel 12 with PHP 8.3
- Livewire 3 for reactive components
- Bootstrap 5 for UI
- Alpine.js for client-side interactivity
- MariaDB for data storage
- Google Calendar API integration

#### Initial Setup

- Docker support with Laravel Sail
- Email notifications (optional)
- Comprehensive configuration options
- MIT License

This is the first public release of MeetVote, developed as a bachelor's thesis project at Prague University of Economics and Business.

## [v11.0.0 (2023-02-17)](https://github.com/laravel/laravel/compare/v10.3.2...v11.0.0)

Laravel 11 includes a variety of changes to the application skeleton. Please consult the diff to see what's new.
