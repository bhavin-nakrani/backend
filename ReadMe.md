# Symfony commands

#### Install Symfony bundles
```
php composer.phar install
```
OR (If you have installed the composer globally)
```
composer install
```

#### Install Node packages
Make sure that you have installed node.
```
npm install
```

#### Build JS for production
```
npm run build
```

#### Update Database
```
php bin/console do:sc:up --force
```
#### Database migration
```
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```
#### Add Fixture 
```
php bin/console doctrine:fixtures:load --append
```
---append will not delete existing data from table but it will append new data in table

If you want to add particular fixtures with group name then use below command:
```
php bin/console doctrine:fixtures:load --append --group=group1
``` 

#### Export route for javascript usage
```
php bin/console fos:js-routing:dump --format=js --target=public/js/fos_js_routes.js --locale=en
```
This command is added in composer json script. so if you want to export manually then you can use this command.

#### Export translation xlf files
Please mention locale in command whatever you want to generate translation files
```
php bin/console translation:extract en --config=app
php bin/console translation:extract de --config=app
```

#### Generate the SSH keys:

``` bash
$ mkdir -p config/jwt
$ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```

#### API List

* Get Token from login user
```
POST URL: {url}/api/login_check

request:
{
    "username": "beier.kristy@hudson.org",
    "password": "password"
}

response:
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MDEzMDg2MzQsImV4cCI6MTYwMTMxMjIzNCwicm9sZXMiOlsiUk9MRV9BRE1JTiJdLCJ1c2VybmFtZSI6ImJlaWVyLmtyaXN0eUBodWRzb24ub3JnIn0.nn33KUjmXI8wnU-rcnj8KS_TkaQuLU_7K42dOob66xQBLKQNKUzKjJJRZXcI-ZR7CMt41VUI9cO-Ri9E9h8w79734XQttYczxPOo5ya_wM1MtFQch92iYjbJBfo5XL4gFnyQHM4p2e_gy4Ol_UoCtjGS0pd8qsH2b_kNWGAzBrIp70aheu1N1hcrMkq_kuoMYPvop6qLKK0DuLgD-PDa5JOIHpgd7kf8CM_jsuIPzbQEtEtDSGFCbCrX4wrm9uSThKY9pUcZjN1aw135jIfxZTuznyaLPz-JYXXTkbggwJll9_KPAHxf99k0DdPOn8wncjX-4CS4Wtkr3WyEaFxRh6gg7OkE1MDiPEeu4xQM_AypHmWO84BTE64J_i586OqjzuOpA0FbsAxhZ5R4oNJRgXcPKhHFthnvYqMmUYWPwy-HfvqXsPF2rGqir5W_ARJg0xiYawkHQz9dX2AVWzKYh8MN9GvhuHHKm5yR4BbtkEh665oJIaJFRG0EEIf1Cy-SIqZvZ5exMBLRVxQps8bp4or1Ne1t4_r6inv6iP6qMyQXgj9fsxNnv-hBxinyzJI9k1z7mauK4WfQOzEx9xCXsUrZ7Bobxk300lskkWMXkoDKE3mp3ez6xPSQj38XGFBYoC4YeRO5z7hiLEHyzJcaNqMlT-t2km3oRY-5xkO_WU4"
}
```
* Get Category List
```
GET Url: {url}/api/category/list

request header:
'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MDEzMDg2MzQsImV4cCI6MTYwMTMxMjIzNCwicm9sZXMiOlsiUk9MRV9BRE1JTiJdLCJ1c2VybmFtZSI6ImJlaWVyLmtyaXN0eUBodWRzb24ub3JnIn0.nn33KUjmXI8wnU-rcnj8KS_TkaQuLU_7K42dOob66xQBLKQNKUzKjJJRZXcI-ZR7CMt41VUI9cO-Ri9E9h8w79734XQttYczxPOo5ya_wM1MtFQch92iYjbJBfo5XL4gFnyQHM4p2e_gy4Ol_UoCtjGS0pd8qsH2b_kNWGAzBrIp70aheu1N1hcrMkq_kuoMYPvop6qLKK0DuLgD-PDa5JOIHpgd7kf8CM_jsuIPzbQEtEtDSGFCbCrX4wrm9uSThKY9pUcZjN1aw135jIfxZTuznyaLPz-JYXXTkbggwJll9_KPAHxf99k0DdPOn8wncjX-4CS4Wtkr3WyEaFxRh6gg7OkE1MDiPEeu4xQM_AypHmWO84BTE64J_i586OqjzuOpA0FbsAxhZ5R4oNJRgXcPKhHFthnvYqMmUYWPwy-HfvqXsPF2rGqir5W_ARJg0xiYawkHQz9dX2AVWzKYh8MN9GvhuHHKm5yR4BbtkEh665oJIaJFRG0EEIf1Cy-SIqZvZ5exMBLRVxQps8bp4or1Ne1t4_r6inv6iP6qMyQXgj9fsxNnv-hBxinyzJI9k1z7mauK4WfQOzEx9xCXsUrZ7Bobxk300lskkWMXkoDKE3mp3ez6xPSQj38XGFBYoC4YeRO5z7hiLEHyzJcaNqMlT-t2km3oRY-5xkO_WU4'

response:
{
    "success": true,
    "message": "Category List found",
    "categoryList": [
        {
            "id": 1,
            "slug": "technology",
            "name": "Technology"
        }
    ]
}
```
* Get Article List
```
GET URL: {url}/api/article/list

request header:
'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MDEzMDg2MzQsImV4cCI6MTYwMTMxMjIzNCwicm9sZXMiOlsiUk9MRV9BRE1JTiJdLCJ1c2VybmFtZSI6ImJlaWVyLmtyaXN0eUBodWRzb24ub3JnIn0.nn33KUjmXI8wnU-rcnj8KS_TkaQuLU_7K42dOob66xQBLKQNKUzKjJJRZXcI-ZR7CMt41VUI9cO-Ri9E9h8w79734XQttYczxPOo5ya_wM1MtFQch92iYjbJBfo5XL4gFnyQHM4p2e_gy4Ol_UoCtjGS0pd8qsH2b_kNWGAzBrIp70aheu1N1hcrMkq_kuoMYPvop6qLKK0DuLgD-PDa5JOIHpgd7kf8CM_jsuIPzbQEtEtDSGFCbCrX4wrm9uSThKY9pUcZjN1aw135jIfxZTuznyaLPz-JYXXTkbggwJll9_KPAHxf99k0DdPOn8wncjX-4CS4Wtkr3WyEaFxRh6gg7OkE1MDiPEeu4xQM_AypHmWO84BTE64J_i586OqjzuOpA0FbsAxhZ5R4oNJRgXcPKhHFthnvYqMmUYWPwy-HfvqXsPF2rGqir5W_ARJg0xiYawkHQz9dX2AVWzKYh8MN9GvhuHHKm5yR4BbtkEh665oJIaJFRG0EEIf1Cy-SIqZvZ5exMBLRVxQps8bp4or1Ne1t4_r6inv6iP6qMyQXgj9fsxNnv-hBxinyzJI9k1z7mauK4WfQOzEx9xCXsUrZ7Bobxk300lskkWMXkoDKE3mp3ez6xPSQj38XGFBYoC4YeRO5z7hiLEHyzJcaNqMlT-t2km3oRY-5xkO_WU4'

response:
{
    "success": true,
    "message": "Article List found",
    "articleList": [
        {
            "id": 1,
            "slug": "php-class",
            "title": "PHP class",
            "description": "<p>Test <br></p>",
            "shortDescription": "this is test descr",
            "category": "Technology",
            "isPublish": true,
            "author": "admin",
            "createdAt": "2020-09-21 03:52:22"
        }
    ]
}
```