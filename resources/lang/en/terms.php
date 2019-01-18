<?php

return [
    'actions' => [
        'no_actions' => 'No actions available',
        'no_records' => 'No records found',

        /**
         * Model to be used when creating a new crud.
         */
        'resource' => [
            'label' => 'Resources',
            'index' => 'Listing resources',
            'show' => 'View resource',
            'new' => 'Create resource',
            'edit' => 'Edit resource',
            'save' => 'Save changes',

            'confirmation' => [
                'delete' => 'Are you sure?',
            ],

            'success' => [
                'created' => 'Resource created.',
                'updated' => 'Resource updated.',
                'deleted' => 'Resource deleted.',
            ],

            'failed' => [
                'created' => 'Failed to create resource.',
                'updated' => 'Failed to update resource.',
                'deleted' => 'Failed to delete resource.',
            ],
        ],
    ],
];
