Knowfox is a _Personal Knowledge Management_ tool. To do its job, you need to install it somewhere. 

## Install Knowfox locally

The simplest way to get a Knowfox is to install it on your local machine.
Again, the easiest is to do so on a Mac. This is because Knowfox is built in Laravel, the popular PHP framework. But don't fret, you don't need to be a PHP programmer to _use_ Knowfox. However, in this section, we use some free tools from the Laravel ecosystem to simplify things, most notably [Valet](https://laravel.com/docs/5.4/valet). Valet is awesome, small and blazing fast, but it requires some pieces of software locally install and it only runs on Macs.

Here is the recipe. The first few steps are just taken from the documentation of Valet. During the installation, you will need a _Terminal_ window.

* Install or update [Homebrew](http://brew.sh/) to the latest version using brew update.
* Install PHP 7.1 using Homebrew via `brew install homebrew/php/php71`.
* Install [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).
* Install Valet with Composer via `composer global require laravel/valet`. Make sure the ~/.composer/vendor/bin directory is in your system's "PATH".
* Run the `valet install` command. This will configure and install _Valet_ and _DnsMasq_, and register Valet's daemon to launch when your system starts.

With these steps completed, you have a webserver installed that automatically starts each time your machine boots. If you issue just one other command `valet domain app`, you can already `ping knowfox.app` and should get a successful response.

For Knowfox, the next thing you need is a database, so install one with `brew install mysql` and start it with `brew services start mysql`.

Next, you need to get the Knowfox software and put it somewhere. We just assume here you want to put it in a directory within ~/Sites. If you don't have this directory, `mkdir ~/Sites` and go there with `cd ~/Sites`. Then, point Valet to this directory by issuing `valet park`.

Now, please go to the [Knowfox release directory](https://github.com/oschettler/knowfox/releases), click on the green button for latest release and then on _Source code (zip)_ to download the software.

If you use Chrome as your browser, you can double click on the file you just downloaded. A Finder window will open with the unpacked software. Rename the resulting directory to just `knowfox` and move it to `~/Sites`. 

In your _Terminal window, `cd ~/Sites/knowfox`, then `composer install`. This will download all the dependencies and will take a few seconds. Now, you will configure Knowfox by setting up a file `.env`. Copy the example over with `cp .env.example .env` and edit it with `nano .env`.

![dot-env](https://raw.githubusercontent.com/oschettler/knowfox/doc/dot-env.png)

You will need to edit only a few things here. First, the database credentials.

````
DB_DATABASE=knowfox
DB_USERNAME=root
DB_PASSWORD=root
````

Next, you need to set up a mailer to be able to register yourself a user. The easiest is to use a free account with [mailtrap.io](https://mailtrap.io). Create yourself a free account there and enter the username and password:

![mailtrap](https://raw.githubusercontent.com/oschettler/knowfox/doc/mailtrap.png)

````
MAIL_USERNAME=111111111111
MAIL_PASSWORD=azazazazazaz
````

Finally, if you want to use bookmarking, you need to enter an application key for [Mercury](https://mercury.postlight.com/web-parser/). Bookmarking uses this service to extract the content and key image from the bookmarked resource. Again, create yourself a free account there and enter the application key into your `.env` file:

````
# https://mercury.postlight.com/web-parser/
MERCURY_KEY=abcdef1234567890
````

Save and exit. Next you need to create an application key with `php artisan key:generate`. You are now ready to create a database with `echo "create database knowfox" | mysql -uroot -proot` and `php artisan migrate`. 

Two more steps are needed to build and install the frontend stuff and fonts:

* `npm install`
* `npm run production`

With that, you can open Knowfox in your browser at `http://knowfox.app`. This is what it looks like:

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

This concludes our first installment on how to get started with Knowfox.

Know more and have fun,
-- Olav