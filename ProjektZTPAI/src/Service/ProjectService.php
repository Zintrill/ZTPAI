<?php

namespace App\Service;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProjectService
{
    private ProjectRepository $projectRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ProjectRepository $projectRepository, EntityManagerInterface $entityManager)
    {
        $this->projectRepository = $projectRepository;
        $this->entityManager = $entityManager;
    }

    public function getAllProjects(): array
    {
        return $this->projectRepository->findAll();
    }

    public function createProject(Project $project): Project
    {
        $this->entityManager->persist($project);
        $this->entityManager->flush();
        return $project;
    }

    public function updateProject(int $id, array $data): ?Project
    {
        $project = $this->projectRepository->find($id);
        if (!$project) {
            throw new \Exception('Project not found');
        }

        $project->setName($data['name']);
        $project->setDescription($data['description']);
        $project->setCompleted($data['completed'] ?? false);

        $this->entityManager->flush();
        return $project;
    }

    public function deleteProject(int $id): void
    {
        $project = $this->projectRepository->find($id);
        if ($project) {
            $this->entityManager->remove($project);
            $this->entityManager->flush();
        }
    }
}
