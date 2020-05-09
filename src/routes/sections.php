<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/api/sections', function (Request $request, Response $response) {
    $query = 'SELECT * FROM sport_kinds ORDER BY kind_title';
    try {
        $data = $this->db->query($query)->fetchAll();
        return $response->withJson($data);
    } catch (PDOException $e) {
        return $response->withJson(['error' => ['text' => $e->getMessage()]]);
    }
});
