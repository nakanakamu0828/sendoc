<?php

return [
    'models' => [
        'user' => 'User',
        'organization' => 'Organization',
        'member' => 'Member',
        'client' => 'Client',
        'source' => 'Source',
        'payee'  => 'Payee',
        'invoice' => 'Invoice',
        'invoice_item' => 'Invoice Item',
        'estimate' => 'Estimate',
        'estimate_item' => 'Estimate Item',
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
            'contact_name' => 'Contact Name',
            'email' => 'EMail',
            'postal_code' => 'Postal Code',
            'address1' => 'Address',
            'address2' => 'Address',
            'address3' => 'Address',
            'remarks' => 'Remarks',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ],
        'source' => [
            'id' => 'ID',
            'organization_id' => 'Organization ID',
            'name' => 'Name',
            'contact_name' => 'Contact Name',
            'email' => 'EMail',
            'tel' => 'TEL',
            'postal_code' => 'Postal Code',
            'address1' => 'Address',
            'address2' => 'Address',
            'address3' => 'Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ],
        'payee' => [
            'id' => 'ID',
            'source_id' => 'Source ID',
            'detail' => 'Detail',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ],
        'invoice' => [
            'id' => 'ID',
            'organization_id' => 'Organization ID',
            'title' => 'Title',
            'invoice_no' => 'Invoice No.',
            'client_id' => 'Client ID',
            'recipient' => 'Recipient',
            'recipient_title' => 'Recipient Title',
            'recipient_contact' => 'Recipient Contact',
            'source_id' => 'Srouce ID',
            'sender' => 'Sender',
            'sender_contact' => 'Sender Contact',
            'sender_email' => 'Sender EMail',
            'sender_tel' => 'Sender TEL',
            'sender_postal_code' => 'Sender',
            'sender_address1' => 'Sender Address1',
            'sender_address2' => 'Sender Address2',
            'sender_address3' => 'Sender Address3',
            'date' => 'date of issue',
            'due' => 'Due Date',
            'in_tax' => 'In Tax',
            'tax_rate' => 'Tax Rate',
            'remarks' => 'Remarks',
            'subtotal' => 'Subtotal',
            'tax' => 'Tax',
            'total' => 'Total',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ],
        'invoice_item' => [
            'id' => 'ID',
            'invoice_id' => 'Invoice ID',
            'name' => 'Item Name',
            'price' => 'Price',
            'quantity' => 'Quantity',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
         ],
         'estimate' => [
             'id' => 'ID',
             'organization_id' => 'Organization ID',
             'title' => 'Title',
             'estimate_no' => 'Estimate No.',
             'client_id' => 'Client ID',
             'recipient' => 'Recipient',
             'recipient_title' => 'Recipient Title',
             'recipient_contact' => 'Recipient Contact',
             'source_id' => 'Srouce ID',
             'sender' => 'Sender',
             'sender_contact' => 'Sender Contact',
             'sender_email' => 'Sender EMail',
             'sender_tel' => 'Sender TEL',
             'sender_postal_code' => 'Sender',
             'sender_address1' => 'Sender Address1',
             'sender_address2' => 'Sender Address2',
             'sender_address3' => 'Sender Address3',
             'date' => 'date of issue',
             'due' => 'Due Date',
             'in_tax' => 'In Tax',
             'tax_rate' => 'Tax Rate',
             'remarks' => 'Remarks',
             'subtotal' => 'Subtotal',
             'tax' => 'Tax',
             'total' => 'Total',
             'created_at' => 'Created At',
             'updated_at' => 'Updated At',
         ],
         'estimate_item' => [
             'id' => 'ID',
             'estimate_id' => 'Estimate ID',
             'name' => 'Item Name',
             'price' => 'Price',
             'quantity' => 'Quantity',
             'created_at' => 'Created At',
             'updated_at' => 'Updated At',
          ],
    ],
    'enums' => [
        'client' => [
        ]
    ],
];
