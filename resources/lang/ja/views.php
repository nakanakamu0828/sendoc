<?php

return [
    'dashboard' => [
        'help_mail_setting' => 'メールを送信するにはメール情報の設定が必要になります。'
    ],
    'client' => [
        'index' => [
            'help_upload' => '※ CSVファイルを選択することでアップロードが開始されます。',
            'help_csv_charactor' => '※ CSVファイルの文字コードはwindowsを想定してShift-JISとしています',
            'help_download_sample' => '※ CSVのサンプルをダウンロードする方はこちらをクリック',
            'button_register_mail_condition' => '検索条件に一致したBPへメール',
            'button_register_mail_selection' => '選択したBPへメール',
        ],
    ],
    'schedule_mail' => [
        'create' => [
            'danger_not_selection_clients' => 'BPが１つも選択されていない為、メールを作成することができません。'
        ]
    ],
    'invoice' => [
        'pdf' => [
            'due_date' => 'お支払い期限',
            'grand_total' => 'ご請求金額',
            'please_be_advised_that_your_payment_is_listed_below' => '下記の通りご請求いたします。',
            'price' => '金額',
            'subject' => '件名',
        ]
    ],
    'estimate' => [
        'pdf' => [
            'due_date' => 'お支払い期限',
            'grand_total' => 'ご請求金額',
            'please_be_advised_that_your_payment_is_listed_below' => '下記の通りご請求いたします。',
            'price' => '金額',
            'subject' => '件名',
        ]
    ],
    'member' => [
        'index' => [
            'invite_members_to' => ':nameにメンバーを招待',
        ]
    ]
    
];
