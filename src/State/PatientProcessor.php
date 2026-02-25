<?php
namespace App\State;

// Assure-toi d'avoir ces imports en haut du fichier
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use ApiPlatform\Metadata\Operation;
use App\Entity\Patient;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;



class PatientProcessor implements ProcessorInterface
{
    public function __construct(
        // On précise ici quel service précis de Doctrine on veut utiliser
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private readonly ProcessorInterface $persistProcessor,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {}

    // ... le reste de ton code reste identique


    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []) {
    if ($data instanceof Patient && $data->getUser()->getPlainPassword()) {
        $user = $data->getUser();
        // Hashage du mot de passe
        $hashed = $this->passwordHasher->hashPassword($user, $user->getPlainPassword());
        $user->setPassword($hashed);
        $user->eraseCredentials();
    }
    return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
}
}