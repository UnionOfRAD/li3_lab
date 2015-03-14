# The Lithium Lab

The lab has 3 main purposes detailed below.
The goal is to enable command line and browser-based management of community plugins.

## 1. Kickstarting app/plugin development 

Allows you to extract app and plugin templates, as a boilerplate for 
developing your app or plugin.
   
```
li3 library extract app my_app
li3 library extract plugin my_plugin
```

## 2. Uploading/Downloading libraries to the Lab Server

```
li3 library push
li3 library find
```

## 3. Your own Lab / The Lab Server

Although the Lab is the official plugin repository for Lithium, you can create your own plugin 
repository by downloading and installing the li3_lab plugin. Before beginning, make sure you 
have downloaded and installed CouchDB.

```
li3 server install
```

## History

When we begun working on lithium there was no sufficient package manager for PHP available. 
The lab was our take on providing such a service and was lead by gwoo. A server was actually
running for some time at lab.lithify.me. However when other solutions were favored by the 
community we stopped develiping lab further. 

Still the code is here and wildly functional, with absolut great test coverage. It's left
here - intact - should we ever decide that other solutions aren't ours.

There is a stale branch where the lab server's database was ported over to MongoDb, which
is worth taking a look at.

Some of the code here (mainly the library command) was originally part of lithium. It 
has been extracted and moved here (together with its tests).

