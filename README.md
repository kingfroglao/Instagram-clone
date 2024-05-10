# Instagram-clone
## Description
* Users can register an account, log in again, and log out.
* Users can edit their username and email in User Home Page. And change your photo by clicking on your profile photo in your personal page.
* Users can post photos, edit post context, and delete their own posts.
* Users can search for friends' names and enter the friend's homepage. You can click to follow or unfollow.
* Users can comment on any post.  
* Users can like any post.  


## Users
User1: emmay.a@gmail.com  Password:12345678  
User2: tommy@gmail.com   Password:12345678

## Environment Setup
```

composer install 

cp .env.example .env 

php artisan cache:clear 

composer dump-autoload 

php artisan key:generate

composer require laravel/breeze --dev

php artisan breeze:install vue --ssr

```
Start the project 
```
npm i

npm run dev

php artisan serve
```
