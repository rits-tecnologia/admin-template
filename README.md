## Getting started

### Configuration

```bash
#!/bin/bash

# Require the package
composer require rits-tecnologia/admin-template @dev

# Publish admin-template assets
php artisan vendor:publish --tag=admin-template-assets

# Publish configuration file (optional)
php artisan vendor:publish --tag=admin-template-config

# Publish views (optional)
php artisan vendor:publish --tag=admin-template-views

# Publish translations (optional)
php artisan vendor:publish --tag=admin-template-trans
```
The package does not contain compiled styles nor scripts. You must require the admin template assets from your application assets.

The main dependencies you must require before importing the admin template's assets to your stylesheets are:

- `@fortawesome/fontawesome-free@5.6.3`
- `apexcharts@2.5.1`
- `bootstrap@4.2.1`
- `bootstrap-daterangepicker@3.0.3`
- `bootstrap-markdown@2.10.0`
- `chart.js@2.7.3`
- `datatables.net@1.10.19`
- `datatables.net-bs4@1.10.19`
- `datatables.net-buttons@1.5.4`
- `datatables.net-buttons-bs4@1.5.4`
- `datatables.net-responsive@2.2.3`
- `dragula@3.7.2`
- `feather-icons@4.10.0`
- `jquery@3.3.1`
- `jquery-mask-plugin@1.14.15`
- `jquery-validation@1.19.0`
- `jvectormap-next@3.0.0`
- `markdown@0.5.0`
- `moment@2.23.0`
- `popper.js@1.14.6`
- `quill@1.3.6`
- `select2@4.0.6-rc.1`
- `simplebar@2.6.1`
- `smartwizard@4.3.1`
- `tempusdominus-bootstrap-4@5.1.2`
- `toastr@2.1.4`

After importing those dependencies you may import the newly created `resources/assets/vendor/admin-template/scss/app.scss` file in your CSS and `resources/assets/vendor/admin-template/js/app.js` to your scripts.
