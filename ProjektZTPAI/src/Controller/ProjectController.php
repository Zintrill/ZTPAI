<?php

namespace App\Controller;

use App\Entity\Project;
use App\Service\ProjectService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/projects')]
class ProjectController extends AbstractController
{
    private ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    #[Route('', methods: ['GET'])]
    public function getAllProjects(): JsonResponse
    {
        $projects = $this->projectService->getAllProjects();
        return $this->json($projects);
    }

    #[Route('', methods: ['POST'])]
    public function createProject(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $project = new Project();
        $project->setName($data['name']);
        $project->setDescription($data['description']);
        $project->setCompleted($data['completed'] ?? false);

        $newProject = $this->projectService->createProject($project);
        return $this->json($newProject);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function updateProject(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $project = new Project();
        $project->setName($data['name']);
        $project->setDescription($data['description']);
        $project->setCompleted($data['completed'] ?? false);

        $updatedProject = $this->projectService->updateProject($id, $project);
        return $this->json($updatedProject);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function deleteProject(int $id): JsonResponse
    {
        $this->projectService->deleteProject($id);
        return new JsonResponse(['message' => 'Project deleted successfully']);
    }
}
