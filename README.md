### WordPress Plugin Scaffold

Plugins are ways to extend and add to the functionality that already exists in WordPress. The core of WordPress is designed to be lean and lightweight, to maximize flexibility and minimize code bloat. Plugins then offer custom functions and features so that each user can tailor their site to their specific needs.

This project offers a very simple scaffold with the necessary files to start building a plugin for this platform, including unit-tests without the complexity added by other tools and/or tutorials available on the Internet. However, if your project is serious enough I strongly recommend you to use [WP-CLI](https://wp-cli.org/) instead because it offers more options and better structure.

### Bootstrap

The basic configuration for the PHP-Unit bootstrap file is to include the starter script provided by WordPress in their development branch, then include the file that contains the function that will be used to manually load the plugin.

This project goes beyond that and includes code that will automatically download a fresh copy of WordPress, generate a basic configuration file, and insert a condition in the installer script to skip the truncation of the database, this will speed-up the execution time of simple test cases when filtering using `phpunit --filter=foobar`. If you are executing all the test cases then you have to pass an environment variable `WP_TRUNCATE_DB=true`, this will add a delay of around `4 secs` depending on what type of disk you have in your computer, normally with an SSD you will not notice the difference but in other cases the four seconds delay to execute one or two tests is a turn off.

### Configuration

The configuration file used for the tests assumes that you have a database named _"wordpress"_ that must not contain important data because every time the installer is executed the database will be truncated. Additionally, it assumes that there is an account named _"root"_ identified by _"password"_ which you can easily change editing the _"tests/bootstrap.php"_ file. The base URL for the website is set to be _"wordpress.test"_ by default, make sure to include this in your hosts file pointing to the localhost address.

You can also access the administration dashboard using the username _"admin"_ identified by _"password"_. These are defined in the installer script and can not be changed unless you keep a copy of the WordPress repository at hand.

```shell
export MYSQL_PWD=password
mysql -u root -e "CREATE DATABASE IF NOT EXISTS wordpress;"
echo "127.0.0.1    wordpress.test" | sudo tee -a /etc/hosts
```

### Unit-Tests

By default the project assumes that you are going to make use of [PHPUnit](https://phpunit.de/) to provide automated tests for the code that will power the plugin. New test files must be stored in the _"tests/"_ folder and the implemented classes must extend _"WP_UnitTestCase"_. Also, make sure to name the files following this convention: `test-testname.php`

```shell
$ tree
.
├── phpunit.xml
├── README.md
├── tests
│   ├── bootstrap.php
│   ├── test-dependencies.php
│   └── test-pluginaction.php
├── uninstall.php
└── wpplugin.php
```

### More Information

- [WordPress Automated Testing](https://make.wordpress.org/core/handbook/testing/automated-testing/phpunit/)
- [WP-CLI Plugin Unit-Tests](http://wp-cli.org/docs/plugin-unit-tests/)
- [WP-CLI Plugin Sample](https://github.com/wp-cli/sample-plugin)
