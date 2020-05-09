<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/api/sections', function (Request $request, Response $response) {
    $query = 'SELECT
                    sport_kind_id as sectionId,
                    kind_title as title
                FROM sport_kinds
                ORDER BY kind_title';
    $data = $this->db->query($query)->fetchAll();
    return $response->withJson($data);
});
