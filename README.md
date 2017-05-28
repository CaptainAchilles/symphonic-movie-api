# symphonic-movie-api
A graphQL and based Laravel web API which allowes for reading and writing of movie related objects. The [API Documentation can be found here](http://docs.movieapi60.apiary.io/). The application is primarily a webapi with a graphql server sitting at `localhost/graphql`, but it also features a basic front-end for creating accounts, viewing your web api token, and using the graphQL graphical editor found at `localhost/graphiql`.

__This is my first project in Laravel, please file issues if you discover problems__

# Getting Started
After cloning this respository:
 * Run  `composer install` to get started. This will bootstrap your enviroment and install the project dependencies.
 * Set up your database information in `.env`
 * Create a database corresponding to the one in your `.env`
 * Run `php artisan key:generate`
 * Run `php artisan config:clear`
 * Run `php artisan migrate` to create the schemas
 * Run `php artisan db:seed` to seed the database. All seeded user accounts have the same password of 'secret'
 * Run `php artisan serve` to serve the application on localhost:8000
 * Create a user account from `localhost:8000/register`
 * Visit `localhost:8000/home` to get your api key
 * Visit `localhost:8000/graphiql` to interact with the graphQL schema and view its structure

# Current Features

* Provides a User / Password based authentication which works with a cookie, and also returns a unique token associated with that user account (See [#1](https://github.com/CaptainAchilles/symphonic-movie-api/issues/1))
* The web API is restricted unless it validates an api key found in the request body
* Provides Queries and Mutations for the main data types of the database (`Actor`, `Genre`, `Movie`). It is not yet full-featured, but it does work. See ([#2])https://github.com/CaptainAchilles/symphonic-movie-api/issues/2))

# Future Work
* Finish implementing Unit tests
* User-based favouriting
* Docker integration
* Thumbnail transcoding
    * When an image is uploaded it will be run through an image processor and scale it to several smaller aspect ratios for different devices, each of which is then stored onto a `image_sizes` table. They are then linked to an image field on the main object and can be queried through that edge.
```javascript
# Request
query {
    actors {
        images {
            original 2x 3x
        }
    }
}

# Response
{
    "data": {
        "actors": [
            "images": [
                "full": // The original
                "2x": // Half size
                "3x": // Third size
            ]
        ]
    }
}
```
