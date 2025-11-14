<?php

namespace App\Security\Voter;

use App\Entity\MedicalEvent;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class MedicalEventVoter extends Voter
{
    // Définir les permissions possibles
    public const CREATE = 'MEDICAL_EVENT_CREATE';
    public const EDIT = 'MEDICAL_EVENT_EDIT';
    public const DELETE = 'MEDICAL_EVENT_DELETE';

    /**
     * Cette méthode détermine si le voter doit s'appliquer
     * Elle est appelée pour chaque vérification de permission
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        // Le voter s'applique si :
        // 1. L'attribut est l'une de nos permissions définies
        // 2. Le subject est null (pour CREATE) ou un MedicalEvent (pour EDIT/DELETE)
        
        if ($attribute === self::CREATE) {
            return true; // Pour CREATE, pas besoin de subject
        }

        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof MedicalEvent;
    }

    /**
     * Cette méthode contient la logique d'autorisation
     * Elle est appelée uniquement si supports() retourne true
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // L'utilisateur doit être authentifié
        if (!$user instanceof User) {
            return false;
        }

        // Vérifier que l'utilisateur est un docteur
        if ($user->getStatus() !== 'doctor') {
            return false;
        }

        // Logique selon l'action demandée
        return match ($attribute) {
            self::CREATE => $this->canCreate($user),
            self::EDIT => $this->canEdit($subject, $user),
            self::DELETE => $this->canDelete($subject, $user),
            default => false,
        };
    }

    /**
     * Vérifie si l'utilisateur peut créer un événement médical
     */
    private function canCreate(User $user): bool
    {
        // Un docteur peut toujours créer
        return true;
    }

    /**
     * Vérifie si l'utilisateur peut modifier un événement médical
     */
    private function canEdit(MedicalEvent $medicalEvent, User $user): bool
    {
        // Option 1: N'importe quel docteur peut modifier
        return true;

        // Option 2: Seulement le docteur qui a créé l'événement peut le modifier
        // return $medicalEvent->getDoctor() === $user;
    }

    /**
     * Vérifie si l'utilisateur peut supprimer un événement médical
     */
    private function canDelete(MedicalEvent $medicalEvent, User $user): bool
    {
        // Option 1: N'importe quel docteur peut supprimer
        return true;

        // Option 2: Seulement le docteur qui a créé l'événement peut le supprimer
        // return $medicalEvent->getDoctor() === $user;
    }
}