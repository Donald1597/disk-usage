# Disk Usage Package for Laravel

**Disk Usage Package** is a Laravel package designed to monitor and manage disk usage within your Laravel application. It provides an intuitive interface to view and manage disk usage statistics, making it easier to keep track of your project's storage.

## Features

- View the total size of the Laravel project directory.
- Monitor server disk space including total, free, and used space.
- Visualize disk usage with interactive charts.
- Detailed view of directory contents including file size and type.
- Option to delete files and directories directly from the interface.

## Installation

1. **Add the Package to Your Project**

   You can install the package via Composer. Run the following command in your Laravel project directory:

   ```bash
   composer require donald1597/disk-usage
   ```

2. **Add the Service Provider to your `config/app.php`:**

   Open your `config/app.php` file and add the following line to the `providers` array:

   ```php
   Donald1597\DiskUsage\Http\DiskUsageServiceProvider::class,
   ```

3. Publishing the Configuration

```php
php artisan vendor:publish --provider="Donald1597\DiskUsage\Http\DiskUsageServiceProvider" --tag=config
```

4. Make sure to set these variables in your .env file: for example

```bash
DISK_USAGE_THRESHOLD_PERCENTAGE=1
DISK_USAGE_THRESHOLD_ABSOLUTE=1048576
DISK_USAGE_NOTIFICATION_EMAIL=user@example.com
```

5. Set Up Queues for Notifications

## Notification

When disk usage exceeds the defined thresholds, an email notification will be sent to the address specified in DISK_USAGE_NOTIFICATION_EMAIL.

To handle email notifications asynchronously, you need to configure Laravel queues. Follow these steps:

Configure the Queue Driver

In your .env file, set up the queue driver:

```bash
QUEUE_CONNECTION=database
```

You can also choose other queue drivers like redis or sqs depending on your setup.

Create a Queue Table

If you are using the database queue driver, create the necessary tables by running:

```bash
php artisan queue:table
php artisan migrate
```

6. Run the Queue Worker

Start the queue worker to process the queued jobs:

```bash
php artisan queue:work
```

## Usage

After installation, you can access the disk usage dashboard via the route: disk-usage

## Uninstallation

To uninstall the package:

1. **Remove the package via Composer:**

   ```bash
   composer remove donald1597/disk-usage
   ```

2. **Remove the Service Provider from `config/app.php`:**

   Open your `config/app.php` file and remove the following line from the `providers` array:

   ```php
   Donald1597\DiskUsage\Http\DiskUsageServiceProvider::class,
   ```

3. **Clean up any published assets or configurations if necessary.**

## Contributing

Feel free to contribute to this package by opening issues or submitting pull requests.

## License

This package is licensed under the [MIT License](LICENSE).
