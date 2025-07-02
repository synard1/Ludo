<?php

return [
    'name' => 'ITSM',

    'change' => [

        'priority' => [
            'high' => 'High',
            'medium' => 'Medium',
            'low' => 'Low',
        ],

        'status' => [
            'open' => 'Open',
            'rejected' => 'Rejected',
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'approved' => 'Approved',
        ],

        'series'   => 'CHG', // Default if not exist in db
        'sequence' => 1,
        'year' => date('Y'),

        /*
         * Sequence will be padded accordingly, for ex. 001
         */
        'sequence_padding' => 3,
        'delimiter'        => '',

        /*
         * Supported tags {SERIES}, {YEAR}, {DELIMITER}, {SEQUENCE}
         * Example: INC2024001
         */
        'format' => '{SERIES}{YEAR}{DELIMITER}{SEQUENCE}',

    ],

    'incident' => [
        'series'   => 'INC', // Default if not exist in db
        'sequence' => 1,
        'year' => date('Y'),

        /*
         * Sequence will be padded accordingly, for ex. 001
         */
        'sequence_padding' => 3,
        'delimiter'        => '',

        /*
         * Supported tags {SERIES}, {YEAR}, {DELIMITER}, {SEQUENCE}
         * Example: INC2024001
         */
        'format' => '{SERIES}{YEAR}{DELIMITER}{SEQUENCE}',
    ],

    'workorder' => [
        'series'   => 'WO', // Default if not exist in db
        'sequence' => 1,
        'year' => date('Y'),

        /*
         * Sequence will be padded accordingly, for ex. 001
         */
        'sequence_padding' => 3,
        'delimiter'        => '',

        /*
         * Supported tags {SERIES}, {YEAR}, {DELIMITER}, {SEQUENCE}
         * Example: WO2024001
         */
        'format' => '{SERIES}{DELIMITER}{YEAR}{DELIMITER}{SEQUENCE}',

        'priority' => [
            'High' => 'High',
            'Medium' => 'Medium',
            'Low' => 'Low',
            'Normal' => 'Normal',
            'Critical ' => 'Critical',
        ],

        'status' => [
            'Open' => 'Open',
            'In Progress' => 'In Progress',
            'Completed' => 'Completed',
            'Pending' => 'Pending',
            'Cancelled' => 'Cancelled',
            'Needs Review' => 'Needs Review',
            'Overdue' => 'Overdue',
        ],
    ],

    'logbook' => [
        'status' => [
            'Cancelled' => 'Cancelled',
            'Needs Changes' => 'Needs Changes',
            'Needs Review' => 'Needs Review',
            'Approved' => 'Approved',
        ],
    ],
];
