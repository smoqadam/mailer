## Mailer

to send mail via Sendgrid and SendinBlue APIs. 

### 1. install dependencies

`composer install`

### 2. Run docker

run the following command to start docker:
`docker-compose up`

docker services included: `php`, `nginx`, 'mysql`, 'rabbitmq`

### 3. Start worker

to be able to send emails, we need to run the worker first. I used Laravel queue for this puprose.

`$ php artisan queue:worker`

#### 4. API

send a post request to the following endpoint:

`/mail/send` with the json content:

```
$curl -XPOST http://localhost:8000/mail/send --data '{"name":"NAME", "email":"example@example.com", "subject:"test email", "body":"test <b>email</b>", "isHtml":true}'
```



### 5. Command

This project comes with an interactive command to send an email:

```
$ php artisan mail:send
>name
saeed
>email
example@example.com
> subject
test email
> body
test body
> is HTML? (yes/no)?
yes
> do you want to add it to the queue? (yes/no): 
yes
```
if yes, the email will be added to queue, otherwise it sends the email right away with the Sendgrid provider.

### 6. Tests
run the following command to run the tests:

`./vendor/bin/phpunit`

## Structure

1. Inside the `app/Mail` directory there are some classes as follow:
2. Contracts: interfaces needed for the project
3. Providers: all email providers can be found here. All of them must extends `Provider` or implememnt `EmailProvider`
4. Mailable.php: a simple php object that implemented `Contracts\Mailable` contains email information name, email, subject, etc.
4. Mailer.php: A class that receives a EmailProvider, and tries to send the email.
5. SendQueuedMailable.php: This class receives a `MailerInterface` (`Mailer.php` or any other class that implements the `MailerInterface`), and a collection of providers (`ProviderCollection`) and tries to send the email by each provider. If sending failes, it tries next provider. 
6. `app/Jobs/MailSend` is a Laravel job that registers providers and calls `send` method from  `SendQueuedMailable` class.
7. `app/Collection/Collection.php` is a PHP Collection to simulate strict typed arrays ([more info](https://smoqadam.medium.com/php-strict-typed-arrays-c3a9c36c2589)) 
