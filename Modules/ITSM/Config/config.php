<?php

return [
    'name' => 'ITSM',

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
];
