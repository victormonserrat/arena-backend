<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class GenerateKeysCommand.
 */
class GenerateKeysCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('arena:security:keys')
            ->setDescription('Generate JWT keys')
            ->addArgument('password', InputArgument::REQUIRED, 'Password for key files')
            ->addOption('force', 'f', null, 'Force to overwrite old keys');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $password = $input->getArgument('password');
        $force = $input->getOption('force');

        $jwt_private_key_path = $this->getContainer()->getParameter('jwt_private_key_path');
        $jwt_public_key_path = $this->getContainer()->getParameter('jwt_public_key_path');

        if (file_exists($jwt_private_key_path) && $force === false) {
            throw new InvalidArgumentException('There are old keys. You must need to use --force option to overwrite it.');
        }

        $this->createDir($jwt_private_key_path);

        $builder = new ProcessBuilder();
        $builder->setPrefix('openssl');

        // $ openssl genrsa -out app/var/jwt/private.pem -aes256 4096
        $builder->setArguments([
            'genrsa',
            '-passout',
            'pass:'.$password,
            '-out',
            $jwt_private_key_path,
            '-aes256',
            '4096',
        ]);
        $process = $builder->getProcess();
        $process->run();
        $process->wait();

        // $ openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem
        $builder->setArguments([
            'rsa',
            '-passin',
            'pass:'.$password,
            '-pubout',
            '-in',
            $jwt_private_key_path,
            '-out',
            $jwt_public_key_path,
        ]);
        $process = $builder->getProcess();
        $process->run();
        $process->wait();

        $output->writeln('Public and private keys created successfully.');
        $output->writeln('Remember to configure "jwt_key_pass_phrase" option in your parameters.yml file to: '.$password);
    }

    /**
     * @param $path
     */
    private function createDir($path)
    {
        $fs = new Filesystem();

        try {
            $fs->mkdir(dirname($path));
        } catch (IOExceptionInterface $e) {
            echo 'An error occurred while creating your directory at '.$e->getPath();
        }
    }
}
