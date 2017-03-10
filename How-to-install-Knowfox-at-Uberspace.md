**Uberspace** is a high quality German Hosting Service Provider. They are special in that they provide very competitive features of a fully managed web hosting package for a very good price. In particular, you get 10GB space for your data and media. Also, they do provide full SSH access which is required for installing Knowfox.

Here we go ...

First, register yourself an account. Uberspace offers a full trial month. You don't need to provide payment credential to get started. So, go to https://uberspace.de/ and register by clicking on 

![ja](https://github.com/oschettler/knowfox/raw/doc/ja.png)

Then, you have to choose a username 

![olav](https://github.com/oschettler/knowfox/raw/doc/olav.png)

... and fill in some minimal personal data:

![profile](https://github.com/oschettler/knowfox/raw/doc/profile.png)

Finally, click on _Make it so_.

![make](https://github.com/oschettler/knowfox/raw/doc/make.png)

With that, your Uberspace is already reachable on the web. Mine is at https://olav.hadar.uberspace.de/

On the [Uberspace Dashboard](https://uberspace.de/dashboard/authentication), you now have to configure your SSH access. This can either be password-based or, as I have chosen to do, using an SSH key.

But, before you can enable passwordless access, you need to create yourself an SSH key on your local machine. On a Mac, open a Terminal and type the command

````
ssh-keygen -f ~/.ssh/uberspace
````

Choose an empty passkey by pressing ENTER twice.

Next, add the following paragraph at the end of your file ~/.ssh/config:

````
Host uberspace
  Hostname hadar.uberspace.de
  User olav
  IdentityFile ~/.ssh/uberspace
````

Change the hostname and username to the settings from your _Uberhost DATENBLATT_.

Now you can proceed to install Knowfox on your shiny new Uberhost. Here are the steps:

````
ssh uberspace

wget https://getcomposer.org/installer
php installer

wget https://github.com/oschettler/knowfox/archive/v0.2.2.tar.gz
tar xzf v0.2.2.tar.gz

# Change "olav" to your account name
mv knowfox-0.2.2/* /var/www/virtual/olav
cd /var/www/virtual/olav

rm -rf html
mv public html

~/composer.phar install

cp ~/knowfox-0.2.2/.env.example .env

cat ~/.my.cnf
````

take note of 2nd password

Edit the file ".env" with the command `nano .env` and change the following values (Change "olav" to your account name)

````
DB_DATABASE=olav
DB_USERNAME=olav
DB_PASSWORD=xyzxyzxzy
````

Next, you need to set up a mailer to be able to register yourself a user. The easiest is to use a free account with mailtrap.io. Create yourself a free account there and enter the username and password:

![mailtrap](https://raw.githubusercontent.com/oschettler/knowfox/doc/mailtrap.png)

From this, change the following two variables in .env

````
MAIL_USERNAME=111111111111
MAIL_PASSWORD=azazazazazaz
````

Save and exit the editor. Next you need to create an application key and set up the database:

````
php artisan key:generate
php artisan migrate
````

One more step is needed to build and install the frontend stuff:

* `npm install`

With that, you can open Knowfox in your browser at `https://olav.hadar.uberspace.de/`. This is what it looks like:

![home](https://raw.githubusercontent.com/oschettler/knowfox/doc/home.png)

Click on _Register_ and create yourself a user:

![register](https://raw.githubusercontent.com/oschettler/knowfox/doc/register.png)

After registration, you are redirected to the list of concepts:

![concepts](https://raw.githubusercontent.com/oschettler/knowfox/doc/concepts.png)

To start journaling, you first need to create a Journal root:

![journal](https://raw.githubusercontent.com/oschettler/knowfox/doc/journal.png)

At this point, you have a few options:

* Start a journal by clicking on the current date. 
* Create a new concept
* Install the bookmarklet into your browser's bookmark bar and start collecting bookmarks.

Here is what a journal entry looks like:

![entry](https://raw.githubusercontent.com/oschettler/knowfox/doc/entry.png)

This concludes the second variant of how to get started with Knowfox.

Know more and have fun,

-- Olav
 