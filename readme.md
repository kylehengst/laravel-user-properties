# User Properties

- Create your database
- Create ```.env``` file
- Run ```php artisan key:generate```
- Install ```composer install```
- Ensure ```storage``` folder is writable
- Migrate ```php artisan migrate```
- Test ```phpunit```

## API

POST ```/api/users```

- Required: name, email, password[min:3]
- Returns api_token

POST ```/api/users/signin```

- Required: email, password
- Returns api_token

GET ```/api/properties```

- Params: user_id, latitude, longitude, radius
- Returns array of properties if any

Eg: ```/api/properties?latitude=51.6448554&longitude=-0.3004618&radius=100```

PUT ```/api/properties```

- Allows owner to update property
- Required: api_token, name, longitude, latitude



