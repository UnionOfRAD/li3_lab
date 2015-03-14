# The Lithium Lab
[The Lab](http://lab.lithify.me) is the plugin server for Lithium-based applications. 
The goal is to enable command line and browser-based management of community plugins.

## Using the Lab
To interact with the Lab, you can use the 
[command line](http://rad-dev.org/li3_lab/wiki/using/command-line) or 
[your browser](http://rad-dev.org/li3_lab/wiki/using/browser).

## Creating your own Lab
Although the Lab is the official plugin repository for Lithium, you can create your own plugin 
repository by downloading and installing the li3_lab plugin. Before beginning, make sure you 
have downloaded and installed CouchDB.

- Clone the Lab

	git://github.com/UnionOfRAD/li3_lab.git

- Add the Library

	Libraries::add('li3_lab');

- Add the designs and views for CouchDB

	li3 server install

## Notes
Note that we're currently porint li3_lab over to MongoDB and also adding features constantly. 
We recommend that you contact the UnionOfRAD team on #li3 before you start coding and/or adding 
patches for this plugin at the moment.