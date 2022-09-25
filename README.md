**DEVELOPMENT STACK**
|name   |version|language|
|:---:  |:---:  |:---:   |
|symfony|6.1    |php     |
|mysql  |8.0    |sql     |
---
**VERY QUICK START**
- open ubuntu terminal window and run commands:
- `cd ~/ && sudo service apache2 restart && sudo service mysql restart && git clone git@github.com:thomashuynh795/symfony-api-crud && cd symfony-api-crud/server/ && composer install && symfony console doctrine:database:create && symfony console make:migration`
- `symfony console doctrine:migrations:migrate`
- `symfony serve`
---
**IN POSTMAN**

create requests in postman with the following config:

headers:
|key         |value           |description|
|:---:       |:---:           |:---:      |
|content-type|application/json|           |

body raw json:
```
{
    "firstname": "",
    "lastname": "",
    "email": "",
    "address": "",
    "address": "",
    "birthdate": "",
    "phoneNumber": ""
}
```
with routes:
- http://localhost:8000/contact/post
- http://localhost:8000/contact/get
- http://localhost:8000/contact/get/:id
- http://localhost:8000/contacts/put/:id
- http://localhost:8000/contacts/patch/:id
- http://localhost:8000/contacts/delete/:id