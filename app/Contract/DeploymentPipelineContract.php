<?php

namespace App\Contract;

interface DeploymentPipelineContract
{
    public function runTests(): bool;

    public function buildApplicationImage(string $environment): bool;

    public function deploy(string $branch, string $environment): bool;

    public function getDeploymentStatus(string $deploymentId): string;

    public function notifyDeployment(string $message): bool;
}
