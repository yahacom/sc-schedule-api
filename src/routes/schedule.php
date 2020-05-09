<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

function getSection($db, $id) {
    $query = "SELECT
                   sport_kind_id as id,
                   kind_title as title
                FROM sport_kinds 
                WHERE sport_kind_id = :section_id;";
    $stmt = $db->prepare($query);
    $stmt->execute(['section_id' => $id]);
    return $stmt->fetch();
}

$app->get('/api/schedule/{section_id}', function (Request $request, Response $response, $args) {
    $data['section'] = getSection($this->db, $args['section_id']);

    $query = "SELECT DISTINCT
                    t.teacher_id as id,
                    t.teacher_name as name,
                    t.teacher_surname as surname,
                    t.teacher_thname as middleName
                FROM
                    teachers as t 
                JOIN trainings as tr 
                    ON t.teacher_id = tr.teacher_id
                JOIN sport_kinds as s
                    ON tr.sport_kind_id = s.sport_kind_id
                WHERE s.sport_kind_id = :section_id
                ORDER BY teacher_surname";
    $stmt = $this->db->prepare($query);
    $stmt->execute($args);
    $data['teachers'] = $stmt->fetchAll();

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
                WHERE t.sport_kind_id = :section_id;";
    $stmt = $this->db->prepare($query);
    $stmt->execute($args);
    $data['schedule'] = $stmt->fetchAll();

    return $response->withJson($data);
});

$app->get('/api/schedule/{section_id}/{teacher_id}', function (Request $request, Response $response, $args) {
    $data['section'] = getSection($this->db, $args['section_id']);

    $query = "SELECT
                   teacher_id as id,
                   teacher_name as name,
                   teacher_surname as surname,
                   teacher_thname as middleName
                FROM teachers
                WHERE teacher_id = :teacher_id;";
    $stmt = $this->db->prepare($query);
    $stmt->execute(['teacher_id' => $args['teacher_id']]);
    $data['teacher'] = $stmt->fetch();

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
    $data['schedule'] = $stmt->fetchAll();

    return $response->withJson($data);
});
