<?php

return [
    'models' => [
        'user' => 'ユーザー',
        'organization' => '組織',
        'member' => 'メンバー',
        'client' => 'クライアント',
    ],
    'attributes' => [
        'user' => [
            'id' => 'ID',
            'name' => '氏名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'password_confirmation' => 'パスワード（確認）',
            'remember_token' => 'トークン',
            'created_at' => '登録日時',
            'updated_at' => '更新日時',
        ],
        'organizations' => [
            'id' => 'ID',
            'name' => '組織名',
            'created_at' => '登録日時',
            'updated_at' => '更新日時',
        ],
        'member' => [
            'id' => 'ID',
            'organization_id' => '組織ID',
            'user_id' => 'ユーザーID',
            'role' => '権限',
            'selected' => '選択中かどうか',
            'created_at' => '登録日時',
            'updated_at' => '更新日時',
        ],
        'client' => [
            'id' => 'ID',
            'organization_id' => '組織ID',
            'name' => 'クライアント名',
            'contact_name' => '担当者名',
            'email' => 'メールアドレス',
            'postal_code' => '郵便番号',
            'prefecture' => '都道府県',
            'prefecture_id' => '都道府県ID',
            'address1' => '住所',
            'address2' => '建物名',
            'remarks' => '備考',
            'created_at' => '登録日時',
            'updated_at' => '更新日時',
        ],
    ],
    'enums' => [
        'client' => [
            'country' => [
                'japan' => '日本',
                'china' => '中国',
                'koria' => '韓国',
                'america' => 'アメリカ'
            ],
            'client_type' => [
                'all' => '両方可能',
                'proposal_only' => '案件のみ可能',
                'personnel_only' => '要員のみ可能',
            ],
        ],
    ],
];
