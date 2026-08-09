# Release Notes

## [v0.3.0](https://github.com/laravel/laravel/compare/v0.2.1...v0.3.0) - 2026-08-09

The Bootstrap-to-Tailwind migration is now complete — the Bootstrap dependency has been fully removed from the project. Most of the UI has also been rebuilt on top of MaryUI, replacing the older hand-rolled components.

### Changes

- Removed the Bootstrap dependency entirely
- Migrated remaining components (modals, poll editor, poll show page, authentication pages, user settings) to MaryUI and Livewire 4 components
- Moved old, replaced components to a deprecated directory pending removal
- Upgraded Laravel 12 → 13 and Livewire 3 → 4
- Various smaller UI fixes and code cleanup

### Notes

This release took longer than I'd have liked — other things got in the way and I couldn't code as regularly as I wanted. I want to get back to a steadier rhythm going forward, so v0.4.0 is planned for the near future, focused on new ideas and improvements I didn't want to fold into this release.

## [v0.2.1](https://github.com/laravel/laravel/compare/v0.2.0...v0.2.1) - 2026-05-23

A small maintenance update focused on dependency cleanup and getting the project into a clean state for future development.

### Changes

- Updated Tailwind CSS from v3 to v4 and DaisyUI to the latest version
- Removed unused and outdated dependencies
- Continued migrating remaining components from Bootstrap to Tailwind — only a few parts of the app still use Bootstrap classes, which will be fully removed in the next update
- Minor Docker and application configuration adjustments

## [v0.2.0](https://github.com/laravel/laravel/compare/v0.1.0...v0.2.0) - 2026-05-22

Almost the entire frontend has been rewritten from Bootstrap to Tailwind CSS with DaisyUI. A few parts of the application still use Bootstrap classes — these will be fully replaced and removed in the next update.

### Removed features

Several features have been removed due to implementation quality concerns. They were originally built quickly to meet a university thesis deadline, and will be reintroduced properly in the future once the core functionality is stable and well-optimized:

- Invitations
- Email messaging
- Google account integration

### Notes

This project was put on hold for several months. Returning to it, I decided to draw a line under the old codebase and approach development more deliberately going forward. Future releases should come more frequently — hopefully something meaningful grows out of this. 😄

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
