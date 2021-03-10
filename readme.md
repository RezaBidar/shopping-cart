##Geeks Assessment: Shopping Cart

#### Technologies
- PHP 7
- Symfony: 4.4
- MySql: 5.7
- Doctrine Orm
- Twig
- PHPUnit

#### How to start
```
composer install
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load 
symfony serve
  
  ```

#### routes
```
GET  /                  homepage
GET  /login             login page
GET  /logout            logout page
GET  /products?name=    products search
GET  /cart              shopping cart view
POST /cart/push         add a product to shopping cart
POST /cart/pop          remove a product from shopping cart
POST /order/submit      submit the order
GET  /order/{id}        view order details
```

#### Info
- Name: Reza Bidar
- Email: reza.bidar.dev@gmail.com