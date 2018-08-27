Contao Sentry Bundle
====================

This Contao bundle provides an easy integration of [sentry.io](https://sentry.io/) for Contao 4.4.x and newer.

[![Author](http://img.shields.io/badge/author-@1upgmbh-blue.svg?style=flat-square)](https://twitter.com/1upgmbh)
[![Software License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Total Downloads](http://img.shields.io/packagist/dt/oneup/contao-sentry-bundle.svg?style=flat-square)](https://packagist.org/packages/oneup/contao-sentry-bundle)

--

In the first place, this is an "wrapper extension" for the [`sentry/sentry-symfony` bundle][1]. Therefore, you need to
configure this bundle as you would configure the `sentry/sentry-symfony` bundle: [Documentation][2]

### User feedback

On the other hand you might want to implement the [User feedback][3] feature of sentry. The user feedback is primarily
useful to let the users know that you've gotten notified about the issue and to let users give the opportunity to add
some comments.

In order to integrate this feature, you have to alter the error page template. Place a copy of 
`vendor/contao/core-bundle/src/Resources/views/Error/layout.html.twig` in the directory 
`app/Resources/ContaoCoreBundle/views/Error/`.

Modify the copied template and place the following snippet just before the closing `</body>` tag:
```twig
    {% set sentry_id = ''|sentry_last_event_id %}
    {% if sentry_id %}
        <script src="https://cdn.ravenjs.com/3.23.1/raven.min.js"></script>
        <script>
            Raven.showReportDialog({
                eventId: '{{ sentry_id }}',
                dsn: '{{ ''|sentry_dsn }}'
            });
        </script>
    {% endif %}
```

![User Feedback in action][4]


[1]: https://github.com/getsentry/sentry-symfony/
[2]: https://github.com/getsentry/sentry-symfony/#step-3-configure-the-sdk
[3]: https://docs.sentry.io/learn/user-feedback/
[4]: https://user-images.githubusercontent.com/1284725/41782120-a06637f0-7639-11e8-96d7-a053e7ddd232.png