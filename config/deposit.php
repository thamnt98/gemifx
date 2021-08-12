<?php
return [
    'bepay' => [
        'merchant_id' => 'B1000038',
        'secret_key' => 'DNYgNYT4Ab8DnFG1',
        'type' => 2
    ],
    'winpay' => [
        'api_key' => '210-krAIqJFumVXOGjYycZUo',
        'url' => 'https://vwinpay.com/api/info'
    ],
    'exnpay' => [
        'merchant_id' => 'U100009',
        'secret_key' => '10$Vme25JFfi.Zrv',
        'type' => 2
    ],
    'vifa' => [
        'server_url' => 'https://apivnd.vifaotc.com/trade',
        'app_id' => '1606376100185',
        'app_private_key' => 'MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAJ5b33JxhiUhPU7bwZLXeyFUBzkga3qYk+G4ACEw8OVLywumVbj6Rj1envCJwwVmVy0kAEkSPKOzw22JjcaosKZzGGshF3D+nbhpcrsPbf1KbZBBHxVZP2ppP7QGQW7z6y8Luaxktjm5XcuXhd80mF8OhcvFj0tfDZ+BJKGSjic7AgMBAAECgYBbPPWlm1C9jcQj7is+LlZr4lzzBgHGtafmUbwJY4g3pA6NXL1hARl8/Eo4rjaloswxXt+nOhGkA8tiDfGYdtKnekKaH/HhgO/E3wwfZnBII+oK++kjWEg683OCJsaMTm/WEVXElEax0ma7mSlARLeVvmOoya7YG3wc1X4a1ZBCcQJBAOOKQYWJMIngdIzZjdXWe1rxBVfyTU2pTH7JhP1GYlJ99Ywt9e8gmzqSHXUqg6ta0VDTHbo77/H0sGKbmnBV5GMCQQCyKnZdg2hj+I5cHtMagGsUTnsnoUcW/+9eHae/iyCOfxKPeQO3HdUNUVMN9tD/PpuzbHyqEkByawdrwFQs3Q1JAkAqJjY08lDXeYidfr9TWUPIeNUwkWXYeP/+jH3iHOOhvEt8CBeCkFuw4dgrGBED8PLNMg5TrT6pZ1Y1LfXR0VdZAkEAgFypdMxFPKmKX4Jx08kr3LCCeFXw8vgoDCXPgugI58FTrPyiGZ8rrXGnJgtqHkuMQCPsWVfXCNhlu1MRElWcyQJAStE0eKjqPcu8LO++GhAvCD7BN/X1LUdoeKfpAYG7JVa27PGVPJ2MnJW5dXud9Ufz0BQJa/dYS9iF7U3/+ClVMQ==',
        'server_public_key' => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCGIVgvoo7lKpG+lGcT528tslCH9NWdEo7ZTBocfgm6ub5YledFue2PvQeH3SZcJIpvyMMIlFFm0Ff7R7Qp7+3oshb+vWHq2sdFznztvri++LiF/LLIk/8VV/6ViQZk7Rf/r1pvUbykyBXXgN0SwK6ktXhlfX+DTIDfTXkb/VQ6KwIDAQAB',
        'status' => [
            'pending' => 1,
            'completed' => 2
        ]
    ],
    'type' => [
        'vifa' => 1,
        'bepay' => 2,
        'exnpay' => 3,
        'winpay' => 4
    ],
    'type_text' => [
        1 => 'VIFA pay',
        2 => 'e-Banking',
        3 => 'ExnPay',
        4 => 'Vwinpay'
    ],
    'status' => [
        'yes' => 1,
        'pending' => 2,
        'no' => 3
    ],
    'status_text' => [
        1 => 'Approved',
        2 => 'Processing',
        3 => 'Rejected'
    ]
];
