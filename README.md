Game portal CMS
===============================

A game catalog that fetches the games from Gamespot.com


Installation
---
Run `composer install` to download dependancies.

Run `yii init` in the root folder and follow the two step process to prepare the environment.

Edit `/common/config/main-local.php` with the correct DB details.

Run `yii migrate` to apply DB migrations.

The backend is accessible through /backend/web.
The frontend is accessible through /frontend/web. It is recommended to create virtual hosts to these folders instead of accessing directly.


How to fetch the latest releases from Gamespot?
---

    yii gamespot/scrape-coming-soon-games