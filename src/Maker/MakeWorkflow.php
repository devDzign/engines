<?php

declare(strict_types=1);

namespace App\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\MakerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Filesystem\Filesystem;

class MakeWorkflow implements MakerInterface
{
    public static function getCommandName(): string
    {
        return 'make:ii-workflow';
    }

    public static function getCommandDescription(): string
    {
        return 'Génère une classe Workflow et une classe Activity avec Symfony Maker';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command
            ->addArgument('domain', InputArgument::REQUIRED, 'Le nom du domaine (e.g. Finance)')
            ->addArgument('workflowName', InputArgument::REQUIRED, 'Le nom du workflow')
            ->addArgument('activityName', InputArgument::REQUIRED, 'Le nom de l\'activité');
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        // Récupération des données d'entrée
        $domain = $input->getArgument('domain');
        $nameWorkflow = $input->getArgument('workflowName');
        $nameActivity = $input->getArgument('activityName');
        $nameWorkflowLower = strtolower($nameWorkflow);

        // Chemins des dossiers
        $baseDir = sprintf('src/%s/Activities', $domain);
        $workflowDir = sprintf('src/%s/Workflow', $domain);

        // Initialiser le système de fichiers
        $filesystem = new Filesystem();

        // Créer les dossiers
        $filesystem->mkdir([$baseDir, $workflowDir]);

        // Contenu du fichier Workflow PHP
        $workflowClassContent = <<<PHP
        <?php

        declare(strict_types=1);

        namespace App\\$domain\\Workflow;

        use App\Core\Workflow\AbstractIIWorkflow;
        use App\\$domain\\Activities\\{$nameActivity}Activity;

        class {$nameWorkflow}Workflow extends AbstractIIWorkflow
        {
            public const string WORKFLOW_NAME = '{$nameWorkflowLower}.workflow';

            public function execute(): string
            {
                // Appel de l'activité depuis le workflow
                \$response = \$this->make({$nameActivity}Activity::class)->execute();

                // Implémentation du workflow ici
                return \$response;
            }
        }

        PHP;

        // Chemin du fichier Workflow PHP
        $workflowFile = sprintf('%s/%sWorkflow.php', $workflowDir, $nameWorkflow);

        // Créer le fichier avec le contenu Workflow
        $filesystem->dumpFile($workflowFile, $workflowClassContent);

        // Contenu du fichier Activity PHP
        $activityClassContent = <<<PHP
        <?php

        declare(strict_types=1);

        namespace App\\$domain\\Activities;

        use App\Core\Activities\AbstractActivity;

        class {$nameActivity}Activity extends AbstractActivity
        {
            public function execute(): string
            {
                return 'Rapport inter invest';
            }
        }

        PHP;

        // Chemin du fichier Activity PHP
        $activityFile = sprintf('%s/%sActivity.php', $baseDir, $nameActivity);

        // Créer le fichier avec le contenu Activity
        $filesystem->dumpFile($activityFile, $activityClassContent);

        // Confirmation pour l'utilisateur
        $io->success(sprintf('Le workflow "%s" et l\'activité "%s" ont été générés avec succès dans le domaine "%s".', $nameWorkflow, $nameActivity, $domain));
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
        // Ajouter des dépendances si nécessaire
    }

    public function interact(InputInterface $input, ConsoleStyle $io, Command $command)
    {
        // TODO: Implement interact() method.
    }
}