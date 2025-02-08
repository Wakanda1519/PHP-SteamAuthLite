# PHP SteamAuthLite
This project implements user authorization through Steam using the OpenID protocol. After successful authentication, the user is assigned a unique Steam ID, which is saved in the session and then displayed on the main page

## Requirements
- The PHP version is at least 7.2

## How to use the library?
URL for request `/SteamAuthLite/Auth.php?success_url=${successUrl}&failure_url=${failureUrl}`, where `success_url` redirect after successful authorization and `failure_url` after unsuccessful. After successful authorization, the library creates a session that stores the user's SteamID

## Example of implementation
![Подсказка к изображению](https://i.imgur.com/P86S3XP.jpeg)
The `index.php` file contains a page where, when you click on the button, a new window opens on top of the browser with authorization via Steam, after successful authorization, the window sends the SteamID to the parent page, closing. After this, the page reloads and saves the SteamID in the session
