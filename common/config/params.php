<?php
Yii::setAlias('@yiiroot', realpath(dirname(__FILE__) . '/../../'));
return [
    'currentBranch' => "Ringeliste",
    'adminEmail' => 'post@partners.no',
    'supportEmail' => 'post@partners.no',
    'user.passwordResetTokenExpire' => 3600,
    'baseUrl' => 'https://partners.no/',// Always with end slash
    'enableSms' => true,
    'enableEmail' => true,
    "googleMapApiKey" => "AIzaSyDyziDv02leqwiVKBD9oEH4p1vwh0EoqOU",
    "firebase_conf" => [
        "type" => "service_account",
        "project_id" => "intra-78df4",
        "private_key_id" => "bc9eba55cd910a2b58604863c484e2b8dd6d3d12",
        "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCcEGqG8/PwQW6o\nOmPYDfdAI4c7UIKYTSi7YgMng+JVgAn323vpS6rXqddVdQlaBnRNE2VaD2NeYTHx\nvGeSFlNUJwMfljmzMS5FfR07x+RwFti5/94eOwaaa87sbTZIxGfRBMK1ESDj9Jj9\nvhlUOI3vFTiviRjsv44Xnn3Av/pdHvt+BvkHqSNZJDovJ0In9GmXUv+HNyAqnSxU\nKapQJxX803HAOz7c1C26ig7w+lnjFUwYUMSIbQ7JSHTmZOIQf8LPhn0LgFng04jP\nGUK19tC+nR67r3Q47mtqGWWeuSuiYv2XRGPPS3JNSWT1ARUzIEIn4ofImzFGFe7u\n4hAEpNu7AgMBAAECggEAELhriWDqskN4ZRq4ZsX8RwlnbDHwg/vEUOsr1lh5b9qj\ndsQzrueV+rwuH3BGG7iUTku1MKR0a4CzVqhuWkb9D4eMfJ5eOTYcNIK2lpiQf3fb\nKXZh6FA/oVzKkycSSVKNouXFLJwUr4edupXa5dyXTFW0OI5SNs9BHIO1CmknHEHS\nLJJx5y1SvV+NkVy4ZpX116+2YHZxawZOqi9mVunab/PYKtdMSJIvy2pncuTVA4bi\n+wGN9W2q3S4QkaV12zP6p5FiO7exRPdQHzYR2jiWCIepnqgCDla//P0aLGrD8Gzs\n45IBp1qsME7j8S0LelbfgzEubD3YMjCLIwgJxUwRXQKBgQDNSXZAhB/lgBfB6vx9\nq5qmjCiAf/aHKsBbXEK/iCEbcQbuyDMGXpsECMxNPYYOrX1n1MnUG6ZWK6BrpwX0\nQLGcP3pmtcwKLb6PZqgaty/uBoNXnnoBZWlDMnqqZmgzAdOls+84T+V0bFj2C2HU\nfXlU41Hq0TN3Af+aH79z1iBNFwKBgQDCng5vD9LkiIRxFjxi1hBtI8rXsPpFkC3X\nKrALdLAx72CpAe6fIZS3qeUsm4Im2KAYQkSaPEMqMU0wNwnsdO+k0e2T872Sj3VC\nrB86wuBTNeWZTzVQLVhWJcBp+CsKVuqzABW0Pm8a4gMJY4r+cuHLxwcoJzZFy4Z8\no2n363A0/QKBgAo4kSGvMmNb2FL4Xy/mnmGScuXK+TxLnZ4u3sfogDV8kCrNXvT/\nOtqdkYZ6/LS4YJkN2CquYb7Cl08k1sANhIpSAscgYBNVqbo8EzyZSFKikmGHa22s\nXexRlBft11xKx/3lEpEMMVF1n4xIjstkn+jhFJALcHOJbu9+iyq6S4trAoGAXYt1\naqLTfq+z4VuLyQIVwS/8FvLlSTyFHDBTkB4VdtsVvgbEuM5+Wk2ab3eL9roXMbHg\nobYnnoc2D9/UsEiAy9tv87arv1+fQF3VYPw8sSJt6uPsv04ccMQSmZ0EqyKeC04W\nIJ4F74kFZqTnMWjs6XMQGJfIeYHbcdtmWxlaxM0CgYEApicHJnk8d1z8uCfqdkpq\nw+qO7//8F19tKuQDJa2dHGS7bZTcCPET7N/JuBjhC+hLeVbTnpot5JTns964MB2E\npgtN7gtMTWjqgvCUN60SkOM9gFXjNSb8FUzSJo3Q4NTFG/7L2HkCTrj9kzHNpmn4\nbMiiYpD9Qv1+X3IjrhRGdFA=\n-----END PRIVATE KEY-----\n",
        "client_email" => "firebase-adminsdk-a4uzf@intra-78df4.iam.gserviceaccount.com",
        "client_id" => "110359031164478919232",
        "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
        "token_uri" => "https://oauth2.googleapis.com/token",
        "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
        "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-a4uzf%40intra-78df4.iam.gserviceaccount.com"
    ],

    'slackAlarmRoom' => 'https://hooks.slack.com/services/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',

];
