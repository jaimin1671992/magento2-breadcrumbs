# Magento 2 Breadcrumbs

This module add full Breadcrumb of the product detail page. Using this module, customer will get full Breadcrumb path either customer will come from search page, Google, Category page or open direct URL.

# New Features

- Show full Breadcrumb in the product detail page
- Customer can navigate to the category from Breadcrumb
- Customer will get full breadcrumb from the search result.
- CUstomer will get full breadcrumb if open direct URL.


# Use below code for CMS page and Static Block

<b>To show Full Breadcrumb</b>

Override Native Magento Breadcrumbs.phtml to the theme in below location
<code>app/design/frontend/XXX/XXX/Magento_Theme/html/breadcrumbs.phtml</code>

# Installation Instruction

* Copy the content of the repo to the Magento 2 app/code/Jaimin/Breadcrumb
* Run command:
<b>php bin/magento setup:upgrade</b>
* Run Command:
<b>php bin/magento setup:static-content:deploy</b>
* Now Flush Cache: <b>php bin/magento cache:flush</b>

# Support

If you encounter any problems or bugs, please <a href="https://github.com/jaimin1671992/magento2-breadcrumbs/issues">open an issue</a> on GitHub.
