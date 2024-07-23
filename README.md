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
