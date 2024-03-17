# Project Name

This is a personal project in my journey to learn PHP and Laravel. 
In this project, there are routes that allow users to Register, Authenticate and perfom CRUD operations with images. The images are saved in a AWS S3 bucket.

## Technology Stack

- Laravel
- JWT-Auth
- AWS S3
- MySQL (or whatever database you're using)

## Routes
- `POST /users`: Create a user.
- `POST /login`: Authenticate the user.
- `POST /image`: Uploads an image to AWS S3 and stores the image URL in the database.
- `GET /images`: Get all the images.
- `GET /users/{userId}/images`: Get all the images from a certain user.
- `GET /image/{imageId}`: Get an image from the database.
- `DELETE /image/{imageId}`: Deletes an image from the database.

## Setup

1. Clone the repository: `git clone https://github.com/username/repository.git`
2. Install dependencies: `composer install`
3. Copy the `.env.example` file to `.env` and fill in your AWS and database credentials.
4. Run the database migrations: `php artisan migrate`
5. Start the server: `php artisan serve`

## Usage

`POST /users:` To create a new user, make a POST request to /users with the user's information in the request body. The request body should be a FORM URL ENCONDED object with fields for name, email, and password.

`POST /login`: To authenticate a user, make a POST request to /login with the user's email and password in the request body. The request body should be a FORM URL ENCONDED object with fields for email and password. Then it will return the user Token that is valid for 1 Hour.

`POST /image`: To upload an image, make a POST request to /image with the image file in the image field of the request body. The image file should be sent as MultiPart form data.

`GET /images`: To get all images, make a GET request to /images. This will return a JSON array of all images.

`GET /users/{userId}/images`: To get all images from a certain user, make a GET request to /users/{userId}/images, replacing {userId} with the ID of the user. This will return a JSON array of all images from the specified user.

`GET /image/{imageId}`: To get a specific image, make a GET request to /image/{imageId}, replacing {imageId} with the ID of the image. This will return a JSON object with the image's information.

`DELETE /image/{imageId}`: To delete an image, make a DELETE request to /image/{imageId}, replacing {imageId} with the ID of the image. This will delete the image from the database and return a 204 status code.

