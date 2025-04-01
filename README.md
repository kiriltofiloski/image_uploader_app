This is a simple image uploading API made in Laravel 12

### SETUP
1. Make sure you have Docker and Docker Compose installed
2. Copy `.env.example` to `.env` and configure these enivronment variables:

```
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=image_storage
DB_USERNAME=postgres
DB_PASSWORD=postgres
IMAGE_UPLOAD_TOKEN='yourTokenOfChoice'
```

The "IMAGE_UPLOAD_TOKEN" enivornment variable will be used as our authorization token.

3. Build and start the containers

docker compose build
docker compose up

4. Open a new terminal and enter your Laravel app's terminal

docker exec -it image_uploader /bin/bash

5. From this terminal run migrations and create storage link

php artisan migrate
php artisan storage:link




### ENDPOINT AND RESPONSES

The image upload endpoint is located at http://localhost:8000/api/upload and should be accessed trhough a POST method.

**Request**
- Method: POST
- Headers:
  - Content-Type: multipart/form-data
  - Authorization: [your-api-token] (Bearer token)
- Body:
  - `image` (required): The image file to upload
  - `title` (required): Title for the image
  - `description` (required): Description for the image

**Successful response**
{
    "message": "Image uploaded successfully",
    "data": {
        "id": 6,
        "title": "Test Image 2",
        "description": "test desc 3",
        "file_type": "png",
        "file_size": 137386,
        "file_path": "public/images/gAtx6yrVuoglrDmjwQF8cyWEeSASZDPVBPrIMgU0.png"
    }
}

**Missing data response**
{
    "message": "Validation failed",
    "errors": {
        "image": [
            "The image field is required."
        ]
    }
}

**Unauthorized response**
{
    "error": "Unauthorized"
}


### TESTS

A few tests are set up in tests/Unit/ImageUploadTest and can be run with the following command:

php artisan test
