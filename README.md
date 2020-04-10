Virus Path Tracer &middot; [API Server]
===========================================================================

[![](https://github.com/migastone/pathtracer-app/raw/master/docs_images/logo.jpg)](https://www.migastone.com/)

-------------------------------------------------------------------------------

"Project developed from MIGAWIN SRL - SAN MARINO ([www.migawin.com](https://www.migawin.com "www.migawin.com"))  a technological startup founded from [Migastone](https://www.migastone.com/ "Migastone")"

-------------------------------------------------------------------------------

Path tracer is an *App* for **iPhone** and **Android** useful to trace and analyze the interaction of people during a time frame of *past 30 days*.

The App is able to warn if a user was physically near another user marked as **infected**.

The data collection is made anonymous by using the **UUID** of each phone, this allow to keep the *privacy* of each user monitored.

**NOTE: This is server part of the project. For app part visit the [app](https://github.com/migastone/pathtracer-app "app") repository.**

----------------------------------------------------------------------------
![Clients](https://github.com/migastone/pathtracer-server/raw/master/docs_images/clients.png)

![Devices](https://github.com/migastone/pathtracer-server/raw/master/docs_images/devices.png)

![Ledgers](https://github.com/migastone/pathtracer-server/raw/master/docs_images/ledgers.png)

![Ledgers Filtered](https://github.com/migastone/pathtracer-server/raw/master/docs_images/ledgers_filtered.png)

![Registration Settings](https://github.com/migastone/pathtracer-server/raw/master/docs_images/registration_settings.png)

![App Status Screenshots](https://github.com/migastone/pathtracer-server/raw/master/docs_images/app_statuses.png)

Technical Details
===========================================================================

## Installation

The API server is developed in [`Codeigniter`](https://codeigniter.com/ "`Codeigniter`") which is a popular [`PHP`](https://www.php.net/ "`PHP`") framework. So the installation guidelines are the same as [`Codeigniter's Installation`](https://codeigniter.com/user_guide/installation/index.html "`Codeigniter's Installation`").

The database file is included in the repository root with the name of `apivirus_db.sql`. The sample user is also included in the `users` table with the following credentials:

```text
Email: demo@domain.com
Password: demo123
```
The main controller of the app which receives API calls from the mobile app is located under `application/controllers` with the name `Api.php`.


The `Api.php` controller mostly relies on 3 main `models` which includes:

+ `client_model.php`
+ `device_model.php`
+ `ledger_model.php`

The `ledger_model.php` contains the most important functions of the API which includes `getPositionsAndDaysByDeviceId( $device_id )` and `getWarning( $device )`.
