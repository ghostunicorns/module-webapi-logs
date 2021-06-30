# Description

This module allows you to analyze all the webapi rest done call toward your magento. 

# Install

`composer require ghostunicorns/module-webapi-logs`

# Configure

1. Log-in your Magento backend

2. Go to `Stores > Configuration > System > Webapi Logs` and enable it

<img src="https://github.com/ghostunicorns/module-webapi-logs/blob/main/screenshots/screen1.png" />

# Use

Go to `Reports > Webapi Logs > Show Logs`

<img src="https://github.com/ghostunicorns/module-webapi-logs/blob/main/screenshots/screen2.png" />

You can select an entry to see more details about the request and the response

<img src="https://github.com/ghostunicorns/module-webapi-logs/blob/main/screenshots/screen3.png" />

# Attention!

Enable this module only for debug reason, please don't let it enabled in production environment because it can slow down all your webapi request and overload your database.

This module logs everything passes in the webapi calls (tokens and passwords too!), remember to clean logs by clicking the `Delete All Logs` button:

<img src="https://github.com/ghostunicorns/module-webapi-logs/blob/main/screenshots/screen4.png" />

# Contribution

Yes, of course you can contribute sending a pull request to propose improvements and fixes.

