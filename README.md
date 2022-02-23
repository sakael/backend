
## Installation

Run it with docker 

It will take a couple of minutes to be ready

```bash
docker-compose up -d --build
```
    
# Test

A micro api with a single get and post endpoints


## API Reference

#### Get all items

```http
GET /items
```


#### Create item

```http
GET /items/create
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `name`      | `string` | **Required**. |
| `phone_number`  | `string` | **Not Required**. |
| `description`      | `string` | **Not Required**. |



## Running Tests

To run tests, run the following commands

```bash
cd src/
php bin/console --env=test doctrine:schema:create // to create table in test database
php ./vendor/bin/phpunit
```

