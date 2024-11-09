<?php

return [
    /*
     * DataTables JavaScript global namespace.
     */

    'namespace' => 'BabelDataTable',
    'language' => [],
    /*
     * Default table attributes when generating the table.
     */
    'table' => [
        'class' => 'table',
        'id'    => 'dataTableBuilder',
    ],

    /*
     * Default condition to determine if a parameter is a callback or not.
     * Callbacks needs to start by those terms or they will be casted to string.
     */
    'callback' => ['$', '$.', 'function'],

    /*
     * Html builder script template.
     */
    'script' => 'dashboard::vendor.datatables.script',


    /*
     * Html builder script template for DataTables Editor integration.
     */
    'editor' => 'dashboard::vendor.datatables.editor',
];
