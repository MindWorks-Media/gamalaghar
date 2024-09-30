@component('mail::message')
    # Confirm Email

    Click the button below to confirm your email address:

    @component('mail::button', [
        'url' => $url,
        'style' =>
            'padding-left: 60px; padding-right: 60px; font-size: 16px; display: inline-block; letter-spacing: undefined;',
    ])
        Confirm Email
    @endcomponent

    Thanks,
    Gamala Ghar
@endcomponent
