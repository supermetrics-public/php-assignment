# super-assignment

This application connects to a fictional social media network. One endpoint registers a token and the other endpoint fetches posts made by fictional users across a 6 month period.

## Dependencies

You should be running PHP 8.0+, the latest version of composer and available to use command line on your machine for any commands listed below. How you run PHP is up to you!

* `guzzlehttp/guzzle` - to make API calls
* `symfony/cache` - not to disturb the API much
* `vlucas/phpdotenv` - to keep some config data out of files

## Local setup

**1. Run docker-compose:**
To build the container to run the assignment in, run command `docker-compose up --build`. This will create container `php_assignment` in Docker project `supermetrics`.

The container will be listening on port `7777` on your `localhost`.

## Run application
Application can be reached from the localhost: 
[http://localhost:7777](http://localhost:7777) - shows the main page.

## Testing

**Run tests:**

1. **Connect to container:**
Connect to container by running command `docker exec -it php_assignment /bin/bash`.

2. **Change path:**
Previous command should take you to path `/app`, but make sure of that by running command `cd /app`.

4. **Run tests:**
Run the tests with command `./vendor/bin/phpunit`.

## Notes about the API endpoints

This application is using two custom API endpoints

**POST: https://api.supermetrics.com/assignment/register**

This endpoint registers a token for use against the second endpoint

PARAMS:
```
client_id: ju16a6m81mhid5ue1z3v2g0uh
email: your@email.address
name: Your Name
```

RETURNS:
```
sl_token: This token string should be used in the subsequent query. Please note that this token will only last 1 hour from when the REGISTER call happens. You will need to register and fetch a new token as you need it.
client_id: returned for informational purposes only
email: returned for informational purposes only
```



**GET: https://api.supermetrics.com/assignment/posts**

This endpoint fetches posts along a number of pages using the registered token.

PARAMS:
```
sl_token: Token from the register call
page: integer page number of posts (1-10)
```

RETURNS:
```
page: What page was requested or retrieved
posts: 100 posts per page
```


