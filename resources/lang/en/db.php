<?php

return [
    'models' => [
        'user' => 'User',
        'organization' => 'Organization',
        'member' => 'Member',
        'client' => 'Client',
    ],
    'attributes' => [
        'user' => [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'EMail',
            'password' => 'Password',
            'password_confirmation' => 'Password Confirmation',
            'remember_token' => 'Remember Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ],
        'organizations' => [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ],
        'member' => [
            'id' => 'ID',
            'organization_id' => 'Organization ID',
            'user_id' => 'User ID',
            'role' => 'Role',
            'selected' => 'Selected',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ],
        'client' => [
            'id' => 'ID',
            'organization_id' => 'Organization ID',
            'name' => 'Name',
            'country' => 'Country',
            'contact_name' => 'Contact Name',
            'email' => 'EMail',
            'user_id' => 'User ID',
            'user' => 'User',
            'client_type' => 'Type',
            'postal_code' => 'Postal Code',
            'prefecture' => 'Prefecture',
            'prefecture_id' => 'Prefecture ID',
            'address1' => 'Address',
            'address2' => 'Building',
            'remarks' => 'Remarks',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ],
    ],
    'enums' => [
        'client' => [
            'country' => [
                'japan' => 'Japan',
                'china' => 'China',
                'koria' => 'Koria',
                'america' => 'Amerika'
            ],
            'client_type' => [
                'all' => 'ALL',
                'proposal_only' => 'Proposal Only',
                'personnel_only' => 'Personnel Only',
            ],
        ]
    ],
];
