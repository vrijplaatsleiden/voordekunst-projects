Voor de Kunst WordPress Plugin
==============================

Features
--------

This plugin offers a widget and short codes to display the current status of your crowd funding project on 
[https://www.voordekunst.nl](https://www.voordekunst.nl). The Plugin offers a couple of easy ways to display
the status of your Voor de Kunst crowd funding project on your web page.

The following data about your campaign is available:
* project title
* donated amount
* goal amount
* num donors
* percentage donated
* time left (Num days or hours left)
* url of your project

Voor de Kunst web Crawler
-------------------------

The plugin needs a web crawler to fetch the data of your crowd funding project(s) from the voordekunst.nl website. 
The data will be inserted in your Wordpress database. The web crawler needs to be installed separately and can be 
downloaded from our [Github repository](https://github.com/vrijplaatsleiden/voordekunst-crawler). Please read the 
documentation on [https://github.com/vrijplaatsleiden/voordekunst-crawler](https://github.com/vrijplaatsleiden/voordekunst-crawler) for installation 
instructions.  

You need to install this plugin first as it adds a table to your WordPress database needed to store the crawled data.

Install plugin
--------------

1. Download a zip file of this plugin from the [Github project page](https://github.com/vrijplaatsleiden/voordekunst-projects)
2. Select 'Plugins' > 'Add New' in your Wordpress Admin menu
3. Select 'Upload Plugin'
4. Browse to the downloaded .zip file on your local computer and select 'Install Now'


Identify your Voor de Kunst project
------------------------------------

This plugin is able to handle multiple crowd funding projects at once. When you want to display the widget or use one 
of the short short codes you need the id of your Voor de Kunst project. You can find the id of your project from it's 
url. 

For example the project with url: 
https://www.voordekunst.nl/projecten/4873-hart-voor-de-zaal

The id for this project is: 4873

Configure plugin
----------------

Before you can configure your plugin you need to install the 'Voor de Kunst web Crawler' first as the plugin needs
at least one entry containing data of your crowfunding project.

You can customize your widget. Select 'Voor de Kunst' in WordPress Admin Settings menu. In the Settings form you can enter
the location of a project image. The image will be displayed on top of your widget. If you do not add an image it will default to
the Voor de Kunst logo image. Next to the image you can enter a short introduction text advertising your project.

Uninstall plugin
----------------

Caution: if you uninstall the plugin your settings and all the plugin data will be deleted from your Wordpress database.
This can not be undone!

1. select Plugins in your Wordpress Admin menu.
2. tick the box next to the 'Voor de Kunst projects' Plugin
3. select 'Delete' in the 'Bulk Action' select box.
4. click 'Apply'
5. confirm Delete on the next screen

Display widget on your WordPress site
-------------------------------------

1. select Appearance > Widgets in your Wordpress Admin menu.
2. select the Voor de Kunst Widget
3. add it to the area of your choice
4. enter the id of the project you want to display
5. save and enjoy!

Short codes
-----------

The offers a couple of short codes you can use in your WordPress posts.

[More information about WordPress short codes](https://codex.wordpress.org/Shortcode)

Display the percentage donated in your post:
```
[vdk_project_percentage_donated id="your project id"]
```
Display the donated amount in your post:
```
[vdk_project_donated_amount id="your project id"]
```
Display the number of donors donated in your post:
```
[vdk_project_num_donors id="your project id"]
```
Display the days or hours left in your project:
```
[vdk_project_num_days_left id="your project id"]
```
Display the goal amount in your post:
```
[vdk_project_goal_amount id="your project id"]
```
