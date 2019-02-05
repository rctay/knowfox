- Generate database passwords:

  ```console
  $ < /dev/urandom base64 | tr -d '/+' | head -c 20 > secrets/root_db_password
  $ < /dev/urandom base64 | tr -d '/+' | head -c 20 > secrets/knowfox_db_password
  ```

- Setup knowfox configuration file with the `APP_KEY`:

  ```console
  $ cp .env.example .env

  # fill this in secrets/knowfox-env in APP_KEY
  $ printf "base64:%s=\n" $(< /dev/urandom base64 | tr -d '/+' | head -c 43)
  base64:0CYqu...=
  ```

- Fill in your mail configuration in `.env`.
- Start the Knowfox container and its database dependency with `docker-compose up`.

## Notes

- It sure is convenient to start a local SMTP server, but there are implications on sending email from your own IP address. If you are fine with it, it can be you can apply the patch below to start a local SMTP server and expose it to Knowfox.

  ```console
  $ <<EOF git apply
  diff --git a/docker-compose.yml b/docker-compose.yml
  index 7f286be..1221a20 100644
  --- a/docker-compose.yml
  +++ b/docker-compose.yml
  @@ -13,12 +13,19 @@ services:
         "
       depends_on:
         - db
  +      - email
       environment:
         DB_CONNECTION: mysql
         DB_HOST: db
         DB_PORT: 3306
         DB_DATABASE: knowfox
         DB_USERNAME: knowfoxapp
  +      MAIL_DRIVER: smtp
  +      MAIL_HOST: email
  +      MAIL_PORT: 587
  +      MAIL_USERNAME: null
  +      MAIL_PASSWORD: null
  +      MAIL_ENCRYPTION: null
       secrets:
         - knowfox_db_password
     db:
  @@ -34,6 +41,12 @@ services:
       secrets:
         - root_db_password
         - knowfox_db_password
  +  email:
  +    image: boky/postfix
  +    ports:
  +      - "587"
  +    environment:
  +      ALLOWED_SENDER_DOMAINS: post.knowfox.com
  
   secrets:
     knowfox_db_password:
  EOF
  ```