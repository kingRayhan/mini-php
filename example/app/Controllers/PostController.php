<?php

namespace Example\Controllers;

use MiniPHP\Request;
use MiniPHP\Response;
use MiniPHP\StatusCodes;
use Example\Models\Post;

class PostController
{
    public function index(Request $request, Response $response)
    {
        $posts = Post::all();
        return $response->withJSON([
            'data' => $posts,
        ]);
    }

    public function show(Request $request, Response $response)
    {
        $id = (int) $request->param('id');
        $todo = $this->findById($id);

        if (!$todo) {
            return $response
                ->withStatus(StatusCodes::HTTP_NOT_FOUND)
                ->withJSON(['error' => 'Todo not found']);
        }

        return $response->withJSON(['data' => $todo]);
    }

    public function store(Request $request, Response $response)
    {
        $validator = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'completed' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return $response
                ->withStatus(StatusCodes::HTTP_BAD_REQUEST)
                ->withJSON(['errors' => $validator->errors()]);
        }

        $todo = [
            'id' => count(self::$todos) + 1,
            'title' => $validator->validated()['title'],
            'completed' => $validator->validated()['completed'],
        ];

        return $response
            ->withStatus(StatusCodes::HTTP_CREATED)
            ->withJSON(['data' => $todo]);
    }

    public function update(Request $request, Response $response)
    {
        $id = (int) $request->param('id');
        $todo = $this->findById($id);

        if (!$todo) {
            return $response
                ->withStatus(StatusCodes::HTTP_NOT_FOUND)
                ->withJSON(['error' => 'Todo not found']);
        }

        $validator = $request->validate([
            'title'     => 'string|min:3|max:255',
            'completed' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $response
                ->withStatus(StatusCodes::HTTP_BAD_REQUEST)
                ->withJSON(['errors' => $validator->errors()]);
        }

        $data = $validator->validated();
        $todo['title'] = $data['title'] ?? $todo['title'];
        $todo['completed'] = isset($data['completed']) ? (bool) $data['completed'] : $todo['completed'];

        return $response->withJSON(['data' => $todo]);
    }

    public function destroy(Request $request, Response $response)
    {
        $id = (int) $request->param('id');
        $todo = $this->findById($id);

        if (!$todo) {
            return $response
                ->withStatus(StatusCodes::HTTP_NOT_FOUND)
                ->withJSON(['error' => 'Todo not found']);
        }

        return $response
            ->withStatus(StatusCodes::HTTP_OK)
            ->withJSON(['message' => 'Todo deleted']);
    }

    private function findById(int $id): ?array
    {
        foreach (self::$todos as $todo) {
            if ($todo['id'] === $id) {
                return $todo;
            }
        }
        return null;
    }
}
