## Directives
You can run this project by running the following commmands in succession. 
`cp .env.example .env`,  `vendor/bin/sail up -d`, and `sail artisan migrate --seed`. 

I added some seed data to ensure functionality isn't broken, please be sure to only use the Breed IDs that have a record with https://dog.ceo because I'm not handling any failures in calling that API explicitly.

You can find the routes in the [api.php](./routes/api.php) file, and can easily test this using Postman or any other API client of choice. 

Similarly, the GraphQL queries can also be run using exactly as described in the assessment requirement, either using Lighthouse or Postman or any similar tool.

### Side notes
* I didn't include tests for the application in general.
* I could have made an external API Service class to call dog.ceo and handle the data manipulation
* I found the polymorphic thing a bit confusing, because I'm not sure why we need 'userable', 'parkable', and 'breedable', especially not with the few routes and associativeness required. Hence, you might discover only the parkable and breedable tables have data with them from calling the respective API endpoints. I believe this shows my understanding of the polymorphism concept in general. 
