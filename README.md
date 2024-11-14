<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Project README

## Overview
This project is a test task for a programmer. It involves creating a Telegram bot integrated with a web server and Trello API to automate project management functions, such as notifying task status changes in Trello and generating task allocation reports within a Telegram group. The bot facilitates task tracking and efficient team communication for a Project Manager (PM) and their team.

## Project Structure
- **Telegram Bot**: A bot registered in Telegram, used to communicate with users and receive/send task updates.
- **Web Server**: A server set up to handle webhook requests from both Telegram and Trello, along with a database for storing user data.
- **Database**: Stores user data, task statuses, and integration details between Telegram and Trello.
- **Trello API Integration**: Tracks changes in Trello boards and communicates updates through the Telegram bot.

## Task Breakdown

### 1. Register Telegram Bot
- **Objective**: Create a Telegram bot to serve as the main interaction point with users.
- **Result**: A registered Telegram bot ready for further configuration.

### 2. Configure Web Server
- **Objective**: Set up a web server that can receive webhook requests from the Telegram bot and respond to users. Additionally, configure a database for storing user data and task information.
- **Result**: A functioning server that can handle the `/start` command from the bot and save user details in the database.

### 3. Create Telegram Group Chat
- **Objective**: Set up a Telegram group chat and add the PM.
- **Result**: A group chat is created, and the PM is added.

### 4. Initialize Bot with PM
- **Objective**: Configure the bot to respond to the PM’s `/start` command by saving the PM’s details in the database and sending a personalized greeting.
- **Result**: The bot records the PM in the database and greets them by name.

### 5. Set Up Trello Board
- **Objective**: Create a Trello board with columns "InProgress" and "Done". Add the PM with editing permissions.
- **Result**: A Trello board is created with the specified columns, and the PM is granted editing rights.

### 6. Configure Trello Webhook API
- **Objective**: Develop an API to receive Trello webhook notifications on card movements between "InProgress" and "Done" columns and forward these updates to the Telegram group.
- **Result**: An API is created that relays Trello card movements to the server, which then sends these updates via the Telegram bot to the group.

### 7. Optional: Generate Task Report (Advanced)
- **Objective**: Enable users to link their Trello accounts to Telegram. The bot should provide a report on task allocation within the group, showing tasks each user is working on.
- **Result**: The PM can link their Telegram and Trello accounts and request a report of tasks per group member.

**Details**: New group members who are not linked to Trello will appear in reports without any current tasks.

## Requirements
- **Tech Stack**: PHP 8.1, Laravel 10
- **API & Webhooks**: Familiarity with Telegram Bot API and Trello API/Webhooks is required.



## Additional Setup Notes

### Environment Configuration
1. **Environment Variables**: The `.env.example` file contains all necessary keys and configuration settings required for the project. Copy this file to `.env` and replace placeholders with actual values before running the project.

### Testing with ngrok
2. **Using ngrok Instead of a Web Server**: For testing purposes, ngrok was used as a tunneling tool to expose the local server to the internet.

    - **Start Local Server**: Run `php artisan serve` to start the Laravel development server locally. This command will provide an IP and port (usually `127.0.0.1:8000`) that ngrok will use as the target.

    - **Configure ngrok**: Run `ngrok http [PORT]` (e.g., `ngrok http 8000`) to create a public URL that tunnels requests to your local Laravel server.

    - **Update APP_URL in .env**: Take the generated ngrok URL (e.g., `https://abcd1234.ngrok.io`) and set it as `APP_URL` in your `.env` file. This ensures that webhook callbacks and other external requests correctly reach your local server.

### Example `.env` Setup
Ensure `.env` has the following settings configured:

```dotenv
APP_URL=https://abcd1234.ngrok.io  # Replace with your actual ngrok URL

# Telegram Bot Settings
TELEGRAM_TRELLO_WEBHOOK_URL="${APP_URL}/telegram/webhookTrello"
TELEGRAM_TRELLO_BOT_NAME=your_bot_name
TELEGRAM_TRELLO_BOT_TOKEN=your_telegram_bot_token

# Trello API Settings
TRELLO_API_KEY=your_trello_api_key
TRELLO_TOKEN=your_trello_api_token
TRELLO_WEBHOOK_URL="${APP_URL}/api/trello/webhook"
```
