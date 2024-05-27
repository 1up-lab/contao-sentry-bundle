Contao Sentry Bundle
====================

This Contao bundle provides an easy integration of [sentry.io](https://sentry.io/) for Contao 4.13 and 5.x.

[![Author](http://img.shields.io/badge/author-@1upgmbh-blue.svg?style=flat-square)](https://twitter.com/1upgmbh)
[![Software License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Total Downloads](http://img.shields.io/packagist/dt/oneup/contao-sentry-bundle.svg?style=flat-square)](https://packagist.org/packages/oneup/contao-sentry-bundle)

--

This is a "wrapper extension" for the [`sentry/sentry-symfony` bundle][1].


### Setup in the Contao Managed Edition

The basic integration is automatically configured to some sane defaults. To enable
the integration, configure the `SENTRY_DSN` variable in your `.env.local` file.

Additionally, you can name the `SENTRY_ENV` in your `.env.local` file, which can be useful
if you e.g. have a `test` and `prod` installation.

If you need to change any of the defaults, simply configure 
the `sentry/sentry-symfony` bundle according to the [Documentation][2].


### Manual configuration

If you do not use the Contao Managed Edition, you need to configure this bundle as you would 
configure the `sentry/sentry-symfony` bundle: [Documentation][2]


## User feedback

On the other hand you might want to implement the [User feedback][3] feature of sentry. The user feedback is primarily
useful to let the users know that you've gotten notified about the issue and to let users give the opportunity to add
some comments.

In order to integrate this feature, you have to alter the error page template. Place a copy of 
`vendor/contao/core-bundle/src/Resources/views/Error/layout.html.twig` in the directory 
`templates/ContaoCoreBundle/views/Error/`.

Modify the copied template and place the following snippet just before the closing `</body>` tag:
```twig
{% set sentry_id = ''|sentry_last_event_id %}
{% if sentry_id %}
    <script src="https://browser.sentry-cdn.com/5.7.1/bundle.min.js"
            integrity="sha384-KMv6bBTABABhv0NI+rVWly6PIRvdippFEgjpKyxUcpEmDWZTkDOiueL5xW+cztZZ"
            crossorigin="anonymous"></script>
    <script>
        Sentry.init({dsn: '{{ ''|sentry_dsn }}'});
        Sentry.showReportDialog({eventId: '{{ sentry_id }}'})

        // You can also bind the "show" method to an event, e.g. to open the modal on button click
        {#document.querySelector('.btn-report').addEventListener('click', function (e) {#}
        {#    e.preventDefault();#}
        {#    Sentry.showReportDialog({eventId: '{{ sentry_id }}'})#}
        {#});#}
    </script>
{% endif %}
```

![User Feedback in action][4]


## Error tracking helper

The `Oneup\ContaoSentryBundle\ErrorHandlingTrait` adds useful Sentry helpers.

- `ErrorHandlingTrait::sentryOrThrow` will either log an error/exception to sentry,
  or it will throw an exception if Sentry integration is not available (e.g. on localhost
  or in `dev` environment). It is mostly useful when running looping cronjobs, like
  synchronizing Contao with a remote system, so an error on syncing a record will not prevent
  the sync loop from finishing other records.

- `ErrorHandlingTraig::sentryCheckIn` has been added for the new [Sentry Cron job monitoring][5].
  Call `sentryCheckIn()` without argument to start a check in, and subsequently with a boolean
  `true` or `false` after the job has successfully run or failed.



[1]: https://github.com/getsentry/sentry-symfony/
[2]: https://docs.sentry.io/platforms/php/guides/symfony/#install
[3]: https://docs.sentry.io/learn/user-feedback/
[4]: https://user-images.githubusercontent.com/1284725/41782120-a06637f0-7639-11e8-96d7-a053e7ddd232.png
[5]: https://docs.sentry.io/product/crons/
