# Event Management

custom drupal 9 module that will assist the back-end users in managing events that the end-users will browse.


# Table of contents
- [Event_Management](#event-management)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configurations](#configurations)
- [Documentation](#documentation)


# Features
* ### Back-end
    * CRUD to manage events.
    * The module has a configuration page with:

        * The option to show or hide past events.
        * A number of events to list on the listing page.

    * During module installation, a custom database table will be created. This table is used to log when the user changes the module's configuration.


* ### Front-end
    * Page to list published events.
    * Details page for events.
    * Drupal block to list the latest 5 created events

# Requirements
- PHP => `8.0`
- MySql => `8.0`
- Drupal => `9.0`

# Installation

Run the following Command in your cli.

`composer require mr-developer/event-management`

# Configurations

Once its done installing

1. add new category
  - go to `Admin > Structure > Taxonomy`
  - add New Taxonomy with name `Event Category`
  - add new categories in it and you will find it show automatically in category when you add or edit event

2. change module settings
  - go to `Admin > Configuration > Event settings`
  - you will find checkbox for hiding past events
  - you will find inputbox for define number of events in page

3. add new event
  - go to `Admin > Content > Events`
  - you will find a table to add , edit , delete events

4. add Latest Events Block
  - go to `Admin > Structure > Views`
  - edit any view
  - press `add block` button
  - search for Latest Events and select it
  - you can change the view and layout by block configuration

5. View Events List
  - just go to `/events`


# Documentation

See full documentation in the [wiki page](https://github.com/mr-developer/event-management/wiki).
