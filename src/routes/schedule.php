<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/api/schedule/{section_id}', function (Request $request, Response $response, $args) {
    $query = "SELECT 
                   teach.teacher_name as name, 
                   teach.teacher_surname as surname, 
                   teach.teacher_thname as middleName, 
                   t.sport_kind_id as sectionId, 
                   t.teacher_id as teacherId, 
                   t.lesson_num as lesson, 
                   t.day_num as day, 
                   l.location_title as location 
                FROM 
                     trainings as t 
                JOIN locations as l 
                    ON t.location_id = l.location_id
                JOIN teachers as teach
                    ON teach.teacher_id = t.teacher_id
                WHERE t.sport_kind_id = :section_id";
    $stmt = $this->db->prepare($query);
    $stmt->execute($args);
    $data = [
        'sectionId' => $args['section_id'],
        'sectionTitle' => 'TITLE',
        'schedule' => $stmt->fetchAll(),
    ];
    return $response->withJson($data);
});

$app->get('/api/schedule/{section_id}/{teacher_id}', function (Request $request, Response $response, $args) {
    $query = "SELECT
                    t.lesson_num as lesson,
                    t.day_num as day,
                    l.location_title as location
                FROM
                    trainings as t
                JOIN locations as l
                    ON t.location_id = l.location_id
                WHERE t.teacher_id = :teacher_id AND t.sport_kind_id = :section_id";
    $stmt = $this->db->prepare($query);
    $stmt->execute($args);
    $data = [
        'sectionId' => $args['section_id'],
        'sectionTitle' => 'TITLE',
        'teacher' => [
            'id' => $args['teacher_id'],
            'name' => '',
            'surname' => '',
            'middleName' => '',
        ],
        'schedule' => $stmt->fetchAll(),
    ];
    return $response->withJson($data);
});
