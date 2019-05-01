# Easy ReCAPTCHA (Google)
Enable & append Google ReCaptcha API to the default WP login page and action. Supports Google ReCaptcha v2, both checkbox and invisible options.


## Setup
1. Obtain a Google ReCaptcha API Key/Secret pair
2. Add the `EASY_RECAPTCHA_SITE_KEY` and `EASY_RECAPTCHA_SECRET` constants to your `wp-config.php` file.
3. Install plugin, and activate.

## Define constants in wp-config
Open the `wp-config.php` file, and look for the area towards the bottom of the file. You will see a comment that says `"That's all, stop editing."`. Place the below code just above that comment. Without these constants defined the plugin will not work.

```php
    define('EASY_RECAPTCHA_SITE_KEY', 'YOUR-KEY');
    define('EASY_RECAPTCHA_SECRET', 'YOUR-SECRET');
```

Replace `YOUR-KEY` and `YOUR-SECRET` with the information that Google provided you when you created your API key/secret pair. Having the API keys stored in the `wp-config.php` file, helps protect the privacy and security of your api credentials. For even better protection you can enable domain whitelists with the Google ReCaptcha API (recommended).
