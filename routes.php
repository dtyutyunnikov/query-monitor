<?php

return [
    'GET/threads/(\d+)/?' => function ($app, $id = null) {
        $res = $app->db->prepare('SELECT `argument` FROM `mysql`.`general_log` WHERE `command_type` = "Query" AND `thread_id` = :id');
        $res->execute([':id' => (int) $id]);
        return [
            'title'   => 'List of Queries',
            'content' => $app->render('queries.php', ['rows' => $res->fetchAll()]),
        ];
    },
    'GET' => function ($app) {
        $status = $app->db->query('SELECT @@GLOBAL.general_log;')->fetchColumn();
        $res = $app->db->query(
            'SELECT `event_time` AS `time`, `thread_id` AS `id`, count(`thread_id`) AS `queries`'
            . ' FROM `mysql`.`general_log` GROUP BY `thread_id` ORDER BY `thread_id` ASC'
        );
        return [
            'title'   => 'Overview',
            'content' => $app->render('index.php', [
                'rows'   => $res->fetchAll(),
                'status' => $status,
            ]),
        ];
    },
    'POST/enable/?' => function ($app) {
        $app->db->exec(
            'SET global general_log = 1; SET global log_output = "table";'
        );
        $app->redirect('/');
    },
    'POST/disable/?' => function ($app) {
        $app->db->exec(
            'SET global general_log = 0; TRUNCATE `mysql`.`general_log`;'
        );
        $app->redirect('/');
    },
];
