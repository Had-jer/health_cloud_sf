<?php

namespace App\Security\Voter;

use App\Entity\MedicalEventSummary;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class MedicalEventSummaryVoter extends Voter
{
    // Définir les permissions possibles
    public const CREATE = 'MEDICAL_EVENT_SUMMARY_CREATE';
    public const EDIT = 'MEDICAL_EVENT_SUMMARY_EDIT';
    public const DELETE = 'MEDICAL_EVENT_SUMMARY_DELETE';

    /**
     * Cette méthode détermine si le voter doit s'appliquer
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        // Pour CREATE, pas besoin de subject
        if ($attribute === self::CREATE) {
            return true;
        }

        // Pour EDIT et DELETE, le subject doit être un MedicalEventSummary
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof MedicalEventSummary;
    }

    /**
     * Cette méthode contient la logique d'autorisation
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
     * Vérifie si l'utilisateur peut créer un résumé d'événement médical
     */
    private function canCreate(User $user): bool
    {
        // Un docteur peut toujours créer un résumé
        return true;
    }

    /**
     * Vérifie si l'utilisateur peut modifier un résumé d'événement médical
     */
    private function canEdit(MedicalEventSummary $summary, User $user): bool
    {
        // Option 1: N'importe quel docteur peut modifier
        return true;

        // Option 2: Seulement le docteur qui a créé l'événement médical associé peut modifier
        // return $summary->getMedicalEvent()->getDoctor() === $user;
    }

    /**
     * Vérifie si l'utilisateur peut supprimer un résumé d'événement médical
     */
    private function canDelete(MedicalEventSummary $summary, User $user): bool
    {
        // Option 1: N'importe quel docteur peut supprimer
        return true;

        // Option 2: Seulement le docteur qui a créé l'événement médical associé peut supprimer
        // return $summary->getMedicalEvent()->getDoctor() === $user;
    }
}