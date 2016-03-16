#Another of Many Simple Web Dashboards

It's even in PHP!

It was just supposed to be a way to monitor les.net account balance, but then I thought I may as well monitor server load, and then I thought I should make it easy to add more widgets.

It's very simple, cute, responsive, and simply cutely responsive. It probably won't look good in older browsers. Only tested in Firefox (latest stable). Also requires a unicode font or else some of the icons won't work.

Not recommended for internet-facing servers, at least until there's been more testing.

Licensed under GPLv3

##Installation

Just needs php (version 5 or 7), and the `curl` extension.

Put it in a web-accessible directory. Move `config.sample.php` to `config.php` and edit it. Make sure your permissions are `700` or so, at least for your config since it has api keys and stuff in it. Also, make sure that your server respects `.htaccess` files, or configure your server manually to not serve up your config file or the `.git` directory. *This is very important, or else you will be serving up your config file, complete with API keys, to the public!*

##Plans For The Future

###Features

- Grouping of widgets, titles for groups. Maybe ability to collapse/expand groups
- Caching of data cross-request, perhaps using CHDB or something similar, so that many users querying at once will not hammer upstream APIs
- Add a webfont. Also maybe a dedicated icon font.

###Widgets

- Memory usage, temperature, disk usage, CPU usage, uptime, load. Also some small remote script and an option to pull from a remote host so that one can monitor a bunch of servers at once. This will require a widget format that allows supplying params from the config file, and will benefit from grouping (so you can group by host). This is what would make this actually useful to people.
