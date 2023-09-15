# Description

This module allows you to analyze all the webapi rest done call toward your magento. 

# Fork

**This forked version only logs external requests in error.**

- [[a59ed06](https://github.com/magentix/module-webapi-logs/commit/a59ed068c3709c185a6437fcc22deb114e967d08#diff-ae26970ecab7df39eaa665075d03301cf7956854b75cebfb30caaac85570df37)] Do not log API Ajax requests (from Magento frontend, like cart and checkout)
- [[a59ed06](https://github.com/magentix/module-webapi-logs/commit/a59ed068c3709c185a6437fcc22deb114e967d08#diff-615f9126e7b3d9fc5c7cbe97fd8e8c8ba225ca5824fc34ef5c90e5a7645dc8a1)] Do not keep requests in status 200 success

# Install

*composer.json*

```json
{
  "repositories": {
    "ghostunicorns/module-webapi-logs": {
      "type": "vcs",
      "url": "https://github.com/magentix/module-webapi-logs.git"
    }
  }
}
```

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

If you disable the Secret Mode this module will logs everything passes in the webapi calls (tokens and passwords too!), then remember to clean logs by clicking the `Delete All Logs` button:

<img src="https://github.com/ghostunicorns/module-webapi-logs/blob/main/screenshots/screen4.png" />

# Contribution

Yes, of course you can contribute sending a pull request to propose improvements and fixes.

